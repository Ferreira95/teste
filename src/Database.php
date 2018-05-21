<?php
	// Adriano Ferreira, 19/05/2018
	// -------------------------------
	// Teste fácilconsulta
	// Classe responsável pelo banco de dados
	
	class Database {
		private $HOST = "localhost";
		private $DB = "teste";
		private $USER = "master";
		private $PASS = "senha5";
		private $table;
		
		public $pdo;

			// Funções de conexão

		public function __construct() {
			try {
			    $this->pdo = new PDO
				('mysql:host=' . $this->HOST . ';dbname=' . $this->DB, $this->USER, $this->PASS);
			}
			catch ( PDOException $e ) {
			    die('Erro ao conectar com o MySQL: ' . $e->getMessage());
			}
		}
	}
	
