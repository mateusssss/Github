<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Website CSS style -->
		<link href="css/cadastro.css" rel="stylesheet" type="text/css">

		<!-- Website Font style -->
		<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
		
		<!-- <link rel="stylesheet" href="style.css"> -->
		<!-- Google Fonts -->
		<link href='css/css_family_passion_one.css' rel='stylesheet' type='text/css'>
		<link href='css/css_family_oxygen.css' rel='stylesheet' type='text/css'>
		<link rel="css/bootstrap.min.css">
	
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
			<div class="row main col-lg-12">
				<div class="text-center">
					<p id="tit_smartfut" style="color: #99ccff;font-family: 'Kaushan Script', 'Helvetica Neue', Helvetica, Arial, cursive;font-size: 50px;">SmartFut</p>
				</div>
				<div class="main-login main-center bg-light-gray" style="color:#333;">
					<div class="text-center">
						<h5>Cadastre-se para utilizar as reservas.</h5>
					</div>
					<form method="post" id="form_cadastro">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Digite seu Nome</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="NOME" id="nome"  placeholder="Seu Nome"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Digite seu E-mail</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="email" class="form-control" name="EMAIL" id="email"  placeholder="Seu E-mail"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Digite seu Login</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="LOGIN" id="login"  placeholder="Usuário"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Digite sua Senha</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="PASSWORD" id="password"  placeholder="Senha"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="confirm" class="cols-sm-2 control-label">Confirme sua Senha</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="confirma" id="confirma"  placeholder="Confirme sua Senha"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<button type="button" id="btn_registrar" class="btn btn-primary btn-lg btn-block login-button">Registrar</button>
						</div>
						
					</form>
				</div>
			</div>
		</div>
		
	 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<script src="js/cadastro.js"></script>
	
	<!-- Core Scripts - Include with every page -->	    
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>

    <!-- Page-Level Plugin Scripts-->
    <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>

	
	</body>
</html>