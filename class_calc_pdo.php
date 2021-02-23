<?php
ini_set('display_errors', 1);
//ini_set('default_charset','UTF-8');
class CalculadoraAjax
{
	private $Valor1;
	private $Valor2;
	private $operacao;
	public function __construct($operando1, $operando2, $operacao)
	{
		$this->Valor1 = $operando1;
		$this->Valor2 = $operando2;
		$this->operacao = $operacao;
	}
	public function Executa()
	{
		if($this->operacao == "+")//não está igualando as strings
		{
			$result = $this->Valor1+$this->Valor2;
			return $result;
			
	 	}
	 	elseif ($this->operacao == "-") 
	 	{
	 		$result=$this->Valor1-$this->Valor2;
	 		return $result;
	 		
	 	}
	 	elseif ($this->operacao == "/") 
	 	{
	 		$result=$this->Valor1/$this->Valor2;
	 		return $result;
	 		
	 	}
		elseif ($this->operacao == "*") 
		{
			$result=$this->Valor1*$this->Valor2;
	 		return $result;
	 		
 		}
	}
	
}
?>