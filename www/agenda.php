<?php
#############################################################
#	Pagina que contem os itens da agenda como: 				#
#	calendario e visualização de atividades por datas.		#
#############################################################

$TITULO_PG = "Agenda"; 							# Variavel do Titulo da Página
$PERMISSAO_DE_ACESSO = "aluno/professor";		# Seta Permissão para o Aluno e o Professor (ambos podem acessar).
require("includes/permissoes.php");				# Chama a Include permissoes.php que executa as verificações para saber se o usuario
												# está logado no sistema e se ele é aluno ou professor.
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Eletr&ocirc;nica!</title>
		<style type="text/css"><!-- Estilos CSS que alteram as cores, bordas (aparencia) do HTML -->
			@import url("includes/estilo.css");
			select {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 10px;
			}
			.nomecampo {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				font-weight: bold;
				color: #003399;
			}
		</style>
		<script language="JavaScript" src="includes/menuhorizontal.js"></script><!-- Chama o Javascript que contem as funções para o funcionamento do menu de opções do sistema -->
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0">
			<tr>
				<td align="center" valign="middle"><?php require("includes/menuhorizontal.php"); #Chama a include que insere o menu de opções do sistema.?>
					<table width="775" border="0" cellpadding="0" cellspacing="0" class="janela">
						<tr>
							<td colspan="2" align="center"><?php require("includes/barra_titulo.php"); #Chama a include que insere a Barra de título padrão de todas as janelas.?></td>
						</tr>
						<tr> 
							<td colspan="2" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr> 
										<td width="2%" height="70">&nbsp;</td>
										<td width="96%">
											<table width="100%">
												<tr>
													<td width="33%"><iframe width="100%" height="200" src="calendario.php" frameborder="0"></iframe><!-- Iframe é uma frame que pode executar outra pagina dentro deste html. Esta aponta para o calendario.--></td>
													<td width="33%"><iframe width="100%" height="310" src="atividades_dia.php" frameborder="0" id="viz" scrolling="yes"></iframe><!-- Iframe que visualiza as tabelas de atividades por dia, semana e mês. --></td>
													<td width="33%"><iframe width="100%" height="310" src="branco.html" frameborder="0" id="atividade" scrolling="no"></iframe><!-- Iframe que visualiza as informações da atividade selecionada --></td>
												</tr>
											</table>
										</td>
										<td width="2%">&nbsp;</td>
									</tr>
									<tr> 
										<td>&nbsp;</td>
										<td colspan="3">&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr> 
										<td>&nbsp;</td>
										<td colspan="3">&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table> 
				</td>
			</tr>
		</table>
	</body>
</html>