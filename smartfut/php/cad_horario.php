<?php
	include "conexao_bd.php";
	
	if ($_POST["MODO"] == 'INSERT_HORARIO_INICIAL') {
		$strSQL = 'INSERT INTO horario (ID_QUADRA,DIA_SEMANA,HORA) VALUES ';
		
		for ($dia_semana = 0; $dia_semana < 7; $dia_semana++) {
			for ($hora = $_POST["HORA_INI"]; $hora < $_POST["HORA_FIM"]; $hora++) {
				$zero_esquerda = '';
				if ($hora < 10) {
					$zero_esquerda = '0';
				}
				
				$strSQL = $strSQL . '(' .					
					$_POST["ID_QUADRA"] . ',' .
					$dia_semana . ',' .
					"'" . $zero_esquerda . $hora . ":00" . "'" . '),';
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		
		
		if ($conexao->query($strSQL) === TRUE) {
		
			$conexao->close();			
			include "conexao_bd.php";
			
			$strSQL =
				'SELECT DIA_SEMANA, HORA FROM horario WHERE ID_QUADRA = ' . $_POST["ID_QUADRA"] . 
				" ORDER BY DIA_SEMANA, CAST(REPLACE(HORA,':','') AS INTEGER);";

			/*replicado de ATUALIZAR*/
			if ($resultado_qry = $conexao->query($strSQL)) {
				if (mysqli_num_rows($resultado_qry) > 0) {
					$tab_horario_json = '{"TABELA_HORARIO":[';
					while ($linha = $resultado_qry->fetch_row()) {
					
						$tab_horario_json = $tab_horario_json . '{';
						$tab_horario_json = $tab_horario_json . 
											'"DIA_SEMANA":' . '"' . $linha[0] . '"' . ',' .
											'"HORA":' . '"' . $linha[1] . '"';
						
						$tab_horario_json = $tab_horario_json . '}, ';
					}
					$tab_horario_json = substr($tab_horario_json, 0, strlen($tab_horario_json) - 2);
					$tab_horario_json = $tab_horario_json . ']}';
					
					echo $tab_horario_json;
				}
				else {
					echo '';
				}
			}
			else {
				echo "Erro: " . $strSQL . "<br>" . $conexao->error;
			}
			/*-------------*/
		} 
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'INSERT') {
		$strSQL = 
				'SELECT ID_HORARIO FROM horario' . 
				' WHERE ID_QUADRA = ' . $_POST["ID_QUADRA"] . ' AND ' .
				' DIA_SEMANA = ' . $_POST["DIA_SEMANA"] . ' AND ' .
				' HORA = ' . "'" . $_POST["HORA"] . "'";
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) == 0) {
				$strSQL = 
					'INSERT INTO horario (ID_QUADRA,DIA_SEMANA,HORA) VALUES (' .
					$_POST["ID_QUADRA"] . ',' .
					$_POST["DIA_SEMANA"] . ',' .
					"'" . $_POST["HORA"] . "'" . ')';
				
				if ($conexao->query($strSQL) === FALSE) {
					echo "Erro: " . $strSQL . "<br>" . $conexao->error;
				}
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'INSERT_EVENTO') {
		$strSQL = 
			'SELECT ID_AGENDA FROM agenda ' .
			' WHERE SITUACAO = 3 AND ID_QUADRA = ' . $_POST["ID_QUADRA"] . ' AND (' .
			"(CONVERT(CONCAT("  . "'" . $_POST["DATA"] . " '" . ",'" . $_POST["HORA"] . "', ':00'),DATETIME) BETWEEN " .
					"CONVERT(CONCAT(DATA, ' ', HORA, ':00'),DATETIME) AND " .
					"CONVERT(CONCAT(DATA_FIM, ' ', HORA_FIM, ':00'),DATETIME))" .
			" OR " .			
			"(CONVERT(CONCAT("  . "'" . $_POST["DATA_FIM"] . " '" . ",'" . $_POST["HORA_FIM"] . "', ':00'),DATETIME) BETWEEN " .
					"CONVERT(CONCAT(DATA, ' ', HORA, ':00'),DATETIME) AND " .
					"CONVERT(CONCAT(DATA_FIM, ' ', HORA_FIM, ':00'),DATETIME))" . 
			")";
			
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) == 0) {
				$dia_semana = date("w", strtotime($_POST["DATA"]));
				$dia_semana = $dia_semana - 1;
				if ($dia_semana < 0)
					$dia_semana = 6;
			
				$strSQL = 
					'INSERT INTO agenda (ID_QUADRA,ID_USUARIO,TITULO,DIA_SEMANA,HORA,DATA,HORA_FIM,DATA_FIM,SITUACAO) VALUES (' .
					$_POST["ID_QUADRA"] . ',' .
					$_POST["ID_USUARIO"] . ',' .
					"'" . $_POST["TITULO"] . "'" . ',' .
					$dia_semana . ',' .
					"'" . $_POST["HORA"] . "'" . ',' .
					"'" . $_POST["DATA"] . "'" . ',' .
					"'" . $_POST["HORA_FIM"] . "'" . ',' .
					"'" . $_POST["DATA_FIM"] . "'" . ',' .
					"3" . ')';
					
				if ($conexao->query($strSQL) === TRUE) {
					if ($_POST["CANCELAR"]) {
						$strSQL = 
							"DELETE FROM agenda " .
							'WHERE SITUACAO <> 3 AND ID_QUADRA = ' . $_POST["ID_QUADRA"] . ' AND ' .
							"(CONVERT(CONCAT(DATA, ' ', HORA, ':00'),DATETIME) BETWEEN " .
							"CONVERT(CONCAT("  . "'" . $_POST["DATA"] . " '" . ",'" . $_POST["HORA"] . "', ':00'),DATETIME) AND " .
							"CONVERT(CONCAT("  . "'" . $_POST["DATA_FIM"] . " '" . ",'" . $_POST["HORA_FIM"] . "', ':00'),DATETIME))";
						if ($conexao->query($strSQL) === FALSE) {
							echo "Erro: " . $strSQL . "<br>" . $conexao->error;
						}
					}
				}
				else {
					echo "Erro: " . $strSQL . "<br>" . $conexao->error;
				}
			}
			else {
				echo "Evento não cadastrado, existe concorrência com datas de outros eventos.";
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'DELETE_EVENTO') {
		$strSQL = "DELETE FROM agenda WHERE ID_AGENDA = " . $_POST["ID_AGENDA"];
		
		if ($conexao->query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'DELETE') {
		
		$strSQL = 
				'DELETE FROM horario' . 
				' WHERE ID_QUADRA = ' . $_POST["ID_QUADRA"] . ' AND ' .
				' DIA_SEMANA = ' . $_POST["DIA_SEMANA"] . ' AND ' .
				' HORA = ' . "'" . $_POST["HORA"] . "'";
		if ($conexao->query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'ATUALIZAR') {
		$strSQL = 
			'SELECT DIA_SEMANA, HORA FROM horario WHERE ID_QUADRA = ' . $_POST["ID_QUADRA"] . 
			" ORDER BY DIA_SEMANA, CAST(REPLACE(HORA,':','') AS INTEGER)";
				
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$tab_horario_json = '{"TABELA_HORARIO":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$tab_horario_json = $tab_horario_json . '{';
					$tab_horario_json = $tab_horario_json . 
										'"DIA_SEMANA":' . '"' . $linha[0] . '"' . ',' .
										'"HORA":' . '"' . $linha[1] . '"';
					
					$tab_horario_json = $tab_horario_json . '}, ';
				}
				$tab_horario_json = substr($tab_horario_json, 0, strlen($tab_horario_json) - 2);
				$tab_horario_json = $tab_horario_json . ']}';
				
				echo $tab_horario_json;
			}
			else {
				echo '';
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'ATUALIZAR_REQUISICAO') {
		$strSQL = 
			"SELECT A.ID_AGENDA, A.ID_USUARIO, A.DATA, A.HORA, A.SITUACAO, B.NOME " .			
			" FROM agenda A " . 
			" LEFT JOIN usuario B ON A.ID_USUARIO = B.ID_USUARIO " .
			" WHERE (A.SITUACAO = 1 OR A.SITUACAO = 2)" .
			" AND A.DATA BETWEEN " . "'" . $_POST["DATA_INI"] . "'" . " AND " . "'" . $_POST["DATA_FIM"] . "'" .
			" AND A.ID_QUADRA = " . $_POST["ID_QUADRA"] . 
			" ORDER BY A.DATA, CAST(REPLACE(A.HORA,':','') AS INTEGER), A.ID_AGENDA";
				
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$tab_requisicao_json = '{"TABELA_REQUISICAO":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$tab_requisicao_json = $tab_requisicao_json . '{';
					$tab_requisicao_json = $tab_requisicao_json . 
										'"ID_AGENDA":' . '"' . $linha[0] . '"' . ',' .
										'"ID_USUARIO":' . '"' . $linha[1] . '"' . ',' .
										'"DATA":' . '"' . $linha[2] . '"' . ',' .
										'"HORA":' . '"' . $linha[3] . '"' . ',' .
										'"SITUACAO":' . '"' . $linha[4] . '"' . ',' .
										'"NOME":' . '"' . $linha[5] . '"';
					
					$tab_requisicao_json = $tab_requisicao_json . '}, ';
				}
				$tab_requisicao_json = substr($tab_requisicao_json, 0, strlen($tab_requisicao_json) - 2);
				$tab_requisicao_json = $tab_requisicao_json . ']}';
				
				echo $tab_requisicao_json;
			}
			else {
				echo '';
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'UPDATE_REQUISICAO') {
		$strSQL = 
			"UPDATE agenda SET SITUACAO = 1 " .
			" WHERE DATA = " . "'" . $_POST["DATA"] . "'" .
			" AND HORA = " . "'" . $_POST["HORA"] . "'" .
			" AND ID_QUADRA = " . $_POST["ID_QUADRA"];
		
		if ($conexao->query($strSQL) === TRUE) {
			if ($_POST["CANCELAR"] == 0) {
				$strSQL = 
					"UPDATE agenda SET SITUACAO = 2 " .
					" WHERE ID_AGENDA = " . $_POST["ID_AGENDA"];
					
				if ($conexao->query($strSQL) === FALSE) {
					echo "Erro: " . $strSQL . "<br>" . $conexao->error;
				}
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'DELETE_REQUISICAO') {
		$strSQL = "DELETE FROM agenda WHERE ID_AGENDA = " . $_POST["ID_AGENDA"];
	
		if ($conexao->query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == "ATUALIZAR_EVENTO") {
		$strSQL = 
			"SELECT A.ID_AGENDA, A.TITULO, A.DATA, A.HORA, A.DATA_FIM, A.HORA_FIM FROM agenda A " .
			" LEFT JOIN usuario B ON A.ID_USUARIO = B.ID_USUARIO" .
			" WHERE A.ID_QUADRA = " . $_POST["ID_QUADRA"] .
			" AND B.ID_PERFIL = " . $_POST["ID_PERFIL"] .
			" AND A.SITUACAO = 3 " .
			" ORDER BY A.ID_AGENDA DESC";
			
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$tab_evento_json = '{"TABELA_EVENTO":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$tab_evento_json = $tab_evento_json . '{';
					$tab_evento_json = $tab_evento_json . 
										'"ID_AGENDA":' . '"' . $linha[0] . '"' . ',' .
										'"TITULO":' . '"' . $linha[1] . '"' . ',' .
										'"DATA":' . '"' . $linha[2] . '"' . ',' .
										'"HORA":' . '"' . $linha[3] . '"' . ',' .
										'"DATA_FIM":' . '"' . $linha[4] . '"' . ',' .
										'"HORA_FIM":' . '"' . $linha[5] . '"';
					
					$tab_evento_json = $tab_evento_json . '}, ';
				}
				$tab_evento_json = substr($tab_evento_json, 0, strlen($tab_evento_json) - 2);
				$tab_evento_json = $tab_evento_json . ']}';
				
				echo $tab_evento_json;
			}
			else {
				echo '';
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
		
	if ($_POST["MODO"] == 'ATUALIZAR_QUADRA') {
		$strSQL = 
			'SELECT A.ID_QUADRA, A.DESCRICAO, A.TAMANHO, A.PRECO_HORA, ' .
			' A.ID_TIPO_QUADRA, B.TIPO_QUADRA, ' .
			' C.ENDERECO, C.BAIRRO, C.NUMERO, ' . 
			' C.ID_CIDADE, D.CIDADE, D.ESTADO, ' . 
			' E.EMAIL, E.TELEFONE1, E.TELEFONE2, E.CELULAR1, E.CELULAR2, E.LINK_SITE, E.LINK_FACEBOOK ' .
			' FROM quadra A ' .
			' LEFT JOIN tipo_quadra B ON A.ID_TIPO_QUADRA = B.ID_TIPO_QUADRA ' .
			' LEFT JOIN endereco C ON A.ID_QUADRA = C.ID_QUADRA ' .
			' LEFT JOIN cidade D ON C.ID_CIDADE = D.ID_CIDADE ' .
			' LEFT JOIN contato E ON A.ID_QUADRA = E.ID_QUADRA ' .
			' WHERE A.ID_PERFIL = ' . $_POST["ID_PERFIL"] . 
			" ORDER BY A.DESCRICAO";
				
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$tab_quadra_json = '{"TABELA_QUADRA":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$tab_quadra_json = $tab_quadra_json . '{';
					$tab_quadra_json = $tab_quadra_json . 
										'"ID_QUADRA":' 		. '"' . $linha[0] . '"' . ',' .
										'"DESCRICAO":' 		. '"' . $linha[1] . '"' . ',' .
										'"TAMANHO":' 		. '"' . $linha[2] . '"' . ',' .
										'"PRECO_HORA":' 	. '"' . $linha[3] . '"' . ',' .
										'"ID_TIPO_QUADRA":'	. '"' . $linha[4] . '"' . ',' .
										'"TIPO_QUADRA":' 	. '"' . $linha[5] . '"' . ',' .
										'"ENDERECO":' 		. '"' . $linha[6] . '"' . ',' .
										'"BAIRRO":' 		. '"' . $linha[7] . '"' . ',' .
										'"NUMERO":' 		. '"' . $linha[8] . '"' . ',' .
										'"ID_CIDADE":' 		. '"' . $linha[9] . '"' . ',' .
										'"CIDADE":' 		. '"' . $linha[10] . '"' . ',' .
										'"ESTADO":' 		. '"' . $linha[11] . '"' . ',' .
										'"EMAIL":' 			. '"' . $linha[12] . '"' . ',' .
										'"TELEFONE1":' 		. '"' . $linha[13] . '"' . ',' .
										'"TELEFONE2":' 		. '"' . $linha[14] . '"' . ',' .
										'"CELULAR1":' 		. '"' . $linha[15] . '"' . ',' .
										'"CELULAR2":' 		. '"' . $linha[16] . '"' . ',' .
										'"LINK_SITE":' 		. '"' . $linha[17] . '"' . ',' .
										'"LINK_FACEBOOK":' 	. '"' . $linha[18] . '"';
					
					$tab_quadra_json = $tab_quadra_json . '}, ';
				}
				$tab_quadra_json = substr($tab_quadra_json, 0, strlen($tab_quadra_json) - 2);
				$tab_quadra_json = $tab_quadra_json . ']}';
				
				echo $tab_quadra_json;
			}
			else {
				echo '';
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'INSERT_QUADRA') {
		$strSQL = "SELECT ID_QUADRA FROM quadra WHERE DESCRICAO = " . "'" . $_POST["DESCRICAO"]. "'";
		
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) == 0) {
				$strSQL =
					"INSERT INTO quadra (DESCRICAO, ID_PERFIL) VALUES (" .
					"'" . $_POST["DESCRICAO"] . "'" . "," .
					$_POST["ID_PERFIL"] . ")";
				
				if ($conexao->query($strSQL) === TRUE) {
					$id_quadra_inserida = mysqli_insert_id($conexao);
					
					$strSQL = 
						"INSERT INTO contato (ID_QUADRA) VALUES ($id_quadra_inserida);" .
						"INSERT INTO endereco (ID_QUADRA) VALUES ($id_quadra_inserida);";
						
					if ($conexao->multi_query($strSQL) === TRUE) {
						echo $id_quadra_inserida;
					}
					else {
						echo "Erro: " . $strSQL . "<br>" . $conexao->error;
					}
				}
				else {
					echo "Erro: " . $strSQL . "<br>" . $conexao->error;
				}
			}
			else {
				$linha = $resultado_qry->fetch_assoc();
				echo $linha["ID_QUADRA"];
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'DELETE_QUADRA') {
		$strSQL = 
			"DELETE FROM agenda WHERE ID_QUADRA = " . $_POST["ID_QUADRA"] . ';' .
			"DELETE FROM horario WHERE ID_QUADRA = " . $_POST["ID_QUADRA"] . ';' .
			"DELETE FROM quadra WHERE ID_QUADRA = " . $_POST["ID_QUADRA"] . ';' .
			"DELETE FROM contato WHERE ID_QUADRA = " . $_POST["ID_QUADRA"] . ';' .
			"DELETE FROM endereco WHERE ID_QUADRA = " . $_POST["ID_QUADRA"] . ';';
			
		if ($conexao->multi_query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'UPDATE_INFO_ESTAB') {
		$strSQL =
			"UPDATE quadra SET " .
			" ID_TIPO_QUADRA = " . $_POST["ID_TIPO_QUADRA"] . ',' .
			" DESCRICAO = " . "'" . $_POST["DESCRICAO"] . "'" . ',' .
			" TAMANHO = " . "'" . $_POST["TAMANHO"] . "'" . ',' .
			" PRECO_HORA = " . $_POST["PRECO_HORA"] .
			" WHERE ID_QUADRA = " . $_POST["ID_QUADRA"];
		
		if ($conexao->query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'UPDATE_ENDERECO_ESTAB') {
		$strSQL =
			"UPDATE endereco SET " .
			" ENDERECO = " . "'" . $_POST["ENDERECO"] . "'" . ',' .
			" BAIRRO = " . "'" . $_POST["BAIRRO"] . "'" . ',' .
			" NUMERO = " . $_POST["NUMERO"] . ',' .
			" ID_CIDADE = " . $_POST["ID_CIDADE"] .
			" WHERE ID_QUADRA = " . $_POST["ID_QUADRA"];
		
		if ($conexao->query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'UPDATE_CONTATO_ESTAB') {
		$strSQL =
			"UPDATE contato SET " .
			" EMAIL = " . "'" . $_POST["EMAIL"] . "'" . ',' .
			" TELEFONE1 = " . "'" . $_POST["TELEFONE1"] . "'" . ',' .
			" TELEFONE2 = " . "'" . $_POST["TELEFONE2"] . "'" . ',' .
			" CELULAR1 = " . "'" . $_POST["CELULAR1"] . "'" . ',' .
			" CELULAR2 = " . "'" . $_POST["CELULAR2"] . "'" . ',' .
			" LINK_SITE = " . "'" . $_POST["LINK_SITE"] . "'" . ',' .
			" LINK_FACEBOOK = " . "'" . $_POST["LINK_FACEBOOK"] . "'" .
			" WHERE ID_QUADRA = " . $_POST["ID_QUADRA"];
		
		if ($conexao->query($strSQL) === FALSE) {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	$conexao->close();

?>