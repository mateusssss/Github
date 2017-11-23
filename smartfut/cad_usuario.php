<?php
	include "./menu_geral_1.php";
?>

	<section>
		<div id="principal" hidden>
			<div class="container">
				<div class="row bg-light-gray">
					<div class="panel-body">					
						<div class="tab-pane fade in active" id="dados_pessoais_tab">
							<h4>Alteração de Dados Pessoais</h4>
							
							<div class="col-lg-12">
								<div class="panel panel-default">									
									<div class="panel-body">
										<ul class="nav nav-pills">
											<li class="active"><a href="#cad_usuario_tab" data-toggle="tab">Dados Principais</a>
											</li>
											<li><a href="#cad_usuario_endereco_tab" data-toggle="tab">Endereco</a>
											</li>
											<li><a href="#cad_usuario_contato_tab" data-toggle="tab">Contato</a>
											</li>
										</ul>

										<div class="tab-content">
											<div class="tab-pane fade in active" id="cad_usuario_tab">
												<form id="cad_usuario_form">
													<fieldset>
														<br>
														<label>Nome</label>
														<input class="form-control" name="NOME" id="nome_usuario">
														<br>
														<label>Senha</label>
														<input class="form-control" name="PASSWORD" id="senha_usuario" type="password" placeholder="Insira nova senha">
														<p class="help-block">Preencha o campo se quiser alterar a senha atual.</p>
													</fieldset>
												</form>
												<br>
												<button type="button" class="btn btn-default btn-md btn-block" id="btn_update_usuario">Atualizar</button>
												<br>
											</div>
											<div class="tab-pane fade" id="cad_usuario_endereco_tab">
												<form id="cad_usuario_endereco_form">
													<fieldset>
														<br>
														<label>Endereço</label>
														<input class="form-control" name="ENDERECO" id="endereco_usuario">
														<br>
														<label>Bairro</label>
														<input class="form-control" name="BAIRRO" id="bairro_usuario">
														<br>
														<label>Número</label>
														<input class="form-control" type="number" name="NUMERO" id="numero_usuario">
														<br>
														<label>Cidade</label>
														<select class="form-control" name="ID_CIDADE" id="cidade_usuario">
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
												<button type="button" class="btn btn-default btn-md btn-block" id="btn_update_endereco_usuario">Atualizar</button>
												<br>
											</div>
											<div class="tab-pane fade" id="cad_usuario_contato_tab">
												<form id="cad_usuario_contato_form">
													<fieldset>
														<br>
														<label>E-Mail</label>
														<input class="form-control" type="email" name="EMAIL" id="email_usuario">
														<br>
														<label>Telefone 1</label>
														<input class="form-control" type="tel" name="TELEFONE1" id="telefone1_usuario">
														<br>
														<label>Telefone 2</label>
														<input class="form-control" type="tel" name="TELEFONE2" id="telefone2_usuario">
														<br>
														<label>Celular 1</label>
														<input class="form-control" type="tel" name="CELULAR1" id="celular1_usuario">
														<br>
														<label>Celular 2</label>
														<input class="form-control" type="tel" name="CELULAR2" id="celular2_usuario">
														<br>
														<label>Site</label>
														<input class="form-control" type="url" name="LINK_SITE" id="site_usuario">
														<br>
														<label>Facebook</label>
														<input class="form-control" type="url" name="LINK_FACEBOOK" id="facebook_usuario">
													</fieldset>
												</form>
												<br>
												<button type="button" class="btn btn-default btn-md btn-block" id="btn_update_contato_usuario">Atualizar</button>
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
			
			<?php
				include "./rodape.php";
			?>
		</div>
		
	</section>
	
	<script src="js/cad_usuario.js"></script>
	<?php echo '<script> var id_usuario = ' . $_SESSION["ID_USUARIO"] . '</script>'; ?>
	<?php echo '<script> var id_perfil = ' . $_SESSION["ID_PERFIL"] . '</script>'; ?>
	
<?php
	include "./menu_geral_2.php";
?>