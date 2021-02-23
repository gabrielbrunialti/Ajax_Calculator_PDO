<?php
    ini_set('default_charset','UTF-8');
	try 
	{
		//inicia uma conexão pdo com o mysql usando os valores das variáveis $username  e $password, além do ip e do nome da database
  		$conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	//realiza as queries necessárias para pegar os conteúdos das tabelas
    	$query = $conn->prepare('SELECT A.id, A.valor1,A.valor2,A.idoperacao,A.idresultado,B.id AS ID_RESULTADO,B.resultado,B.datahora,
                                 C.descricao FROM tboperacao A INNER JOIN tbresultao B
                                ON(A.id = B.id)
                                INNER JOIN tbdescricaooperacao C 
                                ON(A.idoperacao = C.id)
                                ORDER BY A.id'
                                );
    	$query->execute();
    	$query->setFetchMode(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) 
    {
   		echo 'ERROR::::: ' . $e->getMessage();//tratamento de erros pdo
	}
?>
<html><!-- Montar tabelas em html-->
    <head>
       <style type="text/css">/* faz a alternância das cores das linhas, onde é par é de uma cor, onde é impar é de outra*/
           /*Definido cor das linhas pares*/
        .minha_tabela tr:nth-child(even) {background: #FFF}
         
        /*Definindo cor das Linhas impáres*/
        .minha_tabela tr:nth-child(odd) {background: #EEE}
       </style>
    </head>
    <body>
        <div id="container">
            <h1>Registro Operações</h1>
            <table class="minha_tabela" width="90%" border="1px" cellspacing="0" cellpadding="1"><!--definindo as dimensões da tabela. A class serve para usar as carácteristicas definidas na classe na tabela-->
                <thead>
                    <tr>
                        <th>ID OPERAÇÃO</th><!--colunas da tabela -->
                        <th>VALOR1</th><!--colunas da tabela -->
                        <th>VALOR2</th><!--colunas da tabela -->
                        <th>ID OPERAÇÃO</th><!--colunas da tabela -->
                        <th>RESULTADO OPERAÇÃO</th><!--colunas da tabela -->
                        <th>ID RESULTADO</th>
                        <th>resultado</th>
                        <th>DATA E HORA</th>
                        <th>DESCRIÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    	$data = $query->fetchAll(PDO::FETCH_ASSOC);
						foreach($data as $row){ ?><!--imprimir as colunas de cada linha -->
                        <tr>
                            <td><?php echo ($row['id']);?></td>
                            <td><?php echo ($row['valor1']); ?></td>
                            <td><?php echo ($row['valor2']); ?></td>
                            <td><?php echo ($row['idoperacao']); ?></td>
                            <td><?php echo ($row['idresultado']); ?></td>
                            <td><?php echo ($row['ID_RESULTADO']); ?></td>
                            <td><?php echo ($row['resultado']); ?></td>
                            <td><?php echo ($row['datahora']); ?></td>
                            <td><?php $mystring = utf8_encode ( $row['descricao']);
                                echo ($mystring); ?>
                            </td>
                        </tr>
                    <?php }; ?> <!--fim do for each-->
                </tbody>
            </table>
    </body>
</div>

</html>
