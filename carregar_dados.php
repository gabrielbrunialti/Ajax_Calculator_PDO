<?php

    session_start();//para poder pegar o valor da pagina vinda do form_pdo.php
    ini_set('default_charset','UTF-8');
    include('tabela_css.php');
    $pagina = ceil($_SESSION['pagina']);//pega a página atual vinda de form_pdo.php
    $registroporpagina = $_POST['quantregistro'];
     //quantidade de registros mostrados por página
    if($registroporpagina == null)
    {
        $registroporpagina=3;
    }
    if($pagina == "") 
        {//se a página for nula ela fica com o valor 1
            $pagina = "1";
        }
	try 
	{//operações com banco de dados
		//inicia uma conexão pdo com o mysql usando os valores das variáveis $username  e $password, além do ip e do nome da database
  		$conn = new PDO("mysql:host=localhost;dbname=projeto", 'root', '');
    	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    	//realiza as queries necessárias para pegar os conteúdos das tabelas
        $inicio = $pagina - 1;
        $inicio =  ($inicio *  $registroporpagina);
        $query_limite = $conn->prepare('SELECT A.id, A.valor1,A.valor2,A.idoperacao,A.idresultado,B.id AS ID_RESULTADO,B.resultado,B.datahora,
                                 C.descricao FROM ((SELECT * FROM tboperacao LIMIT '.$inicio.','.$registroporpagina.') A) INNER JOIN tbresultao B
                                ON(A.id = B.id)
                                INNER JOIN tbdescricaooperacao C 
                                ON(A.idoperacao = C.id)

                                ORDER BY A.id'
                                );//SELECIONA COM NO MAXIMO 5 POR VEZ usando variáveis
        $query_limite->execute();
        $query_limite->setFetchMode(PDO::FETCH_ASSOC);
        $data = $query_limite->fetchAll(PDO::FETCH_ASSOC);
        $query_total = $conn->prepare('SELECT A.id, A.valor1,A.valor2,A.idoperacao,A.idresultado,B.id AS ID_RESULTADO,B.resultado,B.datahora,
                                 C.descricao FROM tboperacao A INNER JOIN tbresultao B
                                ON(A.id = B.id)
                                INNER JOIN tbdescricaooperacao C 
                                ON(A.idoperacao = C.id)

                                ORDER BY A.id'
                                );//SELECIONA TUDO
        $query_total->execute();
        $query_total->setFetchMode(PDO::FETCH_ASSOC);
        $tot_linhas = $query_total->rowCount();
       


        //parte da paginação



        $tot_paginas = ceil($tot_linhas/$registroporpagina);//quantdade total de páginas
        $anterior = $pagina -1;//botão anterior
        $proximo = $pagina +1;//botão próximo
        if ($pagina > $tot_paginas) {
            $pagina=1;

        }
        if ($pagina>1) {//botão anterior
           echo "<a href= form_pdo.php?pagina=$anterior>anterior</a>&nbsp; ";
        }
        for($i=1;$i <= $tot_paginas;$i++) {//mostra a numeração de páginas
            if($i != $pagina) {
                echo " <a href=form_pdo.php?pagina=".($i).">$i</a> | ";
            } 
            else {
                echo " <strong>".$i."</strong> | ";
            }
        }
        if ($pagina<$tot_paginas) {//botão próximo
            echo " <a href=form_pdo.php?pagina=$proximo>próxima</a>";
        }
        echo "<br> <a href=form_pdo.php?pagina=1>voltar para início</a>";
        echo " | <a href=form_pdo.php?pagina=$tot_paginas>ir para o final</a>";

    }
    catch(PDOException $e) 
    {
   		echo 'ERROR::::: ' . $e->getMessage();//tratamento de erros pdo
	}
?>
<html><!-- Montar tabelas em html-->

            <h1>Registro Operações</h1>          
           <!--div com nome result mostra um valor definido em $("#result").html(...) dentro dos if's acima-->
    <body >
    <div id="checkbox-container">
            <table id="tabela1" title="minha tabela" class="minha_tabela"><!--definindo as dimensões da tabela. A class serve para usar as 
            carácteristicas definidas na classe na tabela-->
               <b><div id="result"></div></b>
                <thead>
                    <tr>
                        <th>ID OPERAÇÃO</th><!--colunas da tabela -->
                        <th>VALOR1</th><!--colunas da tabela -->
                        <th>VALOR2</th><!--colunas da tabela -->
                        <th>ID OPERAÇÃO</th><!--colunas da tabela -->
                        <th>RESULTADO OPERAÇÃO</th><!--colunas da tabela -->
                        <th>ID RESULTADO</th><!--colunas da tabela -->
                        <th>resultado</th><!--colunas da tabela -->
                        <th>DATA E HORA</th><!--colunas da tabela -->
                        <th>DESCRIÇÃO</th><!--colunas da tabela -->
                        <th>DELETAR</th>
                        <th><input type="checkbox" id="checkall" value="<?php echo $row['id']; ?>">Selecionar tudo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    	//$data = $query_limite->fetchAll(PDO::FETCH_ASSOC); //já foi feita mais para cima
						foreach($data as $row){ 
                    ?><!--imprimir as colunas de cada linha -->
                        <tr>
                            <td><?php echo ($row['id']);?></td>
                            <td><?php echo ($row['valor1']); ?></td>
                            <td><?php echo ($row['valor2']); ?></td>
                            <td><?php echo ($row['idoperacao']); ?></td>
                            <td><?php echo ($row['idresultado']); ?></td>
                            <td><?php echo ($row['ID_RESULTADO']); ?></td>
                            <td><?php echo ($row['resultado']); ?></td>
                            <td><?php $date = new DateTime( $row['datahora'] ); echo $date->format( 'd-m-Y h:i:s'); ?></td> <!--converte a data para padrão br-->
                            <td><?php $mystring = utf8_encode ( $row['descricao']);
                                echo ($mystring); ?><!--converter data para formato dd/mm/aaaa-->
                            </td><!--passa $row['id'] como parametro para a função myFunction-->
                            <td><input type="image" onclick='myFunction("<?php echo $row['id']; ?>");window.location.reload()' id="myimage" style="height:10px;width:10px;" src="http://icons.iconarchive.com/icons/hopstarter/button/256/Button-Delete-icon.png" /></td>
                            <td> <input type="checkbox" onchange="addbox(value)" id="<?php echo $row['id']; ?>" name="c1"  class="box" value="<?php echo $row['id']; ?>" ><br></td>
                        </tr>
                    <?php }; ?> <!--fim do for each-->
                </tbody>
            </table>
            </div>
    </body>
    <div id="vetor"></div>
</html>
<script  src="http://code.jquery.com/jquery-1.9.1.min.js" ></script>
<script type="text/javascript">
/* não é necessário, o código dentro de tabela_css.php já faz isso
function valoresRow() {//faz com que cada row da tabela seja clicavel
    var table = document.getElementById("tabela1");//escolhe qual tabela será afetada
    var rows = table.rows; // or table.getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
        rows[i].onclick = 
        (
            function() 
            { 
                //var cnt = i; //salva o cnt para usar na function mas ele não é necessário no caso
                return function() //função de retorno
                {
                    var op = this.cells[3].innerHTML;//verifica qual o id da operação e entra no if adequado
                    if(op == 1)//retorna os valores para serem exibidos na div result
                    {
                        //pega as cells necessárias e envia para a div result
                        $("#result").html(this.cells[1].innerHTML+" + "+this.cells[2].innerHTML+" = "+this.cells[4].innerHTML);  
                    }
                    if(op == 2)//retorna os valores para serem exibidos na div result
                    {
                        //pega as cells necessárias e envia para a div result
                        $("#result").html(this.cells[1].innerHTML+" - "+this.cells[2].innerHTML+" = "+this.cells[4].innerHTML);    
                    }
                    if(op == 3)//retorna os valores para serem exibidos na div result
                    {
                        //pega as cells necessárias e envia para a div result
                       $("#result").html(this.cells[1].innerHTML+" / "+this.cells[2].innerHTML+" = "+this.cells[4].innerHTML);    
                    }
                    if(op == 4)//retorna os valores para serem exibidos na div result
                    {
                        //pega as cells necessárias e envia para a div result
                        $("#result").html(this.cells[1].innerHTML+" * "+this.cells[2].innerHTML+" = "+this.cells[4].innerHTML);    
                    }
                }    
            }
        )
        (i);/////////////////????????
    }
}
valoresRow();
</script>
<input type="button" id="botaoapaga"  value="Deletar Linhas Marcadas"> <input type="button" id="cancela" onclick="cancela()" value="cancelar seleção">
<script type="text/javascript">
$("#checkall").click(function(){//marca todas as checkboxes da página
    $('input:checkbox').not(this).prop('checked', this.checked);
});
//verifica quais checkboxes estão marcadas
$('#botaoapaga').click(function() //apaga todas as linhas com checkboxex marcadas
    {
        var vet = ($('.box:checked').map(function() //monta um vetor com os valores das checkboxes marcadas
        {
            return this.value;
        }
        ).get()//.join(', ')
        );
        var vetor = vet;
        //alert(vetor);
        var temp = JSON.parse(localStorage.getItem('vetboxes'));//guarda o valor atual do localstorage
        var concatena = vetor.concat(temp);//junta o vetor com temp para formar um vetor 
        localStorage.setItem('vetboxes', JSON.stringify(concatena));//salva o novo valor no localstorage, que agora é o antigo mais o novo
        $.ajax({//passa o vetor para a página deletarvarios.php 
        type: "POST",
        url: "deletarvarios.php",
        data: {"vetor": concatena}, 
    });
         window.location.reload();
    }
);
</script>
<script type="text/javascript">




//guarda o valor das checkboxes entre as páginas
var vetcheck = [];
var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {},
    $checkboxes = $("#checkbox-container :checkbox");


$checkboxes.on("change", function()
    {
        $checkboxes.each(function()
        {
            checkboxValues[this.id] = this.checked;
            vetcheck.push(this.id);
        }
        );
        localStorage.setItem("checkboxValues", JSON.stringify(checkboxValues));
    }
);

// On page load
$.each(checkboxValues, function(key, value) 
    {
        $("#" + key).prop('checked', value);
    }
);
</script>
