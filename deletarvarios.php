<?php 
	$data = $_POST['vetor'];//pega o vetor passado por ajax na pagina carregar_dados.php


  $conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
	foreach($data as $d){
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 		$querydelete = $conn->prepare('DELETE FROM tboperacao WHERE id ='.$d);//apaga linha onde o id é igual ao $d, que tem o id da linha nele
  	$querydelete->execute();//executa a query
  	echo "Deletado ID = ".$d." | ";
  }
  foreach($data as $d){
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   		$querydelete = $conn->prepare('DELETE FROM tbresultao WHERE id ='.$d);//apaga linha onde o id é igual ao $d, que tem o id da linha nele
    	$querydelete->execute();//executa a query
  }
 ?>