<?php
	class Mysql{
		######################################################
		### Recebe valores de conexao da pagina config.php ###
		######################################################
		
		private $servidor = servidor; //host – servidor
		private $usuario = usuario; // Usuário do banco de dados
		private $senha = senha; // Senha do banco de dados
		private $banco = banco; // Nome do Banco de dados mysql
		private $con;
		
		public function __construct($sql=NULL, $mostra_query = false){
			$this->con = mysqli_connect($this->servidor, $this->usuario, $this->senha) 
			or die("Falha ao conectar com o banco de dados");
			
			mysqli_select_db($this->con, $this->banco);
			self::execute($sql, $mostra_query);
		}
		
		public function execute($sql, $mostra_query = false){
			if($mostra_query == true){
				$this->result = $sql;
			}else{
				//Inicio da Query\\\\\\\\

				$r = mysqli_query($this->con, "SET CHARACTER SET utf8");
				$r = mysqli_query($this->con, "set lc_time_names = 'pt_BR'");
				$res = mysqli_query($this->con, $sql);
				$this->mysqli_insert_id = mysqli_insert_id($this->con);

				if($res===true){
					return true;
				}

				while($row = mysqli_fetch_object($res)){
					$array[] = $row;
				}
				mysqli_close($this->con);

				if(count($array)>0){
					$this->result = $array;
				}else{
					return false;
				}
			}
		}
	}
?>