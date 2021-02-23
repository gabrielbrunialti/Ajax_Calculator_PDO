<head>

    <script  src="http://code.jquery.com/jquery-1.9.1.min.js" ></script>
    <script type="text/javascript">
        $(document).ready
        (
            function()//torna a tabela clicavel
            {
                $('#tabela1').on('click', 'tr', function() {

                    var val1;
                    var val2;
                    var op;
                    var result;
                    var teste = $(this).index();// pega o indice da linha clicada
                     $('table tr:eq('+(teste+1)+') td:eq(0)').each(function()//pega a linha com indice teste+1(indice 0 é o cabeçalho) e a coluna com idice 1 "valor1"
                        {
                            document.getElementById('idop').value =($(this).text());//insere o valor da cell(tr = teste+1,td=eq(1)) na caixa de texto "testo1"
                        }
                    );
                    $('table tr:eq('+(teste+1)+') td:eq(1)').each(function()//pega a linha com indice teste+1(indice 0 é o cabeçalho) e a coluna com idice 1 "valor1"
                        {
                            document.getElementById('texto1').value =($(this).text());//insere o valor da cell(tr = teste+1,td=eq(1)) na caixa de texto "testo1"
                        }
                    );
                    $('table tr:eq('+(teste+1)+') td:eq(2)').each(function()//pega alinha com indice teste+1(indice 0 é o cabeçalho) e a coluna com idice 2 "valor2"
                        {
                            document.getElementById('texto2').value =($(this).text());//insere o valor da cell na caixa de texto "testo2"
                        }
                    );
                    $('table tr:eq('+(teste+1)+') td:eq(3)').each(function()//pega alinha com indice teste+1(indice 0 é o cabeçalho) e a coluna com idice 2 "valor2"
                        {
                             radiobtn = document.getElementById($(this).text());//pega o botão radio com id = ao od da operação
                             radiobtn.checked = true;//seleciona a opção correspondente ao id da operação
                             op = ($(this).text());//op é igualada 
                        }
                    );
                    if(op == 1)//retorna os valores para serem exibidos na div result
                    {
                        result = Number (document.getElementById('texto1').value) + Number(document.getElementById('texto2').value);
                        $("#result").html("Resultado: "+document.getElementById('texto1').value+" + "+document.getElementById('texto2').value+" = "+result);  
                    }
                    if(op == 2)//retorna os valores para serem exibidos na div result
                    {
                        result = Number (document.getElementById('texto1').value) - Number(document.getElementById('texto2').value);
                        $("#result").html("Resultado: "+document.getElementById('texto1').value+" - "+document.getElementById('texto2').value+" = "+result);  
                    }
                    if(op == 3)//retorna os valores para serem exibidos na div result
                    {
                        result = Number (document.getElementById('texto1').value) / Number(document.getElementById('texto2').value);
                        $("#result").html("Resultado: "+document.getElementById('texto1').value+" / "+document.getElementById('texto2').value+" = "+result);  
                    }
                    if(op == 4)//retorna os valores para serem exibidos na div result
                    {
                        result = Number (document.getElementById('texto1').value) * Number(document.getElementById('texto2').value);
                        $("#result").html("Resultado: "+document.getElementById('texto1').value+" * "+document.getElementById('texto2').value+" = "+result);  
                    }
                }
                );
            }
        );

    </script>
</head>
<body>

    <style type="text/css">/* faz a alternância das cores das linhas, onde é par é de uma cor, onde é impar é de outra*/
           /*Definido cor das linhas pares*/
        .minha_tabela tr:nth-child(even) {background: #FFF}
         
        /*Definindo cor das Linhas impáres*/
        .minha_tabela tr:nth-child(odd) {background: #EEE}

        /*css global tabela*/
        .minha_tabela{width: 95%;border-collapse: collapse;}
        /*coloca bordas na tabela*/
        .minha_tabela th, td {
            border: 1px solid black;
        }


        td{
        cursor:pointer;
        }
 
       /*td:hover{
        background: -moz-linear-gradient(top, #249ee4, #057cc0);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#249ee4), to(#057cc0));
        }
 
        td:active
        {
        background: -moz-linear-gradient(top, #057cc0, #249ee4);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#057cc0), to(#249ee4));
        }
 
        #result{
        font-weight:bold;
        font-size:16pt;*/
        input[type=text], select {
            width: 20%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        input[type = button],[type=submit] {
            width: 30%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type = button],[type = submit] type=submit]:hover {
            background-color: #45a049;
        }
    }
	</style> 
</body>