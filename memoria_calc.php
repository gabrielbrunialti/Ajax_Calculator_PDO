<?php
    ini_set('default_charset','UTF-8');
    ini_set('display_errors', 1);
	try 
	{//operações com banco de dados
		//inicia uma conexão pdo com o mysql usando os valores das variáveis $username  e $password, além do ip e do nome da database
  		$conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	//realiza as queries necessárias para pegar os conteúdos das tabelas
        $quantmemoriaquery = $conn->prepare('SELECT id FROM memoriacalc WHERE id = (SELECT MAX(id) FROM memoriacalc)');//encontra o maior id da tabela
        $quantmemoriaquery->execute();
        $quantmemoriaquery->setFetchMode(PDO::FETCH_ASSOC);
        $maxmemoria = $quantmemoriaquery->fetchAll(PDO::FETCH_ASSOC);
        foreach ($maxmemoria as $row) {
        $max = $row['id'];
        }
        $eliminamais10 = $conn->prepare('DELETE FROM memoriacalc WHERE id < '.$max.'');//apaga todos os resultados com id menor que o maximo
        $eliminamais10->execute();
        $query = $conn->prepare('SELECT result_anterior FROM memoriacalc WHERE(id = (SELECT MAX(id) FROM memoriacalc))');//pega o resultado com o maior id
        $query->execute();
    	$query->setFetchMode(PDO::FETCH_ASSOC);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
        $res = $row['result_anterior'];
        }
        echo $res;

    }
    catch(PDOException $e) 
    {
   		echo 'ERROR::::: ' . $e->getMessage();//tratamento de erros pdo
	}
?>
<script type="text/javascript">
    document.getElementById('texto1').value = <?php echo $res; ?>//coloca o valor do result_anterior na caixa de texto com id=texto1
</script>