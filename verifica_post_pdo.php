<?php
	ini_set('default_charset','UTF-8');
	class Verifica_POST
	{
		public function Valida($objetoPost)
		{
			$tamanho = sizeof($objetoPost);
			if($objetoPost["operando1"] == null)
			{
				echo 'Digite o 1º operando!';			
			}
			else if($objetoPost["operando2"] == null)
			{
				echo 'Digite o 2º operando!';				
			}
			else if ($tamanho < 3) {
				echo 'Escolha uma operação!';
			}
			else
			{
				return true;
			}
		}		
	}
?>