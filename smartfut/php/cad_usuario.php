<?php
	include "./conexao_bd.php";
	
	if ($_POST["MODO"] == 'INSERT_INICIAL') {
		$strSQL = "SELECT ID_USUARIO FROM usuario WHERE LOGIN = '" . $_POST['LOGIN'] . "'";
		
		if ($resultado_qry = $conexao->query($strSQL)) {
		
			if (mysqli_num_rows($resultado_qry) == 0) {
				$strSQL = "SELECT ID_PERFIL FROM perfil WHERE TIPO_PERFIL = 0"; /*Tipo 0 = usuario, Tipo 1 = administrador*/
				
				if ($resultado_qry = $conexao->query($strSQL)) {
					if (mysqli_num_rows($resultado_qry) > 0) {
						$linha = $resultado_qry->fetch_assoc();
						$id_perfil = $linha["ID_PERFIL"];

						$strSQL = 
							"INSERT INTO usuario " .
							" (NOME, LOGIN, PASSWORD,ID_PERFIL)" .
							" VALUES (" .
							"'" . $_POST["NOME"] . "'" . ',' .
							"'" . $_POST["LOGIN"] . "'" . ',' .
							"'" . $_POST["PASSWORD"] . "'" . ',' .
							$id_perfil . ')';
						
						if ($conexao->query($strSQL) === TRUE) {
							$id_usuario_inserido = mysqli_insert_id($conexao);
							
							$email = $_POST["EMAIL"];
							$strSQL = 
								"INSERT INTO endereco (ID_USUARIO) VALUES ($id_usuario_inserido);" .
								"INSERT INTO contato (ID_USUARIO,EMAIL) VALUES ($id_usuario_inserido,'$email');";
							
							if ($conexao->multi_query($strSQL) === TRUE) {
								echo 'Login ' . $_POST['LOGIN'] . ' cadastrado com sucesso!';
							} else {
								echo "Erro: " . $strSQL . "<br>" . $conexao->error;
							}
						} else {
							echo "Erro: " . $strSQL . "<br>" . $conexao->error;
						}
					}
					else {
						echo "Perfil de usuário não foi cadastrado. Contate o administrador do sistema.";
					}
				} 
				else {
					echo "Erro: " . $strSQL . "<br>" . $conexao->error;
				}
			}
			else {
				echo 'Este login já existe.';
			}
		}
		else {
			echo 'Erro no comando de requisição.';
		}
	}

	if ($_POST["MODO"] == 'UPDATE_USUARIO') {
		$update_senha = '';
		if (isset($_POST["PASSWORD"]))
			if (trim($_POST["PASSWORD"]) != '')
				$update_senha = ", PASSWORD = " . "'" . $_POST["PASSWORD"] . "'";
		
		$strSQL = 
			"UPDATE usuario SET " . 
			" NOME = " . "'" . $_POST["NOME"] . "'" .
			$update_senha .
			" WHERE ID_USUARIO = " . $_POST["ID_USUARIO"] . ';';
		
		$strSQL = $strSQL .
			" UPDATE endereco SET " .
			" ENDERECO = " . "'" . $_POST["ENDERECO"] . "'" . "," .
			" BAIRRO = " . "'" . $_POST["BAIRRO"] . "'" . "," .
			" NUMERO = " . $_POST["NUMERO"] . "," .
			" ID_CIDADE = " . $_POST["ID_CIDADE"] .
			" WHERE ID_USUARIO = " . $_POST["ID_USUARIO"] . ';';
			
			
		$strSQL = $strSQL .
			" UPDATE contato SET " .
			" EMAIL = " . "'" . $_POST["EMAIL"] . "'" . "," .
			" TELEFONE1 = " . "'" . $_POST["TELEFONE1"] . "'" . "," .
			" TELEFONE2 = " . "'" . $_POST["TELEFONE2"] . "'" . "," .
			" CELULAR1 = " . "'" . $_POST["CELULAR1"] . "'" . "," .
			" CELULAR2 = " . "'" . $_POST["CELULAR2"] . "'" . "," .
			" LINK_SITE = " . "'" . $_POST["LINK_SITE"] . "'" . "," .
			" LINK_FACEBOOK = " . "'" . $_POST["LINK_FACEBOOK"] . "'" .
			" WHERE ID_USUARIO = " . $_POST["ID_USUARIO"] . ';';
		
		if ($conexao->multi_query($strSQL) === TRUE) {
			if (trim($update_senha) == '')
				echo "Dados alterados com sucesso.";
			else
				echo "Dados e senha alterados com sucesso.";
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'ATUALIZAR_USUARIO') {
		$strSQL = 
			"SELECT A.NOME, A.LOGIN, " .
			" B.ENDERECO, B.BAIRRO, B.NUMERO, " .
			" B.ID_CIDADE, C.CIDADE, C.ESTADO, " .
			" D.EMAIL, D.TELEFONE1, D.TELEFONE2, D.CELULAR1, D.CELULAR2, D.LINK_SITE, D.LINK_FACEBOOK " .
			" FROM usuario A " .
			" LEFT JOIN endereco B ON B.ID_USUARIO = A.ID_USUARIO " .
			" LEFT JOIN cidade C ON B.ID_CIDADE = C.ID_CIDADE " .
			" LEFT JOIN contato D ON D.ID_USUARIO = A.ID_USUARIO " .
			" WHERE A.ID_USUARIO = " . $_POST["ID_USUARIO"];
				
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$tab_usuario_json = '{"TABELA_USUARIO":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$tab_usuario_json = $tab_usuario_json . '{';
					$tab_usuario_json = $tab_usuario_json . 
										'"NOME":' 			. '"' . $linha[0] . '"' . ',' .
										'"LOGIN":' 			. '"' . $linha[1] . '"' . ',' .
										'"ENDERECO":' 		. '"' . $linha[2] . '"' . ',' .
										'"BAIRRO":' 		. '"' . $linha[3] . '"' . ',' .
										'"NUMERO":' 		. '"' . $linha[4] . '"' . ',' .
										'"ID_CIDADE":' 		. '"' . $linha[5] . '"' . ',' .
										'"CIDADE":' 		. '"' . $linha[6] . '"' . ',' .
										'"ESTADO":' 		. '"' . $linha[7] . '"' . ',' .
										'"EMAIL":' 			. '"' . $linha[8] . '"' . ',' .
										'"TELEFONE1":' 		. '"' . $linha[9] . '"' . ',' .
										'"TELEFONE2":' 		. '"' . $linha[10] . '"' . ',' .
										'"CELULAR1":' 		. '"' . $linha[11] . '"' . ',' .
										'"CELULAR2":' 		. '"' . $linha[12] . '"' . ',' .
										'"LINK_SITE":' 		. '"' . $linha[13] . '"' . ',' .
										'"LINK_FACEBOOK":' 	. '"' . $linha[14] . '"';
					
					$tab_usuario_json = $tab_usuario_json . '}, ';
				}
				$tab_usuario_json = substr($tab_usuario_json, 0, strlen($tab_usuario_json) - 2);
				$tab_usuario_json = $tab_usuario_json . ']}';
				
				echo $tab_usuario_json;
			}
			else {
				echo '';
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	$conexao->close();
?>