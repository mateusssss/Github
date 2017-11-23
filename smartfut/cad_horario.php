<?php
	include "./menu_geral_1.php";
	
	if ($_SESSION["TIPO_PERFIL"] == 0) {	
		header('Location: index.php');	
	}
?>

	<div class="col-lg-12">
		 <!--  Modals-->			
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Dados Pessoais</h4>
					</div>
					<div class="modal-body" id="conteudo_modal">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
		 <!-- End Modals-->
	</div>
	
	<section>
		<div id="principal" hidden>
			<div class="container">
				<div class="row bg-light-gray panel-default">
					<div class="panel-heading">
						<h4 id="head_quadra_selecionada">Quadra: </h4>
					</div>
					<div class="panel-body">
						<ul class="nav nav-pills">
							<li class="active"><a href="#sel_quadra_tab" data-toggle="tab">Início</a>
							</li>
							<li><a href="#cad_horario_tab" data-toggle="tab">Horário</a>
							</li>
							<li><a href="#cad_recesso_tab" data-toggle="tab">Recesso</a>
							</li>
							<li><a href="#estabelecimento_tab" data-toggle="tab">Estabelecimentos</a>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane fade in active" id="sel_quadra_tab">
								<h4>Manutenção de Requisições de Reservas</h4>
								
								<div class="col-lg-12">
									<div class="form-group">
										<div class="col-lg-4">
											 <!--   Basic Table  -->
											<div class="panel panel-default">
												<div class="panel-heading">
													Seleção de Estabelecimentos
												</div>
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table">
															<thead>
																<tr>
																	<th>Código</th>
																	<th>Nome Estabelecimento</th>
																</tr>
															</thead>
															<tbody id="tab_sel_quadra"></tbody>
														</table>
													</div>
												</div>
											</div>
											  <!-- End  Basic Table  -->
										</div>
										
										<div class="col-lg-8">
											 <!--   Basic Table  -->
											<div class="panel panel-default">
												<div class="panel-heading">
													Lista de Requisições
													<div>
														<div class="form-group">
															<input type="date" class="form-control" id="sel_data_ini"></input>
															<input type="date" class="form-control" id="sel_data_fim"></input>
															
															<div class="checkbox">
																<label><input type="checkbox" id="check_fila" value=""/>Mostrar apenas primeiro da fila</label>
															</div>
														</div>
													</div>
												</div>
												<div class="panel-body">
													<div class="table-responsive">
														<table class="table">
															<thead>
																<tr>
																	<th>Dia</th>
																	<th>Hora</th>
																	<th>Usuários</th>
																	<th colspan="2">Opções</th>
																</tr>
															</thead>
															<tbody id="tab_requisicoes"></tbody>
														</table>
													</div>
												</div>
											</div>
											  <!-- End  Basic Table  -->
										</div>
									</div>
								</div>
							</div>
						
							<div class="tab-pane fade" id="cad_horario_tab">
								<h4>Cadastro de Horário de Funcionamento</h4>
								<div class="col-lg-12">
									<div class="form-group">
										<label>Dia da Semana</label>
										<select class="form-control" id="dia_semana">
											<option value="0">Segunda</option>
											<option value="1">Terça</option>
											<option value="2">Quarta</option>
											<option value="3">Quinta</option>
											<option value="4">Sexta</option>
											<option value="5">Sábado</option>
											<option value="6">Domingo</option>
										</select>
										<br>
										<label>Horário</label>
										<select class="form-control" id="horario"></select>
										<br>
										<button type="button" class="btn btn-default btn-md btn-block" id="btn_adicionar">Adicionar</button>
										<br><br>
									</div>
								</div>
								<div class="col-lg-12">
									 <!--   Basic Table  -->
									<div class="panel panel-default">
										<div class="panel-heading">
											Horário de Funcionamento
										</div>
										<div class="panel-body">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th>Segunda</th>
															<th>Terça</th>
															<th>Quarta</th>
															<th>Quinta</th>
															<th>Sexta</th>
															<th>Sábado</th>
															<th>Domingo</th>
														</tr>
													</thead>
													<tbody id="tab_horario"></tbody>
												</table>
											</div>
										</div>
									</div>
									  <!-- End  Basic Table  -->
								</div>
							</div>
							
							<div class="tab-pane fade" id="cad_recesso_tab">
								<h4>Cadastro de Evento de Recesso</h4>
								
								<div class="col-lg-12">
									<div class="form-group">
										<label>Título do Evento</label>
										<input class="form-control" id="titulo_evento"></input>
										<br>
										<div class="col-lg-4">
											<label>Data Inicial</label>
											<input type="datetime-local" class="form-control" id="data_inicial"></input>
											<br>
										</div>
										<div class="col-lg-4">
											<label>Data Final</label>
											<input type="datetime-local" class="form-control" id="data_final"></input>
											<br>
										</div>
										<button type="button" class="btn btn-default btn-md btn-block" id="btn_add_evento">Adicionar</button>
										<br><br>
									</div>
								</div>
								<div class="col-lg-12">
									 <!--   Basic Table  -->
									<div class="panel panel-default">
										<div class="panel-heading">
											Eventos de Recesso
										</div>
										<div class="panel-body">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th>Título</th>
															<th>Data Inicial</th>
															<th>Hora Inicial</th>
															<th>Data Final</th>
															<th>Hora Final</th>
															<th>Excluir</th>
														</tr>
													</thead>
													<tbody id="tab_evento"></tbody>
												</table>
											</div>
										</div>
									</div>
									  <!-- End  Basic Table  -->
								</div>
							</div>
							
							<div class="tab-pane fade" id="estabelecimento_tab">
								<h4>Cadastro de Estabelecimentos</h4>
								
								<div class="col-lg-12">
								
									<div class="panel panel-default">									
										<div class="panel-body">
											<ul class="nav nav-pills">
												<li class="active"><a href="#cad_quadra_tab" data-toggle="tab">Quadra</a>
												</li>
												<li><a href="#cad_info_quadra_tab" data-toggle="tab">Informações</a>
												</li>
												<li><a href="#cad_end_quadra_tab" data-toggle="tab">Endereco</a>
												</li>
												<li><a href="#cad_contato_quadra_tab" data-toggle="tab">Contato</a>
												</li>
											</ul>

											<div class="tab-content">
												<div class="tab-pane fade in active" id="cad_quadra_tab">
													<div class="col-lg-12">
														<div class="form-group">
															<form id="estabelecimentos_form">
																<fieldset>
																	<br>
																	<label>Nome do Estabelecimento</label>
																	<input class="form-control" name="DESCRICAO" id="nome_estabelecimento_add">
																</fieldset>
															</form>
															<br>
															<button type="button" class="btn btn-default btn-md btn-block" id="btn_add_estab">Adicionar</button>
															<br>
														</div>
													</div>
													<div class="col-lg-12">
														 <!--   Basic Table  -->
														<div class="panel panel-default">
															<div class="panel-heading">
																Estabelecimentos
															</div>
															<div class="panel-body">
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
														</div>
														  <!-- End  Basic Table  -->
													</div>
												</div>
												<div class="tab-pane fade" id="cad_info_quadra_tab">
													<form id="info_quadra_form">
														<fieldset>
															<br>
															<label>Nome do Estabelecimento</label>
															<input class="form-control" name="DESCRICAO" id="nome_estabelecimento">
															<br>
															<label>Preço hora</label>
															<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-usd"></i></span>
																<input class="form-control" type="number" name="PRECO_HORA" id="preco_estabelecimento">
															</div>
															<br>
															<label>Tamanho da Quadra</label>
															<input class="form-control" name="TAMANHO" id="tamanho_estabelecimento">
															<br>
															<label>Tipo de Quadra</label>
															<select class="form-control" name="ID_TIPO_QUADRA" id="tipo_estabelecimento">
																<?php
																	include "./php/conexao_bd.php";
																	
																	$strSQL = "SELECT ID_TIPO_QUADRA, TIPO_QUADRA FROM tipo_quadra ORDER BY TIPO_QUADRA";
																	
																	$opcoes = '<option value="0">Não Definido</option>';
																	if ($resultado_qry = $conexao->query($strSQL)) {
																		while ($linha = $resultado_qry->fetch_assoc()) {
																			$opcoes = $opcoes .
																				'<option value="' . $linha["ID_TIPO_QUADRA"] . '">' . $linha["TIPO_QUADRA"] . '</option>';
																		}
																		
																		echo $opcoes;
																	}
																	
																	$conexao->close();
																?>
															</select>
														</fieldset>
													</form>
													<br>
													<button type="button" class="btn btn-default btn-md btn-block" id="btn_update_info_estab">Atualizar</button>
													<br>
												</div>
												<div class="tab-pane fade" id="cad_end_quadra_tab">
													<form id="endereco_quadra_form">
														<fieldset>
															<br>
															<label>Endereço</label>
															<input class="form-control" name="ENDERECO" id="endereco_estabelecimento">
															<br>
															<label>Bairro</label>
															<input class="form-control" name="BAIRRO" id="bairro_estabelecimento">
															<br>
															<label>Número</label>
															<input class="form-control" type="number" name="NUMERO" id="numero_estabelecimento">
															<br>
															<label>Cidade</label>
															<select class="form-control" name="ID_CIDADE" id="cidade_estabelecimento">
																<?php
																	include "./php/conexao_bd.php";
																	
																	$strSQL = "SELECT ID_CIDADE, CIDADE FROM cidade ORDER BY CIDADE";
																	
																	$opcoes = '<option value="0">Não Definido</option>';
																	if ($resultado_qry = $conexao->query($strSQL)) {
																		while ($linha = $resultado_qry->fetch_assoc()) {
																			$opcoes = $opcoes .
																				'<option value="' . $linha["ID_CIDADE"] . '">' . $linha["CIDADE"] . '</option>';
																		}
																		
																		echo $opcoes;
																	}
																	
																	$conexao->close();
																?>
															</select>
														</fieldset>
													</form>
													<br>
													<button type="button" class="btn btn-default btn-md btn-block" id="btn_update_endereco_estab">Atualizar</button>
													<br>
												</div>
												<div class="tab-pane fade" id="cad_contato_quadra_tab">
													<form id="contato_quadra_form">
														<fieldset>
															<br>
															<label>E-Mail</label>
															<input class="form-control" type="email" name="EMAIL" id="email_estabelecimento">
															<br>
															<label>Telefone 1</label>
															<input class="form-control" type="tel" name="TELEFONE1" id="telefone1_estabelecimento">
															<br>
															<label>Telefone 2</label>
															<input class="form-control" type="tel" name="TELEFONE2" id="telefone2_estabelecimento">
															<br>
															<label>Celular 1</label>
															<input class="form-control" type="tel" name="CELULAR1" id="celular1_estabelecimento">
															<br>
															<label>Celular 2</label>
															<input class="form-control" type="tel" name="CELULAR2" id="celular2_estabelecimento">
															<br>
															<label>Site</label>
															<input class="form-control" type="url" name="LINK_SITE" id="site_estabelecimento">
															<br>
															<label>Facebook</label>
															<input class="form-control" type="url" name="LINK_FACEBOOK" id="facebook_estabelecimento">
														</fieldset>
													</form>
													<br>
													<button type="button" class="btn btn-default btn-md btn-block" id="btn_update_contato_estab">Atualizar</button>
													<br>
												</div>
											</div>
										</div>
									</div>
								</div>
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
	
	<script src="js/cad_horario.js"></script>
	
	<?php echo '<script> id_usuario_corrente = ' . $_SESSION["ID_USUARIO"]	. '; </script>'; ?>
	<?php echo '<script> id_perfil = ' . $_SESSION["ID_PERFIL"]	. '; </script>'; ?>
	<?php 
		include "./php/conexao_bd.php";
		
		$strSQL = 'SELECT ID_PERFIL FROM quadra WHERE ID_QUADRA = ' . $_COOKIE["id_quadra"];
		if ($resultado_qry = $conexao->query($strSQL)) {
			if (mysqli_num_rows($resultado_qry) > 0) {
				$linha = $resultado_qry->fetch_assoc();
				
				if ($linha["ID_PERFIL"] == $_SESSION["ID_PERFIL"]) {
					if (isset($_COOKIE["id_quadra"])) 
						echo '<script> id_quadra = ' . $_COOKIE["id_quadra"] . '; </script>';
					
					if (isset($_COOKIE["nome_quadra"])) 
						echo '<script> nome_quadra = ' . "'" . $_COOKIE["nome_quadra"] . "'" . '; </script>';
				}
			}
		}
		
		$conexao->close();
	?>
	
<?php
	include "./menu_geral_2.php";
?>