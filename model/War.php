<?php
	// Adriano Ferreira, 19/05/2018
	// -------------------------------
	// Teste fácilconsulta
	// Classe model da guerra

	class War extends Database {
		private $id;
		private $challenger;
		private $challenged;
		private $start;
		private $end;
		private $win;		

		public function __construct() { // Chama o construtor do pai(Database)
			parent::__construct();
		}

			// Funções getters e setters

		public function setChallenger($challenger) {
			$this->challenger = $challenger;
		} 

		public function getChallenger() {
			return $challenger->id;
		}

		public function setChallenged($challenged) {
			$this->challenged = $challenged;
		} 

		public function getChallenged() {
			return $this->challenged;
		}

		public function setWin($win) {
			$this->win = $win;
		} 

		public function getWin() {
			return $this->win;
		}

					
		public function setStart($start) {
			$this->start = $start;
		} 

		public function getStart() {
			return $this->start;
		} 

		public function setEnd($end) {
			$this->end = $end;
		} 

		public function getEnd() {
			return $this->end;
		}

		public function setId($id) {
			$this->id = $id;
		} 

		public function getId() {
			return $this->id;
		}

			// Funções do Crud

		public function insert() {
			try {
				$sql = 
				"INSERT INTO guerra(id_familia_desafiadora,
				id_familia_desafiada, data_inicio, data_fim, id_familia_vencedora) 
				VALUES (:chaR, :chaD, :start, :end, :win)";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":chaR", $this->challenger);
				$stmt->bindParam(":chaD", $this->challenged);
				$stmt->bindParam(":start", $this->start);
				$stmt->bindParam(":end", $this->end);
				$stmt->bindParam(":win", $this->win);
				$stmt->execute();
				return $stmt->rowCount();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		public function update() {
			try {
				$sql = 
				"UPDATE guerra SET id_familia_desafiadora = chaR, id_familia_desafiada
				= :chaD, data_inicio = :start, data_fim = :end, id_familia_vencedora = :win where id=:id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->bindParam(":chaR", $this->challenger);
				$stmt->bindParam(":chaD", $this->challenged);
				$stmt->bindParam(":start", $this->start);
				$stmt->bindParam(":end", $this->end);
				$stmt->bindParam(":win", $this->win);
				$stmt->execute();
				return $stmt->rowCount();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}


		public function delete() {
			try {
				$sql = "DELETE FROM guerra WHERE id = :id"; 
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
				$sql = "SELECT * FROM guerra"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				return $stmt->fetchAll();
			} catch (PDOException $e) {
				die($e->getMessage());
			}

		}

		public function filter() {
			try {
				$sql = "SELECT * FROM guerra WHERE (data_inicio BETWEEN (:start) AND (:end)) AND ( data_fim BETWEEN (:start) AND (:end))"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":start", $this->start);
				$stmt->bindParam(":end", $this->end);
				$stmt->execute();
				return $stmt->fetchAll();
			} catch (PDOException $e) {
				die($e->getMessage());
			}

		}



		public function countWars() {
			$count = 0;
			try {
				$sql = "SELECT count(id_familia_desafiadora) as guerras FROM guerra WHERE id_familia_desafiadora = :id group by id_familia_desafiadora"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$count += $result['guerras'];

				$sql = "SELECT count(id_familia_desafiada) as guerras FROM guerra WHERE id_familia_desafiada = :id group by id_familia_desafiada"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$count += $result['guerras'];

				return $count;

			} catch (PDOException $e) {
				die($e->getMessage());
			}

	}

		public function countWin() {
			$count = 0;
			try {
				$sql = "SELECT count(id_familia_vencedora) as ganho FROM guerra WHERE id_familia_vencedora = :id group by id_familia_vencedora"; 
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(":id", $this->id);
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$count += $result['ganho'];

				return $count;

			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}
