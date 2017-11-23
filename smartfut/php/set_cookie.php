<?php
	setcookie("id_quadra", $_POST["ID_QUADRA"], time() + (86400 * 30), "/");
	setcookie("nome_quadra", $_POST["NOME_QUADRA"], time() + (86400 * 30), "/");
?>
