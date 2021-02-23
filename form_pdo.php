<script type="text/javascript">
var vetboxes = [];
 function addbox(id)//quando a checkbox é clicada executa essa função
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
}
function cancela()
{
  localStorage.removeItem("vetboxes");//reseta o vetor
  localStorage.removeItem("checkboxValues");//resete as  checkboxes para unchecked
  $('.box').attr('checked', false); // Unchecks it
  //alert("localsorage: "+localStorage.getItem('vetboxes'));
}
//alert("localsorage: "+localStorage.getItem('vetboxes'));
//localStorage.clear();
//localStorage.removeItem("vetboxes");
</script>
<?php
  session_start();
  ini_set('default_charset','UTF-8');
  ini_set('display_errors', 1);
  include('tabela_css.php');
  
?>

<head>
  <title>Calculadora PDO</title>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script type="text/javascript">


      function myFunction(linha)//função que passa o id da linha a ser apagada
      {
        var idlin = linha;//linha é a linha do botaõa que foi clicado
        alert("Linha de id="+idlin+" deletada!");
        $.ajax(
                {
                  url:"deletelinha.php",
                  type: "POST",
                  data: {"linha": idlin},
                  success: function(response){
                  $("#deletado").html(response);
                }
              }
            );
        }

      $(document).ready(function(e)//ajax do botão calcula
      {   
        $("#calcula").on('submit',(function(e) {
            e.preventDefault();
            $.ajax(
            {
              url:"conexao.php",
              type: "POST",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              beforeSend: function(){
                $("#meudiv").html('Aguarde...');
              },
              success: function(response){
                $("#meudiv").html(response);
              }
            }
          );
          }
        )
      );
      }

    );
      $(document).ready(function(e)//ajax do botão mem
      {
        $("#mem").click(function(e) {
            e.preventDefault();
            $.ajax(
            {
              url:"memoria_calc.php",
              type: "POST",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              beforeSend: function(){
                $("#memoria").html('Aguarde...');
              },
              success: function(response){
                $("#memoria").html(response);
              }
            }
          );
          }
        );
          
      }

    );
      function botaoAtualiza()//se clicar no botão atualiza executa esta função que tem um ajax dentro
      {//tá dando erro por causa da função botapAtualiza/////////////////////////////////////////////////////////////////
        $(document).ready(function(e)//ajax do botão atualiza
      {
        $("#calcula").click(function(e) {
            e.preventDefault();
            $.ajax(
            {
              url:"atualizadados.php",
              type: "POST",
              data: new FormData(this),
              contentType: false,
              cache: false,
              processData: false,
              success: function(response){
              $("#atual").html(response);
              }
            }
          );
          }
        )  
      }

    );
      }
  </script>
</head>
<body>
<form id="calcula"><!-- id="calcula" é igual ao $("#calcula") -->
 <p>Primeiro operando: <input id="texto1" type="text"  name="operando1" placeholder="1º operando: " /></p><!--caixa de texto-->
  <p>Segundo operando: <input id="texto2" type = "text" name ="operando2" placeholder="2º operando: " /></p><!--caixa de texto-->
  <p>Operação: 
  <input id="4" type="radio" name="operacao" value="4">Divisão<!--botão radio-->
  <input id="3" type="radio" name="operacao" value="3">Multiplicação<!--botão radio-->
  <input id="1" type="radio" name="operacao" value="1">Adição <!--botão radio-->
  <input id="2" type="radio" name="operacao" value="2">Subtração<!--botão radio-->
  <br><br>
  Nº de registros por página:
  <select id="quantregistro" onchange ="saveValue(this);window.location.reload()" name="quantregistro"><!--quando troca o valor chama a função quant e passa o valor da opção como paraâmetro-->
  <option value="5">5</option>
  <option value="15" >15</option>
  <option value="25">25</option>
  <option value="50">50</option>
</select>
  <p><button id="calc" type="submit" >Calcular</button>  <button id="mem" type="submit">Resultado Anterior</button>  <button id="atualiza" type="submit" onclick="botaoAtualiza();window.location.reload()">Atualizar Linha</button><!--erro na função chamada-->
</form>
<br/>
<div id="meudiv"></div> <!--mosra o resultado da operação-->
<div id="divtabela"></div><!--mostra a tabela-->
<div id="carregadados"></div>
<div id="memoria"></div>
<div id="atual"></div>
<div id="deletado"></div>
</body>
<script type="text/javascript">//carrega a tabela sem precisar clicar em algum botão na página
//var regpagina = document.getElementById('quantregistro').value;


</script><!--pega a página aual e a passa para o carregar_dados.php para ele carregar a tabela que deveria estar nesta página-->
<?php
   //$pagina = $_GET["pagina"];
  if (!empty($_SESSION['pagina']) && !empty($_GET))
  {
     $_SESSION['pagina'] = $_GET["pagina"];
  }
  else
  {
    $pagina=1;
    $_SESSION['pagina'] = $pagina;
    //$_SESSION['pagina'] = $_GET["pagina"];
  }





?>


<!--guarda o valor do select para ser usado quando a página for recarregada-->
<script type="text/javascript">
document.getElementById("quantregistro").value = getSavedValue("quantregistro");
  function saveValue(e){
            var id = e.id;  // get the sender's id to save it . 
            var val = e.value; // get the value. 
            localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override . 
        }

        //get the saved value function - return the value of "v" from localStorage. 
        function getSavedValue  (v){
            if (localStorage.getItem(v) === null) {
                return "";// You can change this to your defualt value. 
            }
            return localStorage.getItem(v);
        }
</script>



<!--parte de carregar automaticamente os a tabela com o valor do select-->
<script type="text/javascript">
  $(document).ready(function(e)//ajax do botão calcula
      {//carrega a tabela usando o valor atual do select como a quantidade de registros por página
       //alert("Valor atual do select: "+document.getElementById("quantregistro").value);
        var  valor =document.getElementById("quantregistro").value;
        //$.post('carregar_dados.php', {variable:document.getElementById("quantregistro'").value });
        $.ajax(
            {
              url:"carregar_dados.php",
              type: "POST",
              data: {"quantregistro":valor},//passa o valor do select para usar no metodo POST
              beforeSend: function(){
                $("#divtabela").html('Aguarde...');
              },
              success: function(response){
                $("#divtabela").html(response);
              }
            }
          );

        
      }
    );
</script>
<!--Opção select
  <select id="operacao" name="operacao">
  <option id="1" value="1">Adição</option>
  <option id="2" value="2">Subtração</option>
  <option id="3" value="3">Divisão</option>
  <option id="4" value="4">Multiplicação</option>
</select>
-->