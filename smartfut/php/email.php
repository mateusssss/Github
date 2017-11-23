<?php
	include "conexao_bd.php";
	
	$strSQL = 
		"SELECT B.NOME, B.LOGIN, " .
		" C.EMAIL, C.TELEFONE1, C.TELEFONE2, C.CELULAR1, C.CELULAR2, C.LINK_SITE, C.LINK_FACEBOOK " .
		" FROM agenda A " .
		" LEFT JOIN usuario B ON A.ID_USUARIO = B.ID_USUARIO " .
		" LEFT JOIN contato C ON A.ID_USUARIO = C.ID_USUARIO" .
		" WHERE A.ID_AGENDA = " . $_POST["ID_AGENDA"];

	if ($resultado_qry = $conexao->query($strSQL)) {
		$linha = $resultado_qry->fetch_assoc();
		
	
		$Nome		= $linha["NOME"];	// Pega o valor do campo Nome
	    $Fone		= $linha["TELEFONE1"];	// Pega o valor do campo Telefone
	    $Email		= $linha["EMAIL"];	// Pega o valor do campo Email
	    $Mensagem	= "Reserva confirmada no campinho de futebor!!!";	// Pega os valores do campo Mensagem
	}
	
	$conexao->close();
	
	/*----------------------------*/
	/*
	$Nome		= $_POST["Nome"];	// Pega o valor do campo Nome
	$Fone		= $_POST["Fone"];	// Pega o valor do campo Telefone
	$Email		= $_POST["Email"];	// Pega o valor do campo Email
	$Mensagem	= $_POST["Mensagem"];	// Pega os valores do campo Mensagem
	*/
	// Variável que junta os valores acima e monta o corpo do email

	$Vai 		= "Nome: $Nome\n\nE-mail: $Email\n\nTelefone: $Fone\n\nMensagem: $Mensagem\n";
	$Vem		= "Um novo cadastro de cliente foi efetuado!\n\nSegue algumas informações sobre ele:\n\nNome: $Nome\n\nE-mail: $Email\n\nTelefone: $Fone\n\nMensagem: $Mensagem\n";

	require_once("./PHPmailer/class.phpmailer.php");

	define('GUSER', 'smartfut.usf@gmail.com');	// <-- Insira aqui o seu GMail
	define('GPWD', 'usf@2017');		// <-- Insira aqui a senha do seu GMail

	function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
		global $error;
		$mail = new PHPMailer();
		$mail->IsSMTP();		// Ativar SMTP
		$mail->SMTPDebug = 1;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
		$mail->SMTPAuth = true;		// Autenticação ativada
		$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
		$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
		$mail->Port = 465;  		// A porta 587 deverá estar aberta em seu servidor
		$mail->Username = GUSER;
		$mail->Password = GPWD;
		$mail->SetFrom($de, $de_nome);
		$mail->Subject = $assunto;
		$mail->Body = $corpo;
		$mail->AddAddress($para);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else {
			$error = 'Mensagem enviada!';
			return true;
		}
	}

	// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
	//o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

	 if (
		(smtpmailer($Email, 'smartfut.usf@gmail.com', 'SmartFut', 'Reserva Efetuada', $Vai)) and 
		(smtpmailer('smartfut.usf@gmail.com', $Email, 'SmartFut', 'Reserva Efetuada', $Vem))){

		Header("location:index.php"); // Redireciona para uma página de obrigado.

	}
	if (!empty($error)) echo $error;
?>