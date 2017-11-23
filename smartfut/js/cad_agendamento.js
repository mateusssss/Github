var tab_horario_json;
var tab_quadra_json;
var agenda_json;
var horario_escolhido;
var id_usuario;
var id_perfil;
var nome_usuario;
var id_quadra;
var nome_quadra;
var id_cidade;
var evento_consulta_automatica;

function atualiza_agenda() {
	var i;
	var evento;
	var evento_obj;
	var data_ini;
	var data_fim;
	var data_string;
	var cor_evento;

	if (agenda_json != null) {
		evento = '{events: [';
	
		for (i = 0; i < agenda_json.AGENDA.length; i++) {
		
			data_string = agenda_json.AGENDA[i].DATA + "T" + agenda_json.AGENDA[i].HORA + ":00Z";
				
			data_ini = new Date(data_string);			
			
			data_string = agenda_json.AGENDA[i].DATA_FIM + "T" + agenda_json.AGENDA[i].HORA_FIM + ":00Z";
				
			data_fim = new Date(data_string);
			
			cor_evento = '';
			if (agenda_json.AGENDA[i].SITUACAO == 1) {
				cor_evento = 
					'backgroundColor:"#FF8C00"' + ',' +
					'borderColor:"#FF8C00"' + ',';
			} 
			else
			if (agenda_json.AGENDA[i].SITUACAO == 2) {
				cor_evento = 
					'backgroundColor:"#5cb85c"' + ',' +
					'borderColor:"#5cb85c"' + ',';
			}

			evento = evento + 
				'{' +
				'id:' + agenda_json.AGENDA[i].ID_AGENDA + ',' +
				'title:' + "'" + agenda_json.AGENDA[i].TITULO + "'" + ',' +
				'start:' + "new Date(" + data_ini.getUTCFullYear() + ',' + data_ini.getUTCMonth() + ',' +  data_ini.getUTCDate() + ',' + data_ini.getUTCHours() + ',' + data_ini.getUTCMinutes() + ")" + ',' +
				'end:' + "new Date(" + data_fim.getUTCFullYear() + ',' + data_fim.getUTCMonth() + ',' +  data_fim.getUTCDate() + ',' + data_fim.getUTCHours() + ',' + data_fim.getUTCMinutes() + ")" + ',' +
				cor_evento +
				'allDay: false' +
				'},';
		}
		evento = evento.substr(0,evento.length - 1) + ']}';
		evento_obj = eval(evento);
		
		$('#calendar').fullCalendar('removeEvents');
		$('#calendar').fullCalendar('addEventSource',evento_obj);
		
		$('#painel_calendario').slideDown("slow");
	}
	else {
		$('#calendar').fullCalendar('removeEvents');
		
		if (id_quadra == 0)
			$('#painel_calendario').slideUp("slow");
		else {
			$('#painel_calendario').slideDown("slow");
		}
	}
}

function deleta_evento(id_agenda) {
	var comando_post = "MODO=DELETE&ID_AGENDA=" + id_agenda + "&ID_USUARIO=" + id_usuario;

	if (confirm("Deseja cancelar esta requisição?")) {
		$.post("php/cad_agendamento.php",comando_post,function(resposta,status){
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				else {
					alert(resposta);
					consulta_agenda();
				}
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}	
}

function consulta_agenda() {
	var comando_post = "MODO=ATUALIZAR_AGENDA&ID_QUADRA=" + id_quadra;

	$.post("php/cad_agendamento.php",comando_post,function(resposta,status){
		if (status == "success") {
			if (resposta.substr(0,4) == "Erro")
				alert(resposta);
			else {
				if (resposta != '') {
					agenda_json = JSON.parse(resposta);
				}
				else {
					agenda_json = null;
				}
				
				atualiza_agenda();
			}
		}
		else {
			alert("Falha na requisição!");
		}
	});
}

function adiciona_evento() {

	if (horario_escolhido != '') {
		$.post("php/cad_agendamento.php",horario_escolhido,function(resposta,status){
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				else {
					if (resposta != '') {
						alert(resposta);
						$("#myModal").modal('hide');
						consulta_agenda();
					}
				}
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
	
	horario_escolhido = '';
}

function escolher_horario(id_btn) {
	var seletor = '#' + id_btn;
	
	if  ($(seletor).filter(".disabled").length == 0) {
		$(".btn_reserva").not(".reserva_confirmada, .reserva_recesso, .reserva_requisitada").removeClass("btn-default");
		$(".btn_reserva").not(".reserva_confirmada, .reserva_recesso, .reserva_requisitada").removeClass("disabled");
		$(".btn_reserva").not(".reserva_confirmada, .reserva_recesso, .reserva_requisitada").addClass("btn-success");
		
		$(".btn_reserva").not(".reserva_confirmada, .reserva_recesso, .reserva_requisitada").text(function() {
			$(this).text($(this).text().replace("REQUISITADO","DISPONÍVEL"));
		});
		
		$(".reserva_requisitada").removeClass("disabled");
		$(seletor).filter(".reserva_requisitada").addClass("disabled");
		
		$(seletor).removeClass("btn-success");
		$(seletor).addClass("btn-default");
		$(seletor).addClass("disabled");
		
		$(seletor).text(function(){
			$(this).text($(this).text().replace("DISPONÍVEL","REQUISITADO"));
		});
		
		horario_escolhido = $(seletor).val();
	}
}

function atualiza_modal(data) {
	var botao;
	var value_btn;	
	var classe_btn;
	var texto_btn;
	var id_btn;
	var hora_fim;
	var i;

	$("#conteudo_modal").empty();
	for (i = 0; i < tab_horario_json.TABELA_HORARIO.length; i++) {
		classe_btn = 'btn btn-block btn-success btn_reserva';
		texto_btn = 'DISPONÍVEL';
		
		if (tab_horario_json.TABELA_HORARIO[i].RECESSO != 'DISPONIVEL') {
			classe_btn = 'btn btn-block btn-default disabled btn_reserva reserva_recesso';
			texto_btn = 'BLOQUEADO - ' + tab_horario_json.TABELA_HORARIO[i].RECESSO;
		} else
		if (tab_horario_json.TABELA_HORARIO[i].CONFIRMADO != 'DISPONIVEL') {
			classe_btn = 'btn btn-block btn-default disabled btn_reserva reserva_confirmada';
			texto_btn = 'CONFIRMADO - ' + tab_horario_json.TABELA_HORARIO[i].CONFIRMADO;		
		} else
		if (tab_horario_json.TABELA_HORARIO[i].REQUISITADO != 'DISPONIVEL') {
			classe_btn = 'btn btn-block btn-default btn_reserva reserva_requisitada';
			if (tab_horario_json.TABELA_HORARIO[i].QTD_REQUISICOES == 1)
				texto_btn = tab_horario_json.TABELA_HORARIO[i].QTD_REQUISICOES + " REQUISIÇÃO";
			if (tab_horario_json.TABELA_HORARIO[i].QTD_REQUISICOES > 1)
				texto_btn = tab_horario_json.TABELA_HORARIO[i].QTD_REQUISICOES + " REQUISIÇÕES";
		}
		
		hora_fim = parseInt(tab_horario_json.TABELA_HORARIO[i].HORA.split(':')[0]) + 1;
		if (hora_fim < 10)
			hora_fim = '0' + String(hora_fim);
		hora_fim = hora_fim + ':' + tab_horario_json.TABELA_HORARIO[i].HORA.split(':')[1];
		
		value_btn = 
			'MODO=INSERT' +
			'&ID_QUADRA=' + id_quadra +
			'&ID_USUARIO=' + id_usuario + 
			'&NOME_USUARIO=' + nome_usuario +
			'&DIA_SEMANA=' + tab_horario_json.TABELA_HORARIO[i].DIA_SEMANA +
			'&HORA=' + tab_horario_json.TABELA_HORARIO[i].HORA + 
			'&DATA=' + data.format() +
			'&HORA_FIM=' + hora_fim + 
			'&DATA_FIM=' + data.format() +
			'&SITUACAO=0';

		id_btn = "btn" + i;

		botao = 
				'<button type="button" class="' + classe_btn +
				'" id="' + id_btn +
				'" value="' + value_btn + 
				'" onclick="escolher_horario(' + "'" + id_btn + "'" + ')">' + 
				tab_horario_json.TABELA_HORARIO[i].HORA + ' - ' + texto_btn +
				'</button><br>';
				
		$("#conteudo_modal").append(botao);
	}
	$("#myModal").modal();
}

function consulta_modal(data) {
	var comando_post = "MODO=ATUALIZAR_MODAL&ID_QUADRA=" + id_quadra + "&DATA=" + data.format();

	$.post("php/cad_agendamento.php",comando_post,function(resposta,status){		
		if (status == "success") {
			if (resposta.substr(0,4) == "Erro")
				alert(resposta);
			else {
				if (resposta != '') {
					tab_horario_json = JSON.parse(resposta);
					atualiza_modal(data);
				}
				else {
					tab_horario_json = null;
				}
			}
		}
		else {
			alert("Falha na requisição!");
		}
	});
}

function consulta_modal_quadra() {
	var comando_post = "MODO=ATUALIZAR_MODAL_QUADRA&ID_CIDADE=" + id_cidade;
	
	if (id_cidade > 0) {
		$.post("php/cad_agendamento.php",comando_post,function(resposta,status){		
			if (status == "success") {
				if (resposta.substr(0,4) == "Erro")
					alert(resposta);
				else {
					if (resposta != '') {
						tab_quadra_json = JSON.parse(resposta);
						atualiza_modal_quadra();
					}
					else {
						id_quadra = 0;
						tab_quadra_json = null;
						atualiza_modal_quadra();
					}
				}
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
	else {
		id_quadra = 0;
		tab_quadra_json = null;
		atualiza_modal_quadra();
	}
}

function seleciona_quadra(id) {
	var seletor = '#linha_quadra_' + id;
	var seletor_info = '.linha_quadra_info_' + id;
	
	$(".linha_quadra").attr("style","");
	$(".linha_quadra").css("cursor","pointer");
	$(seletor).css({"background-color":"#5cb85c","color":"#fff"});
	
	id_quadra = id;
	
	$(".linha_quadra_info").not(seletor_info).hide();
	$(seletor_info).show("slow");
	
	$("#titulo_calendario").text($(seletor).find("td").first().text());
	
	if (id_quadra > 0) {
		comando_post = 'ID_QUADRA=' + id_quadra + '&NOME_QUADRA=' + $(seletor).find("td").first().text();
		$.post("php/set_cookie.php",comando_post,function(resposta,status){});
	}
}

function atualiza_modal_quadra() {
	var i;
	var linha;
	var funcao_click;
	var id_linha;
	var class_linha_info;
	var conteudo_info;
	

	$("#tab_quadra").empty();
	
	linha = '';
	if (tab_quadra_json != null) {
		for (i = 0; i < tab_quadra_json.TABELA_QUADRA.length; i++) {
		
			funcao_click = '"seleciona_quadra(' + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA + ')"';
			id_linha = '"linha_quadra_' + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA + '"';
			class_linha_info = '"linha_quadra_info linha_quadra_info_' + tab_quadra_json.TABELA_QUADRA[i].ID_QUADRA + '"';
		
			/* informacoes da quadra */
			conteudo_info = '';
			if (tab_quadra_json.TABELA_QUADRA[i].ENDERECO.trim() != '') {
				conteudo_info = conteudo_info + "<strong>Endereço: </strong>" + tab_quadra_json.TABELA_QUADRA[i].ENDERECO;
				
				if (tab_quadra_json.TABELA_QUADRA[i].NUMERO.trim() != '')
					conteudo_info = conteudo_info + ', ' + tab_quadra_json.TABELA_QUADRA[i].NUMERO;
					
				conteudo_info = conteudo_info + '<br>';
			}
			
			if (tab_quadra_json.TABELA_QUADRA[i].TAMANHO.trim() != '') {
				conteudo_info = conteudo_info + "<strong>Tamanho: </strong>" + tab_quadra_json.TABELA_QUADRA[i].TAMANHO;
				
				if (tab_quadra_json.TABELA_QUADRA[i].TIPO_QUADRA.trim() != '')
					conteudo_info = conteudo_info + ', ' + "<strong>Tipo: </strong>" + tab_quadra_json.TABELA_QUADRA[i].TIPO_QUADRA;
					
				conteudo_info = conteudo_info + '<br>';
			}
				
			if (tab_quadra_json.TABELA_QUADRA[i].PRECO_HORA.trim() != '')
				conteudo_info = conteudo_info + "<strong>Preço: </strong>" + tab_quadra_json.TABELA_QUADRA[i].PRECO_HORA + '<br>';
				
			if (tab_quadra_json.TABELA_QUADRA[i].EMAIL.trim() != '')
				conteudo_info = conteudo_info + "<strong>E-Mail: </strong>" + tab_quadra_json.TABELA_QUADRA[i].EMAIL + '<br>';
			
			if (tab_quadra_json.TABELA_QUADRA[i].TELEFONE1.trim() != '') {
				conteudo_info = conteudo_info + "<strong>Telefone1: </strong>" + tab_quadra_json.TABELA_QUADRA[i].TELEFONE1;
				
				if (tab_quadra_json.TABELA_QUADRA[i].TELEFONE2.trim() != '')
					conteudo_info = conteudo_info + ', <strong>Telefone2: </strong>' + tab_quadra_json.TABELA_QUADRA[i].TELEFONE2;
					
				conteudo_info = conteudo_info + '<br>';
			}

			if (tab_quadra_json.TABELA_QUADRA[i].CELULAR1.trim() != '') {
				conteudo_info = conteudo_info + "<strong>Celular1: </strong>" + tab_quadra_json.TABELA_QUADRA[i].CELULAR1;
				
				if (tab_quadra_json.TABELA_QUADRA[i].CELULAR2.trim() != '')
					conteudo_info = conteudo_info + ', <strong>Celular2: </strong>' + tab_quadra_json.TABELA_QUADRA[i].CELULAR2;
					
				conteudo_info = conteudo_info + '<br>';
			}
			
			if (tab_quadra_json.TABELA_QUADRA[i].LINK_SITE.trim() != '')
				conteudo_info = conteudo_info + '<strong>Site: </strong><a target="_blank" href="http://' + tab_quadra_json.TABELA_QUADRA[i].LINK_SITE + '">' + 'Clique aqui para acessar' + '</a>' + '<br>';

			if (tab_quadra_json.TABELA_QUADRA[i].LINK_FACEBOOK.trim() != '')
				conteudo_info = conteudo_info + '<strong>Facebook: </strong><a target="_blank" href="https://' + tab_quadra_json.TABELA_QUADRA[i].LINK_FACEBOOK + '">' + 'Clique aqui para acessar' + '</a>';
			/*---------------------------*/
		
			linha = linha +
					'<tr class="linha_quadra" onclick=' + funcao_click + ' id=' + id_linha + '>' +
						'<td>' + tab_quadra_json.TABELA_QUADRA[i].DESCRICAO + '</td>' +
					'</tr>' + 
					'<tr class=' + class_linha_info + ' hidden>' +
						'<td>' + conteudo_info + '</td>' +
					'</tr>';
		}
		
		$("#tab_quadra").append(linha);
		
		$(".linha_quadra").css("cursor","pointer");
		
		$('#painel_calendario').slideUp("slow");
	}
}


function consulta_automatica () {
	var i,j;
	var posicao_array;
	var nova_consulta = false;
	var comando_post = "ID_QUADRA=" + id_quadra + "&SITUACAO=1";
	
	
	if (id_quadra > 0) {
		$.post("php/consulta_evento.php", comando_post, function(resposta, status){
			if (status == "success") {
				if (resposta != 0) {
					
					array_consulta = eval(resposta);
					
					if (array_consulta.length != 0 && agenda_json == null) {
						nova_consulta = true;
					} else					
					if (agenda_json.AGENDA.length != array_consulta.length) {
						nova_consulta = true;
					}
					
					if (!nova_consulta) {
						for (i = 0; i < agenda_json.AGENDA.length ; i++) {
							for (j = 0; j < array_consulta.length ; j++) {
								if (array_consulta[j][0] == agenda_json.AGENDA[i].ID_AGENDA && array_consulta[j][1] == agenda_json.AGENDA[i].SITUACAO) {
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
						consulta_agenda();
					}
				} else {
					if (agenda_json != null)
						consulta_agenda();
				}
			}
		});
	}
}


$(document).ready(function(){
	$("#painel_calendario").hide();
	
	$("#btn_confirmar").click(function(){
		adiciona_evento();	
	});
	
	$("#btn_atualizar_agenda").click(function(){
		consulta_agenda();
	});
	
	$("#titulo_calendario").click(function(){
		consulta_modal_quadra();
	});
	
	$("#myModal").on('hidden.bs.modal',function(){
		horario_escolhido = '';
    });
	
	$("#myModal_quadra").on('hidden.bs.modal',function(){
		consulta_agenda();
		if (id_quadra > 0) {
			evento_consulta_automatica = setInterval(consulta_automatica, 3000);
		}
    });
	
	$("#myModal_quadra").on('show.bs.modal',function(){
		clearInterval(evento_consulta_automatica);
    });
	
	$("#titulo_calendario").css("cursor","pointer");
	
	$(".linha_cidade").css("cursor","pointer");
	
	$(".linha_cidade").click(function(){
		$(".linha_cidade").attr("style","");
		$(".linha_cidade").css("cursor","pointer");
		$(this).css({"background-color":"#5cb85c","color":"#fff"});
		
		id_cidade = $(this).data("idcidade");
		consulta_modal_quadra();
		$("#collapseQuadraLink").click();
	});
	
	horario_escolhido = '';
	id_cidade = 0;
	$('#calendar').fullCalendar('removeEvents');
	
	if (id_quadra > 0) {
		consulta_agenda();
		$("#titulo_calendario").text(nome_quadra);
		evento_consulta_automatica = setInterval(consulta_automatica, 3000);
	}
});