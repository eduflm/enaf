function login(){
	$(document).ready(function(){
			$("#error").hide();
			$('#btnLogin').click(function(){ 	//Ao submeter formulário
				var input = $('#formLogin').serialize();
				$.ajax({			//Função AJAX
					url:"../php/login.php",			//Arquivo php
					type:"post",				//Método de envio
					data: input,	//Dados
					success: function (result){	
								if(result==1){	
									location.href='../visualizarCadastro.html'	//Redireciona
								}else{
									$("#error").show();
								}
							}
				})
				return false;	//Evita que a página seja atualizada
			})
	})
}