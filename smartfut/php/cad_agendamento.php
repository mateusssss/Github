<?php
	include "conexao_bd.php";
	
	if ($_POST["MODO"] == 'ATUALIZAR_AGENDA') {
		session_start();
		
		$strSQL = 
			'SELECT A.ID_AGENDA, A.DATA, A.HORA, A.DATA_FIM, A.HORA_FIM, A.TITULO, A.SITUACAO, B.NOME ' .
			' FROM agenda A' .
			' LEFT JOIN usuario B ON A.ID_USUARIO = B.ID_USUARIO' .
			' WHERE A.ID_QUADRA = ' . $_POST["ID_QUADRA"] .
			' AND (A.SITUACAO > 1 ' . 
			' OR (A.ID_USUARIO = ' . $_SESSION["ID_USUARIO"] . ' AND A.SITUACAO = 1))';
			
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$agenda_json = '{"AGENDA":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$agenda_json = $agenda_json . '{';
					$agenda_json = $agenda_json . 
										'"ID_AGENDA":' 	. '"' . $linha[0] . '"' . ',' .
										'"DATA":' 		. '"' . $linha[1] . '"' . ',' .
										'"HORA":' 		. '"' . $linha[2] . '"' . ',' .
										'"DATA_FIM":' 	. '"' . $linha[3] . '"' . ',' .
										'"HORA_FIM":' 	. '"' . $linha[4] . '"' . ',' .
										'"TITULO":' 	. '"' . $linha[5] . '"' . ',' .
										'"SITUACAO":' 	. '"' . $linha[6] . '"' . ',' .
										'"NOME":' 		. '"' . $linha[7] . '"';
					
					$agenda_json = $agenda_json . '}, ';
				}
				$agenda_json = substr($agenda_json, 0, strlen($agenda_json) - 2);
				$agenda_json = $agenda_json . ']}';
				
				if (!isset($_COOKIE["id_quadra"])) {
					setcookie("id_quadra", $_POST["ID_QUADRA"], time() + (86400 * 30), "/");
				}
				
				echo $agenda_json;
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'DELETE') {
		$strSQL = 
			'SELECT ID_AGENDA, ID_USUARIO ' .
			' FROM agenda ' .
			' WHERE ID_AGENDA = ' . $_POST["ID_AGENDA"];
		
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$linha = $resultado_qry->fetch_row();
				if ($linha[1] == $_POST["ID_USUARIO"]) {
					$strSQL = 
						'DELETE FROM agenda WHERE ID_AGENDA = ' . $linha[0];
						
					if ($conexao->query($strSQL) === TRUE) {
						echo "Requisição cancelada.";
					}
					else {
						echo "Erro: " . $strSQL . "<br>" . $conexao->error;
					}
				}
				else {
					echo "Você não tem permissão para cancelar esta requisição.";
				}
				
			}
			else {
				echo "Registro não encontrado";
			}
		}
		else {
			echo "Erro: " . $strSQL . "<br>" . $conexao->error;
		}
	}
	
	if ($_POST["MODO"] == 'INSERT') {
		if($_POST["DATA"] < date("Y-m-d")){
			$msg = "Requisição realizada com data anterior ao dia de hoje.";
			echo $msg;
		}
		else{
			$strSQL = 
				'SELECT ID_AGENDA, SITUACAO, ID_USUARIO FROM agenda ' . 
				' WHERE ID_QUADRA = ' . $_POST["ID_QUADRA"] .
				' AND DATA = ' . "'" . $_POST["DATA"] . "'" .
				' AND HORA = ' . "'" . $_POST["HORA"] . "'";

			if ($resultado_qry = $conexao->query($strSQL)) {
				$msg = '';
				while ($linha = $resultado_qry->fetch_assoc()) {
					if ($linha["SITUACAO"] == 1 && $linha["ID_USUARIO"] == $_POST["ID_USUARIO"]) {
						$msg = "Você já fez uma requisição para este horário.";
						break;
					}
				
					if ($linha["SITUACAO"] > 1) {
						$msg = "Horário indisponível.";
						break;
					}
				}
			
				if ($msg == '') {
					$strSQL =
						'INSERT INTO agenda (ID_QUADRA, ID_USUARIO, TITULO, DIA_SEMANA, HORA, DATA, HORA_FIM, DATA_FIM, SITUACAO) VALUES (' .
						$_POST["ID_QUADRA"] . ',' .
						$_POST["ID_USUARIO"] . ',' .
						"'" . $_POST["NOME_USUARIO"] . "'" . ',' .
						$_POST["DIA_SEMANA"] . ',' .
						"'" . $_POST["HORA"] . "'" . ',' .
						"'" . $_POST["DATA"] . "'" . ',' .
						"'" . $_POST["HORA_FIM"] . "'" . ',' .
						"'" . $_POST["DATA_FIM"] . "'" . ',' .
						"1" . ')';
				
					if ($conexao->query($strSQL) === TRUE) {
						echo 'Requisição concluída.';
					}
					else {
						echo "Erro: " . $strSQL . "<br>" . $conexao->error;
					}
				}
				else {
					echo $msg;
				}
			}
			else {
				echo "Erro: " . $strSQL . "<br>" . $conexao->error;
			}
		}
	}
	
	if ($_POST["MODO"] == 'ATUALIZAR_MODAL_QUADRA') {
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
			' WHERE C.ID_CIDADE = ' . $_POST["ID_CIDADE"] .
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
	
	if ($_POST["MODO"] == 'ATUALIZAR_MODAL') {
		$dia_semana = date("w", strtotime($_POST["DATA"]));
		$dia_semana = $dia_semana - 1;
		if ($dia_semana < 0)
			$dia_semana = 6;
		
		$strSQL =
			"SELECT DISTINCT A.DIA_SEMANA, A.HORA, " .

			" IFNULL((SELECT B.TITULO FROM agenda B " .
				" WHERE B.HORA = A.HORA AND " .
				" B.DIA_SEMANA = A.DIA_SEMANA AND " .
				" B.SITUACAO = 1 AND " .
				" B.ID_QUADRA =" . $_POST["ID_QUADRA"]. " AND " .
				" B.DATA = " . "'" . $_POST["DATA"] . "'" . " LIMIT 1),'DISPONIVEL') AS REQUISITADO, " .
			" IFNULL(C.TITULO,'DISPONIVEL') AS CONFIRMADO, " .
			" IFNULL(D.TITULO,'DISPONIVEL') AS RECESSO, " .
			"(SELECT COUNT(E.ID_AGENDA) FROM agenda E " .
				" WHERE E.HORA = A.HORA AND " .
				" E.DIA_SEMANA = A.DIA_SEMANA AND " .
				" E.SITUACAO = 1 AND " .
				" E.ID_QUADRA = " . $_POST["ID_QUADRA"] . " AND " .
				" E.DATA = " . "'" . $_POST["DATA"] . "'" . ") AS QTD_REQUISICOES " .
			" FROM horario A " .
			" LEFT JOIN agenda C ON " .
				" A.HORA = C.HORA AND " .
				" A.DIA_SEMANA = C.DIA_SEMANA AND " .
				" C.SITUACAO = 2 AND " .
				" C.ID_QUADRA = " . $_POST["ID_QUADRA"] .
				" AND C.DATA = " . "'" . $_POST["DATA"] . "'" .
			"LEFT JOIN agenda D ON " .
				" D.SITUACAO = 3 AND " .
				" D.ID_QUADRA = " . $_POST["ID_QUADRA"] .
				" AND (CONVERT(CONCAT("  . "'" . $_POST["DATA"] . " '" . ", A.HORA, ':00'),DATETIME) BETWEEN " .
					"CONVERT(CONCAT(D.DATA, ' ', D.HORA, ':00'),DATETIME) AND " .
					"CONVERT(CONCAT(D.DATA_FIM, ' ', D.HORA_FIM, ':00'),DATETIME))" .
			" WHERE A.ID_QUADRA = " . $_POST["ID_QUADRA"] .
			" AND A.DIA_SEMANA = " . $dia_semana .
			" ORDER BY A.DIA_SEMANA, CAST(REPLACE(A.HORA,':','') AS INTEGER)";

		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$tab_horario_json = '{"TABELA_HORARIO":[';
				while ($linha = $resultado_qry->fetch_row()) {
				
					$tab_horario_json = $tab_horario_json . '{';
					$tab_horario_json = $tab_horario_json . 
										'"DIA_SEMANA":' . '"' . $linha[0] . '"' . ',' .
										'"HORA":' . '"' . $linha[1] . '"' . ',' .
										'"REQUISITADO":' . '"' . $linha[2] . '"' . ',' .
										'"CONFIRMADO":' . '"' . $linha[3] . '"' . ',' .
										'"RECESSO":' . '"' . $linha[4] . '"' . ',' .
										'"QTD_REQUISICOES":' . '"' . $linha[5] . '"';
					
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
	
	$conexao->close();

?>