<?php
	require "./php/sessao.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Website Font style -->
		<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!-- <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
		
		<!-- <link rel="stylesheet" href="style.css"> -->
		<!-- Google Fonts -->
		<link href='css/css_family_passion_one.css' rel='stylesheet' type='text/css'>
		<link href='css/css_family_oxygen.css' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="./css/bootstrap.min.css">

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		
		<link rel='stylesheet' href='snippets/fullcalendar-3.4.0/lib/cupertino/jquery-ui.min.css' />
		<link href='snippets/fullcalendar-3.4.0/fullcalendar.min.css' rel='stylesheet' />
		<link href='snippets/fullcalendar-3.4.0/fullcalendar.print.min.css' rel='stylesheet' media='print' />
		<script src='snippets/fullcalendar-3.4.0/lib/moment.min.js'></script>
		<script src='snippets/fullcalendar-3.4.0/fullcalendar.min.js'></script>
		<script src='snippets/fullcalendar-3.4.0/locale/pt-br.js'></script>
		
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

		<?php
		include "./snippets/fullcalendar.html";
		?>
		
		<title>SmartFut</title>
	</head>
	<body id="page-top" class="index" style="background-color:#333;">

		<!-- Navigation -->
		<nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header page-scroll">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
					</button>
					<a class="navbar-brand page-scroll" href="#page-top">SmartFut</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li class="hidden">
							<a href="#page-top"></a>
						</li>
						<li>
							<a href="cad_agendamento.php">Agendamento</a>
						</li>
						<?php 
						if ($_SESSION["TIPO_PERFIL"] == 1) {
							echo 
								'<li>' .
									'<a href="cad_horario.php">Manutenção</a>' .
								'</li>';
						}
						?>						
						<li>
							<a href="cad_usuario.php">Meu Perfil</a>
						</li>
						<li>
							<a href="php/logout.php"><i class="fa fa-sign-out fa-fw"></i>Sair</a>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>