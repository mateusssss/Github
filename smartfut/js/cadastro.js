function cadastrar() {
	var form_preenchido = true;
	var comando_post = 'MODO=INSERT_INICIAL&' + $("#form_cadastro").serialize();
		
	$("#form_cadastro input").each(function(){
		if (($(this).val().trim()) == '') {
			form_preenchido = false;
		}
	});
	
	if (!form_preenchido) {
		alert("Todos os campos devem ser preenchidos");
		return;
	}
	
	if ($("#confirma").val() == $("#password").val()) {	
		$.post("php/cad_usuario.php",comando_post,function(resposta,status){		
			if (status == "success") {
				alert(resposta);
				
				if (resposta.search('sucesso') > 0)
					$(location).attr('href', 'index.php');
			}
			else {
				alert("Falha na requisição!");
			}
		});
	}
	else {
		alert("Senha confirmada não confere!");
	}
}


$(document).ready(function(){
	$("#tit_smartfut").click(function(){
		$(location).attr('href', 'index.php');
	});
	$("#tit_smartfut").css("cursor","pointer");
	
	$("#btn_registrar").click(function(){
		cadastrar();
	});
	
});