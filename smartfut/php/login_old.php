<?php
	include "conexao_bd.php";
	
	$strSQL = 
		"SELECT A.ID_USUARIO, A.NOME, A.LOGIN, A.PASSWORD, A.ID_PERFIL, B.DESCRICAO_PERFIL, B.TIPO_PERFIL " .
		" FROM usuario A " .
		" LEFT JOIN perfil B ON A.ID_PERFIL = B.ID_PERFIL " .
		" WHERE A.LOGIN = " . "'" . $_POST["LOGIN"] . "'";
		
	if ($resultado_qry = $conexao->query($strSQL)) {
	
		if (mysqli_num_rows($resultado_qry) != 0) {
			$linha = $resultado_qry->fetch_assoc();
			if ($_POST["PASSWORD"] == $linha["PASSWORD"]) {
				if ($_POST["LEMBRAR"])
					setcookie("login", $linha["LOGIN"], time() + (86400 * 30), "/");
				
				session_start();
				$_SESSION["ID_USUARIO"] 		= $linha["ID_USUARIO"];
				$_SESSION["NOME"]   			= $linha["NOME"];
				$_SESSION["LOGIN"]  			= $linha["LOGIN"];
				$_SESSION["ID_PERFIL"] 			= $linha["ID_PERFIL"];
				$_SESSION["DESCRICAO_PERFIL"] 	= $linha["DESCRICAO_PERFIL"];
				$_SESSION["TIPO_PERFIL"] 		= $linha["TIPO_PERFIL"];
			}
			else {
				echo "Erro: Senha incorreta ou em branco!";
				//echo "<script>model.js</script>";
			}
		}
		else {
			echo "Erro: Usuário e senha incorreta!";
		}
		
		$resultado_qry->close();
	}
	
	$conexao->close();	
?>