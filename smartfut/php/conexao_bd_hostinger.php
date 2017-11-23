<?php
// Conexão com o Banco de Dados
$servername = "mysql.hostinger.com.br";
$username = "u831834061_admin";
$password = "projintegrador";
$data_base = "u831834061_smfut";

$conexao = new mysqli($servername, $username, $password, $data_base);

//verificar conexão
if ($conexao->connect_error) {
	die("Conexão Falhou: " . $conexao->connect_error);
}

?>