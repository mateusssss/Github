<?php
	include "conexao_bd.php";
	
	session_start();
	
	$strSQL = 
		"SELECT ID_AGENDA, SITUACAO FROM agenda WHERE ID_QUADRA = " . $_POST["ID_QUADRA"] . 
		" AND (SITUACAO > " . $_POST["SITUACAO"] . " OR ID_USUARIO = " . $_SESSION["ID_USUARIO"] . ")";
	$array_resposta = "0";
	
	if ($resultado_qry = $conexao->query($strSQL)) {
		if (mysqli_num_rows($resultado_qry) > 0) {
			$array_resposta = '[';
			while($linha = $resultado_qry->fetch_assoc()) {
				$array_resposta = $array_resposta . "[" . $linha["ID_AGENDA"] . ',' . $linha["SITUACAO"] . '],';
			}
			$array_resposta = substr($array_resposta, 0, strlen($array_resposta) - 1) . ']';
		}
	}
	
	echo $array_resposta;
	
	
	$conexao->close();
?>