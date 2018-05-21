<?php
	// Adriano Ferreira, 19/05/2018
	// -------------------------------
	// Teste fácilconsulta
	// Classe model da Familia

	class Family extends Database {
		private $id;
		private $name;
		private $members;
		private $db;		

		public function __construct() { // Chama o construtor do pai(Database)
			parent::__construct();
		}

			// Funções getters e setters
					
		public function setName($name) {
			$this->name = $name;
		} 

		public function getname() {
			return $this->name;
		} 

		public function setMembers($members) {
			$this->members = $members;
		} 

		public function getmembers() {
			return $this->members;
		}

		public function setId($id) {
			$this->id = $id;
		} 

		public function getId() {
			return $this->id;
		}

			// Funções do Crud

		public function insert() {
			if( !is_int($this->members) )
				die("family->member não está setado com valor inteiro");

			if(empty($this->name))
				die("family->name não esta definido");
			try {
				$sql = "INSERT INTO familia(nome, quantidade_membros) VALUES (:name, :members)";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":name", $this->name);
				$stmt->bindParam(":members", $this->members);
				$stmt->execute();
				return $stmt->rowCount();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		public function update() {
			if( !is_int($this->members) )
				die("family->member não está setado com valor inteiro");

			if(empty($this->name))
				die("family->name não esta definido");
	
			if( !is_int($this->id) )
				die("family->id não está setado com valor inteiro");

			try {
				$sql = 
				"UPDATE familia SET nome=:name, quantidade_membros=:members WHERE id = :id"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->bindParam(":name", $this->name);
				$stmt->bindParam("members", $this->members);
				$stmt->execute();
				return $stmt->rowCount();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}


		public function delete() {
			if( !is_int($this->id) )
					die("family->id não está setado com valor inteiro");

			try {
				$sql = "DELETE FROM familia WHERE id = :id"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				return $stmt->rowCount();

			} catch (PDOException $e) {
				die($e->getMessage());
			}

		}
		
		public function listAll() {
			try {
				$sql = "SELECT * FROM familia"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute();
				return $stmt->fetchAll();
			} catch (PDOException $e) {
				die($e->getMessage());
			}

		}

		public function loadById() {
			try {
				$sql = "SELECT nome FROM familia where id = :id"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				$result = $stmt->fetch();
				$this->name = $result['nome'];
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}
