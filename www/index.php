<!-- Este é um formulário para colher o usuario e senha e enviar estas informações para o valida_usuario.php
O código php é para mostrar a mensagem de erro de digitação de senha.-->

<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Virtual!</title>
		<style type="text/css">
			@import url("includes/estilo.css");
		</style>
	</head>
	
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0">
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
										<td width="50%">
											<table width="50%" border="0" cellspacing="1" cellpadding="1">
												<form action="valida_usuario.php" method="post" name="form1">
												<tr align="center"> 
													<td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Identifique-se:</strong></font><br><br></td>
												</tr>
												<tr> 
													<td align="right" width="30%"><font size="2" face="Arial, Helvetica, sans-serif">E-mail:</font></td>
													<td width="70%"><input type="text" class="campotxt" name="usuario" style="width: 100%"></td>
												</tr>
												<tr> 
													<td align="right"><font size="2" face="Arial, Helvetica, sans-serif">Senha:</font></td>
													<td><input type="password" class="campotxt" name="senha" style="width: 100%"></td>
												</tr>
												<tr> 
													<td colspan="2" align="right"><input name="ok" type="submit" id="ok" value=" OK " class="botao"></td>
												</tr>
												<?php
													if( $HTTP_GET_VARS["status"] == "erro1"){
														echo('<tr><td colspan="2" align="center"><font color=#FF0000>Usuario ou Senha incorretos.</font></td></tr>');
													}
												?>
												</form>
											</table>
										</td>
										<td align="right" width="50%">
											<table width="100%" border="0" cellspacing="1" cellpadding="1">
												<tr>
													<td><font size="2" face="Arial, Helvetica, sans-serif">A 
													agenda permite enviar e/ou receber atividades (compromissos 
													/ tarefas / eventos) destinadas aos professores e alunos. 
													Fornece um servi&ccedil;o administrativo e interativo, 
													permitindo que professores e alunos possam ser lembrados 
													das atividades agendadas por e-mail.</font>
													</td>
												</tr>
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