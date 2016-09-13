<?php

//Formulario de alteração de senha que envia as informações para o altera_senha.php
//Este é o formulário executado após o primeiro login de um novo usuário.
//A diferença deste para o form_senha2.php é que o outro tem menu horizontal e este não.

$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Virtual!</title>
		<style type="text/css">
			@import url("includes/estilo.css");
		</style>
		<script language="JavaScript">
			function valida_form(){
				var f = document.forms[0];
			 	if (f.nova_senha.value == f.confirmacao.value) f.submit();
				else alert("A confirmação de senha não confere.");
			}
		</script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" valign="middle">
					<table width="775" height="450" border="0" cellpadding="0" cellspacing="0" class="janela">
						<tr> 
							<td width="720" align="center" bgcolor="#3399FF" style="border-bottom-width: thin; border-bottom-style: solid; border-bottom-color: #0071E1;"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Agenda CAD</strong></font></td>
							<td bgcolor="#3399FF" style="border-bottom-width: thin; border-bottom-style: solid; border-bottom-color: #0071E1;"><input name="sair" type="button" id="sair" value="Sair" class="botao" style="width:100%" onClick="javascript: self.close();"></td>
						</tr>
						<tr> 
							<td colspan="2" align="center" valign="middle"><br><br><br><br><br></td>
						</tr>
						<tr> 
							<td colspan="2">
								<table width="100%" border="0" cellspacing="1" cellpadding="1">
								  <tr> 
									<td align="center"> 
									  <table width="39%" border="0" cellspacing="1" cellpadding="1">
										<form action="altera_senha.php" method="post" name="form1">
										  <tr align="center"> 
											<td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Digite uma nova senha:</strong></font><br> 
											  <br></td>
										  </tr>
										  <tr> 
											<td align="right" width="30%"><font size="2" face="Arial, Helvetica, sans-serif">Nova Senha:</font></td>
											<td width="70%"><input type="password" class="campotxt" name="nova_senha"></td>
										  </tr>
										  <tr> 
											<td align="right"><font size="2" face="Arial, Helvetica, sans-serif">Confirma&ccedil;&atilde;o:</font></td>
											<td><input type="password" class="campotxt" name="confirmacao"></td>
										  </tr>
										  <tr> 
											<td colspan="2" align="right"><input name="ok" type="button" id="ok" value=" OK " class="botao" onClick="javascript: valida_form();"></td>
										  </tr>
										  <?php if( $HTTP_GET_VARS["status"] == "alerta") { ?>
										  <tr> 
											<td colspan="2" align="right"><font color="#FF0000">A nova senha difere da senha confirmada!</font></td>
										  </tr>
										  <?php } ?>
										</form>
									  </table>
									</td>
								  </tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan="2" align="center" valign="middle"><br><br><br><br><br></td>
						</tr>
					</table> 
				</td>
			</tr>
		</table>
	</body>
</html>