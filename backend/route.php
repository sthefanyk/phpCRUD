<?php
	function rotas($url) {

		$dados = explode("/", $url);

		// CADASTRAR
		if(strcmp($dados[0], "cadastrar") == 0) {
			if (create($_POST)) {
				header('Location: read.php');
			}
		}
		// ALTERAR
		else if(strcmp($dados[0], "alterar") == 0) {
			if (update($_POST)) {
				header('Location: read.php');
			}
		}
		// REMOVER
		else if(strcmp($dados[0], "remover") == 0){
			if (remove($_REQUEST["cpf"])) {
				header('Location: read.php');
			}
		}
	}
?>