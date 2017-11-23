<?php
	include "./menu_geral_1_calendar.php";
?>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	<div class="col-lg-12">
		 <!--  Modals-->			
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Horários Disponíveis</h4>
					</div>
					<div class="modal-body" id="conteudo_modal" style="height:388px; overflow: auto;">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" id="btn_confirmar">Confirmar</button>
					</div>
				</div>
			</div>
		</div>
		 <!-- End Modals-->
	</div>
	
	<div class="col-lg-12">
		 <!--  Modals-->			
		<div class="modal fade" id="myModal_quadra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_quadra" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel_quadra">Seleção de Estabelecimento</h4>
					</div>
					<div class="modal-body">
						<!--Collapsible Accordion Panel Group   -->
						<div class="panel panel-default">							
							<div class="panel-body">
								<div class="panel-group" id="accordion">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseCidade">Escolher Cidade</a>
											</h4>
										</div>
										<div id="collapseCidade" class="panel-collapse collapse in">
											<div class="panel-body">
												<!--   Basic Table  -->
												<div class="panel panel-default">
													<div class="panel-heading">
														
													</div>
													<div class="panel-body" style="height:388px; overflow: auto;">
														<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th>Cidade</th>
																	</tr>
																</thead>
																<tbody id="tab_cidade">
																	<?php
																		include "./php/conexao_bd.php";
																		
																		$strSQL = "SELECT ID_CIDADE, CIDADE FROM cidade";
																		
																		if ($resultado_qry = $conexao->query($strSQL)) {
																			$tabela_cidade = '';
																			while ($linha = $resultado_qry->fetch_assoc()) {
																				$tabela_cidade = $tabela_cidade .
																					'<tr class="linha_cidade" data-idcidade="' . $linha["ID_CIDADE"] . '">' .
																						'<td>' . $linha["CIDADE"] . '</td>' .
																					'</tr>';
																			}
																			
																			echo $tabela_cidade;
																		}
																		
																		$conexao->close();
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												  <!-- End  Basic Table  -->
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseQuadra" id="collapseQuadraLink">Escolher Quadra</a>
											</h4>
										</div>
										<div id="collapseQuadra" class="panel-collapse collapse">
											<div class="panel-body">
												<!--   Basic Table  -->
												<div class="panel panel-default">
													<div class="panel-heading">
														
													</div>
													<div class="panel-body" style="height:388px; overflow: auto;">
														<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th>Nome Estabelecimento</th>
																	</tr>
																</thead>
																<tbody id="tab_quadra"></tbody>
															</table>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-primary" data-dismiss="modal">Selecionar</button>
													</div>
												</div>
												  <!-- End  Basic Table  -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						 <!--End Collapsible Accordion Panel Group   -->
					</div>
				</div>
			</div>
		</div>
		 <!-- End Modals-->
	</div>

	<section>
		<div id="principal">
			<div class="container">
				<div class="row bg-light-gray">
					<div class="col-lg-12">					
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<h4 data-toggle="modal" data-target="#myModal_quadra" id="titulo_calendario">
									Clique aqui para selecionar um estabelecimento
								</h4>
							</div>
							<div class="panel-body" id="painel_calendario" >
								<div id='calendar'></div>
								<!--<button type="button" class="btn btn-default btn-md btn-block" id="btn_atualizar_agenda">Atualizar Agenda</button>-->
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php
				include "./rodape.php";
			?>
		</div>
	
	</section>
	
	
	<script src="js/cad_agendamento.js"></script>
	
	<?php echo '<script> id_usuario = ' 		. $_SESSION["ID_USUARIO"] 		. '; </script>'; ?>
	<?php echo '<script> id_perfil = ' 			. $_SESSION["ID_PERFIL"] 		. '; </script>'; ?>
	<?php echo '<script> nome_usuario = ' . "'" . $_SESSION["NOME"] . "'"		. '; </script>'; ?>
	<?php if (isset($_COOKIE["id_quadra"])) echo '<script> id_quadra = ' . $_COOKIE["id_quadra"] . '; </script>'; ?>
	<?php if (isset($_COOKIE["nome_quadra"])) echo '<script> nome_quadra = ' . "'" . $_COOKIE["nome_quadra"] . "'" . '; </script>'; ?>
	
<?php
	include "./menu_geral_2.php";
?>