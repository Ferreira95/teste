<?php
	// Adriano Ferreira, 19/05/2018
	// -------------------------------
	// Teste fácilconsulta
	// Controlador do teste

	require ("model/Database.php");
	require("model/War.php");
	require ("model/Family.php");
			// Controller família
	
	if(isset($_POST['newFamily'])) {
		if( !(isset($_POST['name']) || !isset($_POST['members'])) ) {
			echo "Parameters not set";
			return;
		}

		$family = new Family();
		$family->setName($_POST['name']);
		$family->setMembers(intval($_POST['members']));
		echo json_encode($family->insert());
	}

	else if(isset($_POST['upFamily'])) {
		if( !(isset($_POST['name']) || !isset($_POST['members']))) {
			die("Parameters not set");
		}

		$family = new Family();
		$family->setId(intval($_POST['upFamily']));
		$family->setName($_POST['name']);
		$family->setMembers(intval($_POST['members']));
		echo json_encode($family->update());
	}

	else if(isset($_POST['delFamily'])) {
		$family = new Family();
		$family->setId(intval($_POST['delFamily']));
		echo json_encode($family->delete());
	}

	else if(isset($_POST['listFamily'])){
		$family = new Family();
		$war = new War();
		$data = $family->listAll();
		for($i = 0; $i<count($data); $i++){
			$war->setId($data[$i]['id']);
			$data[$i]["guerras"] =  $war->countWars();
			$data[$i]["venceu"] = $war->countWin();
		}
		echo json_encode($data);
	}

			// Controller guerra
	else if(isset($_POST['listWar'])) {
		$war = new War();
		$family = new Family();
		$data = $war->listAll();
		for($i=0; $i<count($data); $i++) {
			$family->setId(intval($data[$i]['id_familia_desafiadora']));
			$family->loadById();
			$data[$i]['nomeDr'] = $family->getName();
			$family->setId(intval($data[$i]['id_familia_desafiada']));
			$family->loadById();
			$data[$i]['nomeDd'] = $family->getName();
			$family->setId(intval($data[$i]['id_familia_vencedora']));
			$family->loadById();
			$data[$i]['nomeV'] = $family->getName();
		}
		echo json_encode($data);
	}

	else if(isset($_POST['filter'])) {
		$war = new War();
		$war->setStart($_POST['start']);
		$war->setEnd($_POST['finish']);
		$family = new Family();
		$data = $war->filter();
		for($i=0; $i<count($data); $i++) {
			$family->setId(intval($data[$i]['id_familia_desafiadora']));
			$family->loadById();
			$data[$i]['nomeDr'] = $family->getName();
			$family->setId(intval($data[$i]['id_familia_desafiada']));
			$family->loadById();
			$data[$i]['nomeDd'] = $family->getName();
			$family->setId(intval($data[$i]['id_familia_vencedora']));
			$family->loadById();
			$data[$i]['nomeV'] = $family->getName();
		}
		echo json_encode($data);
	}


	else if(isset($_POST['newWar'])) {
		$camp = array("start", "finish", "challenger", "challenged", "winner");
		for($i=0; $i<count($camp); $i++) {
			if(!isset($_POST[$camp[$i]])) {
				echo "bad parameter";
				return;
			}
		}

		$war = new war();
		$war->setChallenged(intval($_POST['challenged']));
		$war->setChallenger(intval($_POST['challenger']));
		$war->setWin(intval($_POST['winner']));
		$war->setStart($_POST['start']);
		$war->setEnd($_POST['finish']);
		echo json_encode($war->insert());
	}

	else if(isset($_POST['upWar'])) {
		$camp = array("start", "finish", "challenger", "challenged", "winner");
		for($i=0; $i<count($camp); $i++) {
			if(!isset($_POST[$camp[$i]])) {
				echo "bad parameter";
				return;
			}
		}

		$war = new war();
		$war->setId(intval($_POST['upWar']));
		$war->setChallenged(intval($_POST['challenged']));
		$war->setChallenger(intval($_POST['challenger']));
		$war->setWin(intval($_POST['winner']));
		$war->setStart($_POST['start']);
		$war->setEnd($_POST['finish']);
		echo json_encode($war->insert());
	}

	else if(isset($_POST['delWar'])) {
		$war = new War();
		$war->setId(intval($_POST['delWar']));
		print_r($_POST);
		echo json_encode($family->delete());
	}


