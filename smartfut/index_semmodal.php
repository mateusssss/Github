<!--
	Inspired by http://dribbble.com/shots/917819-iPad-Calendar-Login?list=shots&sort=views&timeframe=ever&offset=461
-->
<html>
	<head>
		<!-- 
		-->
		<meta name="keywords" content="HTML, CSS, XML, XHTML, JavaScript, PHP">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
		<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
		<link href="assets/css/style.css" rel="stylesheet" />
		<link href="assets/css/main-style.css" rel="stylesheet" />

		<!-- Bootstrap Core CSS -->
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="css/css_family_montserrat.css" rel="stylesheet" type="text/css">
		<link href='css/css_family_kaushan_script.css' rel='stylesheet' type='text/css'>
		<link href='css/css_family_droid_serif.css' rel='stylesheet' type='text/css'>
		<link href='css/css_family_roboto_slab.css' rel='stylesheet' type='text/css'>

		<!-- Theme CSS -->
		<link href="css/agency.min.css" rel="stylesheet">
		
		<title>SmartFut</title>
	</head>
	<body class="body-Login-back" style="background-color:#333;">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 text-center logo-margin ">
					<p id="tit_smartfut" style="color: #99ccff;font-family: 'Kaushan Script', 'Helvetica Neue', Helvetica, Arial, cursive;font-size: 50px;">SmartFut</p>
				</div>
				<div class="col-md-4 col-md-offset-4">
					<div class="login-panel panel panel-default">
						<div class="panel-heading">
							<p class="panel-title">Insira Usuário e Senha</p>
						</div>
						<div class="panel-body" style="color:#333;">
							<form id="form_login">
								<fieldset>
									<div class="form-group">
										<input class="form-control" placeholder="Usuário" name="LOGIN" autofocus value=<?php echo '"'; if (isset($_COOKIE["login"])) echo $_COOKIE["login"]; echo '"'; ?>>
									</div>
									<div class="form-group">
										<input class="form-control" placeholder="Senha" name="PASSWORD" type="password" value="">
									</div>
									<div class="checkbox">
										<label>
											<input name="LEMBRAR" type="checkbox">Lembrar-me
										</label>
									</div>
									<br>
									<button type="Submit" href="index.php" class="btn btn-lg btn-primary btn-block" id="btn_login" value="Login">Login</button>
								</fieldset>
								<br>
								<div>
									<a href="cadastro.php" style="color: inherit;">Ainda não é cadastrado?</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		
		<!-- Core Scripts - Include with every page -->
		<script src="assets/plugins/jquery-1.10.2.js"></script>
		<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
		<script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
		
		<script src="js/login.js"></script>
	</body>
</html>