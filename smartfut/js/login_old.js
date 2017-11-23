$(document).ready(function(){

	$("#tit_smartfut").click(function(){
		$(location).attr('href', 'index.php');
	});
	$("#tit_smartfut").css("cursor","pointer");
	
	$("#btn_login").click(function(){
		var comando_post = $("#form_login").serialize();
		
		$.post("php/index.php",comando_post,function(resposta,status){
			
			if (status == "success") {

				if (resposta.substr(0,4) == "Erro") {
					alert(resposta);
				}
				else {
					//
					$(location).attr('href', 'cad_agendamento.php');
				}					
			}
			else {
				alert("Falha na requisição!");
			}
		});
	});
});