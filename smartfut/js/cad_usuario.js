var tab_usuario_json;
var id_usuario;
var id_perfil;

function atualiza_tab_usuario_json() {
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
				atualiza_usuario();
			}
		}
		else {
			alert("Falha na requisição!");
		}
	});
}

function atualiza_usuario() {
	
	$("#senha_usuario").val('');
	
	if (tab_usuario_json != null) {
		$("#nome_usuario").val(tab_usuario_json.TABELA_USUARIO[0].NOME);
		$("#email_usuario").val(tab_usuario_json.TABELA_USUARIO[0].EMAIL);
		
		$("#endereco_usuario").val(tab_usuario_json.TABELA_USUARIO[0].ENDERECO);
		$("#bairro_usuario").val(tab_usuario_json.TABELA_USUARIO[0].BAIRRO);
		$("#numero_usuario").val(tab_usuario_json.TABELA_USUARIO[0].NUMERO);
		$("#cidade_usuario").val(tab_usuario_json.TABELA_USUARIO[0].ID_CIDADE);
		
		$("#email_usuario").val(tab_usuario_json.TABELA_USUARIO[0].EMAIL);
		$("#telefone1_usuario").val(tab_usuario_json.TABELA_USUARIO[0].TELEFONE1);
		$("#telefone2_usuario").val(tab_usuario_json.TABELA_USUARIO[0].TELEFONE2);
		$("#celular1_usuario").val(tab_usuario_json.TABELA_USUARIO[0].CELULAR1);
		$("#celular2_usuario").val(tab_usuario_json.TABELA_USUARIO[0].CELULAR2);
		$("#site_usuario").val(tab_usuario_json.TABELA_USUARIO[0].LINK_SITE);
		$("#facebook_usuario").val(tab_usuario_json.TABELA_USUARIO[0].LINK_FACEBOOK);
	}
	else {
		$("#nome_usuario").val('');
		$("#email_usuario").val('');
		
		$("#nome_usuario").val('');
		$("#email_usuario").val('');
		
		$("#endereco_usuario").val('');
		$("#bairro_usuario").val('');
		$("#numero_usuario").val('');
		$("#cidade_usuario").val('');
		
		$("#email_usuario").val('');
		$("#telefone1_usuario").val('');
		$("#telefone2_usuario").val('');
		$("#celular1_usuario").val('');
		$("#celular2_usuario").val('');
		$("#site_usuario").val('');
		$("#facebook_usuario").val('');
	}
}


function update_usuario() {
	var comando_post = 
		"MODO=UPDATE_USUARIO" + 
		"&ID_USUARIO=" + id_usuario + 
		'&' + $("#cad_usuario_form").serialize() +
		'&' + $("#cad_usuario_endereco_form").serialize() +
		'&' + $("#cad_usuario_contato_form").serialize();

	$.post("php/cad_usuario.php",comando_post,function(resposta,status){		
		if (status == "success") {
			alert(resposta);
				
			atualiza_tab_usuario_json();
		}
		else {
			alert("Falha na requisição!");
		}
	});
}

$(document).ready(function(){
	$("#principal").slideDown("slow");
	
	atualiza_tab_usuario_json();
	
	$("#btn_update_usuario").click(function(){
		update_usuario();
	});
	
	$("#btn_update_endereco_usuario").click(function(){
		update_usuario();
	});
	
	$("#btn_update_contato_usuario").click(function(){
		update_usuario();
	});
	
	$("#id_usuario_atual").val(id_usuario);
});