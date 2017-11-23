<?php
// Conexão com o Banco de Dados
$servername = "localhost";
$username = "root";
$password = "";
$data_base = "smartfut";

$conexao = new mysqli($servername, $username, $password, $data_base);
mysqli_set_charset($conexao,'utf8');

//verificar conexão
if ($conexao->connect_error) {
	die("Conexão Falhou: " . $conexao->connect_error);
}

?>