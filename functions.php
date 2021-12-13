<?php
	class FUNCOES{
		public function retirar_acentos($str){
			$str = utf8_decode($str);
			$GLOBALS['normalizeChars'] = array(
				'�'=>'S', '�'=>'s', '�'=>'Dj','�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', 
				'�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I', 
				'�'=>'I', '�'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U', 
				'�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', 
				'�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i', 
				'�'=>'i', '�'=>'o', '�'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u', 
				'�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', '�'=>'f'
			);
			$str     =     str_replace('&', '-and-', $str);
			$str     =     trim(preg_replace('/[^\w\d_ -]/si', '', $str));//remove all illegal chars
			$str     =     str_replace(' ', '-', $str);
			$str     =     str_replace('--', '-', $str);
			return strtr($str, $GLOBALS['normalizeChars']);
		}
		
		public function validaCPF($cpf){	// Verifiva se o n�mero digitado cont�m todos os digitos
			$cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
		
			// Verifica se nenhuma das sequ�ncias abaixo foi digitada, caso seja, retorna falso
			if(strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' 
			   || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' 
			   || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999'){
			   return false;
			}else{   // Calcula os n�meros para verificar se o CPF � verdadeiro
			   for($t = 9; $t < 11; $t++){
				  for($d = 0, $c = 0; $c < $t; $c++){
					 $d += $cpf{$c} * (($t + 1) - $c);
				  }
				  $d = ((10 * $d) % 11) % 10;
				  if($cpf{$c} != $d){
					 return false;
				  }
			   }
			   return true;
			}
		}

		public function validaCNPJ($str){
			if(strlen($str) == 13){
			   $str = "0".$str;
			}elseif(strlen($str) == 12){
			   $str = "00".$str;
			}
			if(!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
			   return false;
			
			array_shift($matches);
			$str = implode('', $matches);
			if(strlen($str) > 14)
			   $str = substr($str, 1);
	
			$sum1 = 0;
			$sum2 = 0;
			$sum3 = 0;
			$calc1 = 5;
			$calc2 = 6;
	
			for($i=0; $i <= 12; $i++){
			   $calc1 = $calc1 < 2 ? 9 : $calc1;
			   $calc2 = $calc2 < 2 ? 9 : $calc2;
		
			   if($i <= 11)
				  $sum1 += $str[$i] * $calc1;
		
			   $sum2 += $str[$i] * $calc2;
			   $sum3 += $str[$i];
			   $calc1--;
			   $calc2--;
			}
	
			$sum1 %= 11;
			$sum2 %= 11;
	
			return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? $str : false;
		}

		public function zeroComplete($str, $qtde){
			$retorno = $str;
			$i = 0;
			for($i=0; $i<($qtde-strlen($str)); $i++){
				$retorno = "0".$retorno;
			}
			return $retorno;
		}


		public function generateSalt($max = 30) {
			$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$i = 0;
			$salt = "";
			do {
				$salt .= $characterList{mt_rand(0,strlen($characterList)-1)};
				$i++;
			} while ($i < $max);
			return $salt;
		}

		public function formatar_data($data, $tipo, $dia = "", $mes = "", $ano = ""){
			if(trim($data) != ""){
				if($tipo == "exibir"){
				   //Se for exibi��o
				   if($data != ""){
					  $dia = substr($data,8,2);
					  $mes = substr($data,5,2);
					  $ano = substr($data,0,4);
				   }
				   $retorno = date("d/m/Y", mktime(0,0,0,$mes,$dia,$ano));
				}else{
				   //Se for Grava��o	
				   if($data != ""){
					  $dia = substr($data,0,2);
					  $mes = substr($data,3,2);
					  $ano = substr($data,6,4);
					  $hora = substr($data,11,2);
					  $min = substr($data,14,2);
					  $seg = substr($data,17,2);						  
				   }
				   $retorno = date("Y-m-d H:i:s", mktime($hora, $min, $seg, $mes, $dia, $ano));
				}
				return $retorno;
			}
		}
		

	} //fim da classe
?>