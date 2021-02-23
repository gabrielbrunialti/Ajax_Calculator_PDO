 <script  src="http://code.jquery.com/jquery-1.9.1.min.js" ></script>
 
<?php
	include_once ("class_calc_pdo.php");
	ini_set('default_charset','UTF-8');
	ini_set('display_errors', 1);
	try
	{
		//inicia uma conexão pdo com o mysql usando os valores das variáveis $username  e $password, além do ip e do nome da database
  		$conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
   		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   		$idlinha = $_POST['idop'];//pega o valor da caixa de texto idop do form_pdo.php
   		$texto1 = $_POST['operando1'];//pega o valor da caixa de texto1 do form_pdo.php
   		$texto2 = $_POST['operando2'];//pega o valor da caixa de texto2 do form_pdo.php
   		$op = $_POST['operacao'];//pega o valor da opção operacao do form_pdo.php
   		$dados = $conn->prepare('SELECT operador FROM tbdescricaooperacao WHERE id = (?)');
		$dados ->execute(array($op));//passa $tipo_operacao no lugar da (?) na query
		foreach($dados as $row) {
   			$des = $row['operador'];
    		//print_r($row); 
    	}
      echo "<br> Linha de id=".$idlinha." alterada!";
   		 echo "<br><b>Operação realizada: $texto1 ".$des." $texto2</b><br>";//mostra a operação realozada na tela
   		 $calc =  new CalculadoraAjax($texto1,$texto2, $des);//instância um objeto da classe Calculadora
 		   $result = $calc->Executa();
 		   echo "<br><b>O resultado da operação é: ".$result."</b>";//imprimi resultado na tela
   		 echo $texto1;
   	   $queryatualiza = $conn->prepare('UPDATE tboperacao SET valor1 = '.$texto1.', valor2='.$texto2.', idresultado='.$result.', idoperacao='.$op.'     WHERE id ='.$idlinha.'');
   		 $queryatualiza->execute();//atualiza a linha da tboperacao
   		 $queryatualizatbresultao = $conn->prepare('UPDATE tbresultao SET resultado = '.$result.', datahora= Now() WHERE id='.$idlinha.'');
   		 $queryatualizatbresultao->execute();//atualiza linha da tbresultao
	}
   	catch(PDOException $e) 
    {
   		echo 'ERROR::::: ' . $e->getMessage();//tratamento de erros pdo
	}
?>