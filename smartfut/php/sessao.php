<?php
	session_start();

	if (!(	
			isset($_SESSION["ID_USUARIO"])			&&
			isset($_SESSION["NOME"])				&&
			isset($_SESSION["LOGIN"])				&&
			isset($_SESSION["ID_PERFIL"])			&&
			isset($_SESSION["DESCRICAO_PERFIL"])	&&
			isset($_SESSION["TIPO_PERFIL"])
		)) 
	{
		header('Location:index.php');	
	}
?>

