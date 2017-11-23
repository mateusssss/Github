var tab_horario_json;
var tab_evento_json;
var tab_quadra_json;
var tab_requisicao_json;
var tab_usuario_json;
var id_usuario_corrente;
var id_perfil;
var id_quadra;
var nome_quadra;
var hora_inicial = 6;
var hora_final = 20;

function preenche_hora() {
	var opcoes_horario = '';
	var hora_1;
	var hora_2;
	var i;
	
	for (i = hora_inicial; i < hora_final; i++) {
		if (i < 10) {
			hora_1 = '0' + i.toString() + ':00';
			hora_2 = '0' + i.toString() + ':30';
		}
		else {
			hora_1 = i.toString() + ':00';
			hora_2 = i.toString() + ':30';
		}
	
		opcoes_horario = opcoes_horario + '<option value="' + hora_1 + '">' + hora_1 + '</option>';
		opcoes_horario = opcoes_horario + '<option value="' + hora_2 + '">' + hora_2 + '</option>';
	}
	opcoes_horario = opcoes_horario + '<option value="' + hora_1 + '">' + hora_1 + '</option>';

	$("#horario").append(opcoes_horario);
}

function atualiza_tab_horario_json() {
	var comando_post = "MODO=ATUALIZAR&ID_QUADRA=" + id_quadra;

	if (id_quadra > 0) {
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				else {
					if (resposta != '') {
						tab_horario_json = JSON.parse(resposta);					
					}
					else {
						tab_horario_json = null;
					}
					atualiza_tabela();
				}
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
	else {
		tab_horario_json = null;
		atualiza_tabela();
	}
}

function atualiza_tabela() {
	var i,j;
	var seletor;
	var botao;
	var linha;
	var argumentos_btn
	var add_btn;
	
	$("#tab_horario").empty();
	
	if (tab_horario_json != null) {
		for (i = 0; i < tab_horario_json.TABELA_HORARIO.length; i++) {
		
			argumentos_btn = "'DELETE'," + tab_horario_json.TABELA_HORARIO[i].DIA_SEMANA + "," + "'" + tab_horario_json.TABELA_HORARIO[i].HORA + "'";
			botao = '<button type="button" class="btn btn-default" onclick="cadastrar_horario(' + argumentos_btn + ')">' + tab_horario_json.TABELA_HORARIO[i].HORA + '</button>';
			
			seletor = '.dia' + tab_horario_json.TABELA_HORARIO[i].DIA_SEMANA;
			
			if ($(seletor).length <= 0 || $(seletor).last().text().trim() != '') {
				linha = '<tr>' +
							'<td class="dia0">'		+
							'</td>'             	+
							'<td class="dia1">'  	+
							'</td>'             	+
							'<td class="dia2">'  	+
							'</td>'             	+
							'<td class="dia3">'  	+
							'</td>'             	+
							'<td class="dia4">'  	+
							'</td>'             	+
							'<td class="dia5">'  	+
							'</td>'             	+
							'<td class="dia6">'  	+
							'</td>'					+
						'</tr>';
				$("#tab_horario").append(linha);
			}
			
			add_btn = true;
			$(seletor).each(function(){
				if ($(this).text().trim() == '' && add_btn) {
					$(this).append(botao);
					add_btn = false;
				}
			});
		}
	}
}

function cadastrar_horario(modo, dia_semana, horario) {
	var comando_post;
		
	if (id_quadra > 0) {
		if (modo == 'INSERT') {
			dia_semana = $("#dia_semana").val();
			horario	= $("#horario").val();
		}
		
		comando_post = "MODO=" + modo + "&ID_QUADRA=" + id_quadra + "&DIA_SEMANA=" + dia_semana + "&HORA=" + horario;
		
		if (tab_horario_json == null) {
			if (confirm("Deseja adicionar todos os horários inicialmente?")) {
				comando_post = 
					"MODO=INSERT_HORARIO_INICIAL" + 
					"&ID_QUADRA=" + id_quadra + 
					"&HORA_INI=" + hora_inicial +
					"&HORA_FIM=" + hora_final;
			}
		}
	
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				
				if (comando_post.search('INSERT_HORARIO_INICIAL') > 0) {
					if (resposta != '') {
						tab_horario_json = JSON.parse(resposta);					
					}
					else {
						tab_horario_json = null;
					}
					atualiza_tabela();
				}
				else
					atualiza_tab_horario_json();
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
}

function valida_campos_evento () {
	var data_ini;
	var data_fim;
	
	if ($("#titulo_evento").val().trim() == '')
		return 'Titulo não pode estar vazio.';

	data_ini = new Date($("#data_inicial").val());
	if (data_ini == 'Invalid Date')
		return 'Data inicial invalida';
		
	data_fim = new Date($("#data_final").val());
	if (data_fim == 'Invalid Date')
		return 'Data final invalida';
	
	if (data_ini > data_fim)	
		return 'Data inicial maior que final';
	
	return '';
	
}

function cadastrar_evento(modo,id_agenda) {
	var cancelar;
	var comando_post = '';
	
	if (id_quadra > 0) {
		if (modo == 'INSERT_EVENTO') {
			if (valida_campos_evento() == '') {
				cancelar = confirm("Deseja cancelar requisições concorrentes com evento de recesso?");
			
				comando_post = 
					"MODO=" + modo +
					"&ID_AGENDA=" + id_agenda +
					"&ID_QUADRA=" + id_quadra + 
					"&ID_USUARIO=" + id_usuario_corrente +
					"&TITULO=" + $("#titulo_evento").val() + 		
					"&DATA=" + $("#data_inicial").val().split('T')[0] +
					"&HORA=" + $("#data_inicial").val().split('T')[1] +
					"&DATA_FIM=" + $("#data_final").val().split('T')[0] +
					"&HORA_FIM=" + $("#data_final").val().split('T')[1] +
					"&CANCELAR=" + cancelar;
			}
			else {
				alert(valida_campos_evento());
			}
		}
			
		if (modo == 'DELETE_EVENTO') {
			comando_post = 
				"MODO=" + modo +
				"&ID_AGENDA=" + id_agenda;
		}
		
		if (id_quadra > 0) {
			if (comando_post != '' && id_quadra > 0) {
				$.post("php/cad_horario.php",comando_post,function(resposta,status){		
					if (status == "success") {
						if (resposta != '')
							alert(resposta);
						
						atualiza_tab_evento_json();
					}
					else {
						alert("Falha na requisição!");
					}
				});
			}
		}
	}
}

function atualiza_tab_evento_json() {
	var comando_post = "MODO=ATUALIZAR_EVENTO&ID_QUADRA=" + id_quadra + "&ID_PERFIL=" + id_perfil;

	if (id_quadra > 0) {
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				else {			
					if (resposta != '') {
						tab_evento_json = JSON.parse(resposta);
					}
					else {
						tab_evento_json = null;
					}
					
					atualiza_tabela_evento();
				}
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
	else {
		tab_evento_json = null;
		atualiza_tabela_evento();
	}
}


function atualiza_tab_requisicao_json() {
	var data_ini;
	var data_fim;
	var comando_post = "MODO=ATUALIZAR_REQUISICAO&ID_QUADRA=" + id_quadra + "&DATA_INI=" + $("#sel_data_ini").val() + "&DATA_FIM=" + $("#sel_data_fim").val();
	
	data_ini = new Date($("#sel_data_ini").val());
	data_fim = new Date($("#sel_data_fim").val());
	if (data_ini == 'Invalid Date' || data_fim == 'Invalid Date') {		
		tab_requisicao_json = null;
		atualiza_tabela_requisicao();
		
		if ($("#sel_data_ini").val() != '' || $("#sel_data_fim").val() != '')
			alert("Data de seleção inválida.");
	}
	else
	if (id_quadra > 0) {
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {

				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				else {			
					if (resposta != '') {
						tab_requisicao_json = JSON.parse(resposta);
					}
					else {
						tab_requisicao_json = null;
					}
					
					atualiza_tabela_requisicao();
				}
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
	else {
		tab_requisicao_json = null;
		atualiza_tabela_requisicao();
	}
}

function atualiza_tabela_requisicao () {
	var linha;
	var argumentos_btn;
	var botao;
	var btn_class;
	var id_linha;
	var class_linha;
	var btn_exclusao;
	var data;
	var data_str;
	var data_primeiro_fila;
	var hora_primeiro_fila;
	var btn_info;
		
	$("#tab_requisicoes").empty();
	
	linha = '';
	if (tab_requisicao_json != null) {
		for (i = 0; i < tab_requisicao_json.TABELA_REQUISICAO.length; i++) {
			
			if (i == 0) {
				data_primeiro_fila = tab_requisicao_json.TABELA_REQUISICAO[i].DATA;
				hora_primeiro_fila = tab_requisicao_json.TABELA_REQUISICAO[i].HORA;
				
				class_linha = ' primeiro_fila';
			}
			else 
			if (data_primeiro_fila != tab_requisicao_json.TABELA_REQUISICAO[i].DATA || 
				hora_primeiro_fila != tab_requisicao_json.TABELA_REQUISICAO[i].HORA) {
					
				data_primeiro_fila = tab_requisicao_json.TABELA_REQUISICAO[i].DATA;
				hora_primeiro_fila = tab_requisicao_json.TABELA_REQUISICAO[i].HORA;
					
				class_linha = ' primeiro_fila';
			}
			
			btn_class = '"btn btn-default btn-requisicao"';
			if (tab_requisicao_json.TABELA_REQUISICAO[i].SITUACAO == 2)
				btn_class = '"btn btn-default btn-requisicao-aprovada"';
				
		
			argumentos_btn = "'UPDATE_REQUISICAO'," + tab_requisicao_json.TABELA_REQUISICAO[i].ID_AGENDA + ',0,' + "'" + tab_requisicao_json.TABELA_REQUISICAO[i].DATA + "'";
			if (tab_requisicao_json.TABELA_REQUISICAO[i].SITUACAO == 2)
				argumentos_btn = "'UPDATE_REQUISICAO'," + tab_requisicao_json.TABELA_REQUISICAO[i].ID_AGENDA + ',1,' + "'" + tab_requisicao_json.TABELA_REQUISICAO[i].DATA + "'";
			
			
			data = new Date(tab_requisicao_json.TABELA_REQUISICAO[i].DATA);
			data_str = '';
			if (data.getUTCDate() < 10)
				data_str = '0';
			data_str = data_str + String(data.getUTCDate()) + '/';
			if (data.getUTCMonth() + 1 < 10)
				data_str = data_str + '0';
			data_str = data_str + (data.getUTCMonth() + 1) + '/' + data.getUTCFullYear() + '</td>'
			
			
			botao = '<button type="button" class='  + btn_class + ' onclick="update_requisicao(' + argumentos_btn + ')">' + 'Aprovar' + '</button>';
			id_linha = '"linha_requisicao_' + tab_requisicao_json.TABELA_REQUISICAO[i].ID_AGENDA + '"';
			
			argumentos_btn = argumentos_btn = "'DELETE_REQUISICAO'," + tab_requisicao_json.TABELA_REQUISICAO[i].ID_AGENDA + ',0,' + "'" + tab_requisicao_json.TABELA_REQUISICAO[i].DATA + "'";
			btn_exclusao = '<button type="button" class="btn btn-default btn-exclusao" onclick="update_requisicao(' + argumentos_btn + ')">' + 'Excluir' + '</button>';

			argumentos_btn = tab_requisicao_json.TABELA_REQUISICAO[i].ID_USUARIO;
			btn_info = '<button type="button" class="btn btn-default btn-informacoes" onclick="atualiza_usuario(' + argumentos_btn + ')">' + 'Info' + '</button>';
			
			linha = linha +
				'<tr class="linha_requisicao' + class_linha + '" id=' + id_linha + '>' +
					'<td>' + data_str + '</td>' +
					'<td class="col_hora">' + tab_requisicao_json.TABELA_REQUISICAO[i].HORA + '</td>' +
					'<td class="col_nome" onclick="atualiza_usuario(' + argumentos_btn + ')">' + tab_requisicao_json.TABELA_REQUISICAO[i].NOME + '</td>' +
					'<td>' + botao + '</td>' +
					'<td>' + btn_exclusao + '</td>' +
				'</tr>';
				
			class_linha = '';
		}
		
		$("#tab_requisicoes").append(linha);

		$(".btn-requisicao").removeClass("btn-success");
		$(".btn-requisicao").addClass("btn-default");
		$(".btn-requisicao").text("Aprovar");
		
		$(".btn-requisicao-aprovada").removeClass("btn-default");
		$(".btn-requisicao-aprovada").addClass("btn-success");
		$(".btn-requisicao-aprovada").text("Confirmado");
		
		$(".col_nome").css("cursor","pointer");
		
		esconde_requisicoes();
	}
}

function update_requisicao (modo, id_agenda, cancelar,data) {
	var seletor = '#linha_requisicao_' + id_agenda;
	var comando_post = '';
	
	comando_post = 
		"MODO=" + modo +
		"&DATA_INI=" + $("#sel_data_ini").val() +
		"&DATA_FIM=" + $("#sel_data_fim").val() +
		"&DATA=" + data +
		"&HORA=" + $(seletor).find(".col_hora").text() + 
		"&ID_QUADRA=" + id_quadra +
		"&ID_AGENDA=" + id_agenda +
		"&CANCELAR=" + cancelar;
	
	if (modo == "DELETE_REQUISICAO") {
		if (!confirm("Deseja excluir esta requisição?")) {
			comando_post = '';
		}
	}

	if (comando_post != '') {
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {

				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				/*	
				if (modo == 'UPDATE_REQUISICAO') {
					if (confirm("Deseja enviar e-mail de aviso de confirmação?")) {
						envia_email(id_agenda);
					}
				}
				*/
				atualiza_tab_requisicao_json();
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
}

function atualiza_tabela_evento() {
	var i;
	var linha;
	var botao;
	var data_ini;
	var data_ini_str;
	var data_fim;
	var data_fim_str;

	$("#tab_evento").empty();
	
	linha = '';
	if (tab_evento_json != null) {
		for (i = 0; i < tab_evento_json.TABELA_EVENTO.length; i++) {
		
			argumentos_btn = "'DELETE_EVENTO'," + tab_evento_json.TABELA_EVENTO[i].ID_AGENDA;
			botao = '<button type="button" class="btn btn-default" onclick="cadastrar_evento(' + argumentos_btn + ')">' + 'X' + '</button>';
			
			data_ini = new Date(tab_evento_json.TABELA_EVENTO[i].DATA);
			data_ini_str = '';
			if (data_ini.getUTCDate() < 10)
				data_ini_str = '0';
			data_ini_str = data_ini_str + String(data_ini.getUTCDate()) + '/';
			if (data_ini.getUTCMonth() + 1 < 10)
				data_ini_str = data_ini_str + '0';
			data_ini_str = data_ini_str + (data_ini.getUTCMonth() + 1) + '/' + data_ini.getUTCFullYear() + '</td>'
			
			data_fim = new Date(tab_evento_json.TABELA_EVENTO[i].DATA_FIM);
			data_fim_str = '';
			if (data_fim.getUTCDate() < 10)
				data_fim_str = '0';
			data_fim_str = data_fim_str + String(data_fim.getUTCDate()) + '/';
			if (data_fim.getUTCMonth() + 1 < 10)
				data_fim_str = data_fim_str + '0';
			data_fim_str = data_fim_str + (data_fim.getUTCMonth() + 1) + '/' + data_fim.getUTCFullYear() + '</td>'
					
			linha = linha +
				'<tr>' +
					'<td>' + tab_evento_json.TABELA_EVENTO[i].TITULO + '</td>' +
					'<td>' + data_ini_str + '</td>' +
					'<td>' + tab_evento_json.TABELA_EVENTO[i].HORA + '</td>' +
					'<td>' + data_fim_str + '</td>' +
					'<td>' + tab_evento_json.TABELA_EVENTO[i].HORA_FIM + '</td>' +
					'<td>' + botao + '</td>' +
				'</tr>';
		}
		
		$("#tab_evento").append(linha);
	}
}

function atualiza_tab_quadra_json() {
	var comando_post = "MODO=ATUALIZAR_QUADRA&ID_PERFIL=" + id_perfil;

	$.post("php/cad_horario.php",comando_post,function(resposta,status){		
		if (status == "success") {
			if (resposta.substr(0,4) == "Erro")
				alert(resposta);
			else {
				if (resposta != '') {
					tab_quadra_json = JSON.parse(resposta);
				}
				else {
					tab_quadra_json = null;
				}
				
				atualiza_tabela_quadra();
				
				atualiza_tab_sel_quadra();
				seleciona_quadra(id_quadra);
			}
		}
		else {
			alert("Falha na requisição!");
		}
	});
}

function atualiza_usuario (id_usuario) {
	var comando_post = "MODO=ATUALIZAR_USUARIO&ID_USUARIO=" + id_usuario;

	$.post("php/cad_usuario.php",comando_post,function(resposta,status){		
		if (status == "success") {
			if (resposta.substr(0,4) == "Erro")
				alert(resposta);
			else {
				if (resposta != '') {
					tab_usuario_json = JSON.parse(resposta);
				}
				else {
					tab_usuario_json = null;
				}
				
				atualiza_usuario_modal();
			}
		}
		else {
			alert("Falha na requisição!");
		}
	});
}

function atualiza_usuario_modal() {
	var conteudo_info;
	var linha_usuario;
	var bloco_ini;
	var bloco_fim;
	var seletor = "#conteudo_modal";
	
	$(seletor).empty();
	if (tab_usuario_json != null) {
		bloco_ini = '<div class="row"><div class="col-lg-12">';
		bloco_fim = '</div></div>'
		
		conteudo_info = bloco_ini + '<h4 class="text-center">' + tab_usuario_json.TABELA_USUARIO[0].NOME + '</h4>' + bloco_fim;
		
		
		conteudo_info = conteudo_info + bloco_ini;
		
		if (tab_usuario_json.TABELA_USUARIO[0].ENDERECO.trim() != '') {
			conteudo_info = conteudo_info + "<strong>Endereço: </strong>" + tab_usuario_json.TABELA_USUARIO[0].ENDERECO;
			
			if (tab_usuario_json.TABELA_USUARIO[0].NUMERO.trim() != '')
				conteudo_info = conteudo_info + ', ' + tab_usuario_json.TABELA_USUARIO[0].NUMERO;
				
			conteudo_info = conteudo_info + '<br>';
		}
			
		if (tab_usuario_json.TABELA_USUARIO[0].EMAIL.trim() != '')
			conteudo_info = conteudo_info + "<strong>E-Mail: </strong>" + tab_usuario_json.TABELA_USUARIO[0].EMAIL + '<br>';
		
		if (tab_usuario_json.TABELA_USUARIO[0].TELEFONE1.trim() != '') {
			conteudo_info = conteudo_info + "<strong>Telefone1: </strong>" + tab_usuario_json.TABELA_USUARIO[0].TELEFONE1;
			
			if (tab_usuario_json.TABELA_USUARIO[0].TELEFONE2.trim() != '')
				conteudo_info = conteudo_info + ', <strong>Telefone2: </strong>' + tab_usuario_json.TABELA_USUARIO[0].TELEFONE2;
				
			conteudo_info = conteudo_info + '<br>';
		}

		if (tab_usuario_json.TABELA_USUARIO[0].CELULAR1.trim() != '') {
			conteudo_info = conteudo_info + "<strong>Celular1: </strong>" + tab_usuario_json.TABELA_USUARIO[0].CELULAR1;
			
			if (tab_usuario_json.TABELA_USUARIO[0].CELULAR2.trim() != '')
				conteudo_info = conteudo_info + ', <strong>Celular2: </strong>' + tab_usuario_json.TABELA_USUARIO[0].CELULAR2;
				
			conteudo_info = conteudo_info + '<br>';
		}
		
		if (tab_usuario_json.TABELA_USUARIO[0].LINK_SITE.trim() != '')
			conteudo_info = conteudo_info + '<strong>Site: </strong><a target="_blank" href="http://' + tab_usuario_json.TABELA_USUARIO[0].LINK_SITE + '">' + 'Clique aqui para acessar' + '</a>' + '<br>';

		if (tab_usuario_json.TABELA_USUARIO[0].LINK_FACEBOOK.trim() != '')
			conteudo_info = conteudo_info + '<strong>Facebook: </strong><a target="_blank" href="https://' + tab_usuario_json.TABELA_USUARIO[0].LINK_FACEBOOK + '">' + 'Clique aqui para acessar' + '</a>';
		
		conteudo_info = conteudo_info + bloco_fim;
		
		
		
		
		linha_usuario = conteudo_info;
		
		$(seletor).append(linha_usuario);
		
		
		$("#myModal").modal('show');
	}
}

function atualiza_tabela_quadra() {
	var i;
	var linha;
	var botao;
	var argumentos_btn;

	$("#tab_quadra").empty();
	
	linha = '';
	if (tab_quadra_json != null) {
		for (i = 0; i < tab_quadra_json.TABELA_QUADRA.length; i++) {
		
			argumentos_btn = "'DELETE_QUADRA'," + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA;
			botao = '<button type="button" class="btn btn-default" onclick="cadastrar_quadra(' + argumentos_btn + ')">' + 'Excluir' + '</button>';
			
			linha = linha +
				'<tr>' +
					'<td>' + tab_quadra_json.TABELA_QUADRA[i].DESCRICAO + '</td>' +
					'<td>' + botao + '</td>' +
				'</tr>';
		}
		
		$("#tab_quadra").append(linha);
	}
}

function valida_campos_quadra() {
	if ($("#nome_estabelecimento_add").val().trim() == '')
		return "Nome do estabelecimento deve ser preenchido.";
	
	return '';
}

function cadastrar_quadra(modo, id_quadra_cad) {
	var excluir;
	var comando_post = '';
	
	if (modo == 'INSERT_QUADRA') {
		if (valida_campos_quadra() == '') {
			comando_post = $("#estabelecimentos_form").serialize() +
				"&MODO=" + modo +
				"&ID_PERFIL=" + id_perfil;				
		}
		else {
			alert(valida_campos_quadra());
		}
	}
		
	if (modo == 'DELETE_QUADRA') {
		excluir = confirm("Atenção! Excluir um estabelecimento automaticamente exclui todos os registros associados a ele. Deseja continuar?")
		if (excluir)
			comando_post = 
				"MODO=" + modo +
				"&ID_QUADRA=" + id_quadra_cad;
	}
	
	if (comando_post != '') {
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
					
				if (modo == 'INSERT_QUADRA')
					id_quadra = resposta;
				else if (id_quadra_cad == id_quadra)
					id_quadra = 0;
				
				atualiza_tab_quadra_json();
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
}

function atualiza_tab_sel_quadra() {
	var i;
	var linha;
	var funcao_click;
	var id_linha;

	$("#tab_sel_quadra").empty();
	
	linha = '';
	if (tab_quadra_json != null) {
		for (i = 0; i < tab_quadra_json.TABELA_QUADRA.length; i++) {
		
			funcao_click = '"seleciona_quadra(' + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA + ')"';
			id_linha = '"linha_quadra_' + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA + '"';
		
			linha = linha +
				'<tr class="linha_quadra" onclick=' + funcao_click + ' id=' + id_linha + '>' +
					'<td>' + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA + '</td>' +
					'<td>' + tab_quadra_json.TABELA_QUADRA[i].DESCRICAO + '</td>' +
				'</tr>';
		}
		
		$("#tab_sel_quadra").append(linha);
		
		$(".linha_quadra").css("cursor","pointer");
	}
}

function update_estab (modo) {
	var comando_post = "MODO=" + modo + "&ID_QUADRA=" + id_quadra + "&";
	
	if (modo == 'UPDATE_INFO_ESTAB')
		comando_post = comando_post	+ $("#info_quadra_form").serialize();
		
	if (modo == 'UPDATE_ENDERECO_ESTAB')
		comando_post = comando_post	+ $("#endereco_quadra_form").serialize();
		
	if (modo == 'UPDATE_CONTATO_ESTAB')
		comando_post = comando_post	+ $("#contato_quadra_form").serialize();

	if (comando_post != '' && id_quadra > 0) {
		$.post("php/cad_horario.php",comando_post,function(resposta,status){		
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				
				atualiza_tab_quadra_json();
				alert("Dados atualizados.");
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
}

function atualiza_campos_quadra() {
	var pos_quadra;

	if (id_quadra > 0 && tab_quadra_json != null) {
		for (pos_quadra = 0; pos_quadra < tab_quadra_json.TABELA_QUADRA.length; pos_quadra++) {
			if (tab_quadra_json.TABELA_QUADRA[pos_quadra].ID_QUADRA == id_quadra)
				break;
		}
		
		$("#nome_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].DESCRICAO);
		$("#preco_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].PRECO_HORA);
		$("#tamanho_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].TAMANHO);
		$("#tipo_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].ID_TIPO_QUADRA);
		
		$("#endereco_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].ENDERECO);
		$("#bairro_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].BAIRRO);
		$("#numero_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].NUMERO);
		$("#cidade_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].ID_CIDADE);
		
		$("#email_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].EMAIL);
		$("#telefone1_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].TELEFONE1);
		$("#telefone2_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].TELEFONE2);
		$("#celular1_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].CELULAR1);
		$("#celular2_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].CELULAR2);
		$("#site_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].LINK_SITE);
		$("#facebook_estabelecimento").val(tab_quadra_json.TABELA_QUADRA[pos_quadra].LINK_FACEBOOK);
		
	}
}

function seleciona_quadra(id) {
	var comando_post;
	var seletor = '#linha_quadra_' + id;
	
	if (id > 0) {
		$(".linha_quadra").attr("style","");
		$(".linha_quadra").css("cursor","pointer");
		$(seletor).css({"background-color":"#5cb85c","color":"#fff"});
	}
	else {
		$(".linha_quadra").attr("style","");
		$(".linha_quadra").css("cursor","pointer");
	}
	
	id_quadra = id;
	$("#head_quadra_selecionada").text("Quadra: " + $(seletor).children().next().text());
	atualiza_campos_quadra();

	atualiza_tab_horario_json();
	atualiza_tab_evento_json();
	atualiza_tab_requisicao_json();
	
	if (id_quadra > 0) {
		comando_post = 'ID_QUADRA=' + id_quadra + '&NOME_QUADRA=' + $(seletor).children().next().text();
		$.post("php/set_cookie.php",comando_post,function(resposta,status){});
	}
}

function esconde_requisicoes() {
	if ($("#check_fila").is(":checked")) {
		$(".linha_requisicao").not(".primeiro_fila").hide();
	}
	else {
		$(".linha_requisicao").not(".primeiro_fila").show();
	}
}

function envia_email(id_agenda_destino) {
	var comando_post = "ID_AGENDA=" + id_agenda_destino;
	
	if (comando_post != '' && id_agenda_destino > 0) {
		$.post("php/email.php",comando_post,function(resposta,status){		
			if (status == "success") {
				alert(resposta);
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}

}

function consulta_automatica () {
	var i,j;
	var posicao_array;
	var nova_consulta = false;
	var comando_post = "ID_QUADRA=" + id_quadra + "&SITUACAO=0";
	
	if (id_quadra > 0) {
		$.post("php/consulta_evento.php", comando_post, function(resposta, status){
			if (status == "success") {
				if (resposta != 0) {
					
					array_consulta = eval(resposta);
					
					if (array_consulta.length != 0 && tab_requisicao_json == null) {
						nova_consulta = true;
					} else					
					if (tab_requisicao_json.TABELA_REQUISICAO.length != array_consulta.length) {
						nova_consulta = true;
					}
					
					if (!nova_consulta) {
						for (i = 0; i < tab_requisicao_json.TABELA_REQUISICAO.length ; i++) {
							for (j = 0; j < array_consulta.length ; j++) {
								if (array_consulta[j][0] == tab_requisicao_json.TABELA_REQUISICAO[i].ID_AGENDA && array_consulta[j][1] == tab_requisicao_json.TABELA_REQUISICAO[i].SITUACAO) {
									array_consulta.splice(j,1);
									break;
								}
							}
						}
						if (array_consulta.length > 0) {
							nova_consulta = true;
						}
					}
					
					if (nova_consulta) {
						atualiza_tab_requisicao_json();
					}
				} else {
					if (tab_requisicao_json != null)
						atualiza_tab_requisicao_json();
				}
			}
		});
	}
}

$(document).ready(function(){
	$("#principal").slideDown("slow");
	
	$("#btn_adicionar").click(function(){
		cadastrar_horario('INSERT',0,0);
	});
	
	$("#btn_add_evento").click(function(){
		cadastrar_evento("INSERT_EVENTO",0);
	});
	
	$("#btn_add_estab").click(function(){
		cadastrar_quadra("INSERT_QUADRA",0);
	});
		
	$("#btn_update_info_estab").click(function(){
		update_estab('UPDATE_INFO_ESTAB');
	});
	
	$("#btn_update_endereco_estab").click(function(){
		update_estab('UPDATE_ENDERECO_ESTAB');
	});
	
	$("#btn_update_contato_estab").click(function(){
		update_estab('UPDATE_CONTATO_ESTAB');
	});
	
	$("#sel_data_ini").change(function(){
		atualiza_tab_requisicao_json();
	});
	
	$("#sel_data_fim").change(function(){
		atualiza_tab_requisicao_json();
	});
	
	$("#check_fila").change(function(){
		esconde_requisicoes();
	});

	preenche_hora();
	
	data = new Date;
	$("#sel_data_ini").val((data.toISOString()).split("T")[0]);
	$("#sel_data_fim").val((data.toISOString()).split("T")[0]);
	$("#data_inicial").val((data.toISOString()).split("T")[0] + "T00:00:00");
	$("#data_final").val((data.toISOString()).split("T")[0] + "T23:59:00");
	
	atualiza_tab_horario_json();
	atualiza_tab_evento_json();
	atualiza_tab_quadra_json();
	atualiza_tab_requisicao_json();
	
	setInterval(consulta_automatica, 3000);
	
});