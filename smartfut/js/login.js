$(document).ready(function(){

	$("#tit_smartfut").click(function(){
		$(location).attr('href', 'index.php');
	});
	$("#tit_smartfut").css("cursor","pointer");
	
	$("#btn_login").click(function(){
		var comando_post = $("#form_login").serialize();
		
		$.post("php/login.php",comando_post,function(resposta,status){
			if (status == "success") {
				console.log("resposta: ");
				console.log(resposta);

				if (resposta.substr(0,4) == "Erro") {
					//alert(resposta);
					$("#modal_cabecalho").text("ERRO");
					$("#modal_mensagem").text(resposta);
					$("#myModal").modal('show');
				}
				else {
					//
					$(location).attr('href', 'cad_agendamento.php');
				}					
			}
			else {
				//alert("Falha na requisição!");
				$("#modal_cabecalho").text("ERRO");
				$("#modal_mensagem").text("Falha na requisição!");
				$("#myModal").modal('show');
			}
		});
	});
});