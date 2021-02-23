<?php
	ini_set('display_errors', 1);
	include_once ("class_calc_pdo.php");
	include_once("class_calc_pdo.php");
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') //conexão para ajax
	{
		include_once ("verifica_post_pdo.php");
		$oUtil = new Verifica_POST();		
		if($oUtil->Valida($_POST) == true)//se o formulario estiver completo executa o código
		{
			//tenta conexão com MySQL
			try {
			//inicia uma conexão pdo com o mysql usando os valores das variáveis $username  e $password, além do ip e do nome da database
  			$conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		

			$Numero1 = $_POST["operando1"];//pega o número digitado na caixa de texto com o nome "operando1"
			$Numero2 = $_POST["operando2"];//pega o número digitado na caixa de texto com o nome "operando2"
			$tipo_operacao = $_POST["operacao"];//pega a opção selecionada de operação com o nome "operacao"
			
			
			$dados = $conn->prepare('SELECT operador FROM tbdescricaooperacao WHERE id = (?)');
			$dados ->execute(array($tipo_operacao));//passa $tipo_operacao no lugar da (?) na query
			foreach($dados as $row) {
    			$des = $row['operador'];
    			//print_r($row); 
    		}
    		echo "<br><b>Operação realizada: $Numero1 ".$des." $Numero2</b><br>";//mostra a operação realozada na tela
    		$calc =  new CalculadoraAjax($Numero1, $Numero2, $des);//instância um objeto da classe Calculadora
 			$result = $calc->Executa();
 			echo "<br><b>O resultado da operação é: ".$result."</b>";//imprimi resultado na tela
 			//prepara para inserir os valores digitados, o id da operação e  o resultado da operação na tabela tboperacao
			$insere_tboperacao = $conn->prepare('INSERT INTO tboperacao(valor1,valor2,idoperacao,idresultado) VALUES(?,?,?,?)');
			//executa a query e insere os valores digitados, a o id da operação e  o resultado da operação na tabela tboperacao
 			$insere_tboperacao->execute(array($Numero1,$Numero2,$tipo_operacao,$result));
 			//prepara para inserir o resultado e a data na tabela tbresultao
 			$insere_tbresultao = $conn->prepare('INSERT INTO tbresultao(resultado,datahora) VALUES(?,NOW())');
 			//executa query e insere o resultado e a data na tabela tbresultao
 			$insere_tbresultao->execute(array($result));
 			//inserir o ultimo resultado calculado na tabela memoriacalc
 			$insere_memoriacalc = $conn->prepare('INSERT INTO memoriacalc(result_anterior) VALUES(?)');
        	$insere_memoriacalc->execute(array($result));


		} 	
			catch(PDOException $e) {
   				echo 'ERROR::::: ' . $e->getMessage();//tratamento de erros pdo
			}
		}


 	}
 	else 
 	{
		header('location:index.php');
		
	}
?>

