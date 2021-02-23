<?php 
  	$id_linha = $_POST['linha'];//pega a linha passada por ajax
    //inicia uma conexão pdo com o mysql usando os valores das variáveis $username  e $password, além do ip e do nome da database
    $conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $querydelete = $conn->prepare('DELETE FROM tboperacao WHERE id ='.$id_linha);//apaga linha onde o id é igual ao desejado
    $querydelete->execute();//executa a query
  	echo "Deletado ID = ".$id_linha;
?>