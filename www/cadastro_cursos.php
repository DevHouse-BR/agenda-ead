<?php
#############################################################################
# Este é um script bem simples que gravará novos cursos na tabela cursos.	#
# No html gerado por este script esta contido o iFrame que contém a tabela	#
# de visualização dos cursos criados por este script.						#
#############################################################################

$TITULO_PG = "GERENCIAMENTO DE CURSOS"; //Título da Página
$PERMISSAO_DE_ACESSO = "professor";		//Permissões
require("includes/permissoes.php");

$modo = $HTTP_POST_VARS["modo"];	//Verifica o modo de execução do script que foi enviado via metodo POST pelo formulario abaixo.

if($modo == "add"){		//Caso o modo seja "add" (adicionar) o código abaixo insere mais um registro no banco de dados com o nome digitado na caixa de texto.
	require("includes/conectar_mysql.php");
		$query = "INSERT INTO cursos (curso) VALUES ('";
		$query .= $HTTP_POST_VARS["curso"] ."')";
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
	require("includes/desconectar_mysql.php");
}
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Virtual!</title>
		<style type="text/css">
			@import url("includes/estilo.css");
			input {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				border: 1px solid #666666;
			}
		</style>
		<script language="JavaScript" src="includes/menuhorizontal.js"></script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="novocurso.curso.focus();"><!-- Esta pagina ao ser carregada ela seta o foco do cursor para o campo de texto curso -->
		<table width="100%" border="0">
			<tr>
				<td align="center" valign="middle"><?php require("includes/menuhorizontal.php"); ?>
					<table width="775" height="383" border="0" cellpadding="0" cellspacing="0" class="janela">
					<tr>
							<td colspan="2" align="center"><?php require("includes/barra_titulo.php"); ?></td>
						</tr>
						<tr> 
							<td colspan="2" valign="middle">
								<table width="100%" border="0" cellspacing="1" cellpadding="1">
									<tr>
										<td width="4%">&nbsp;</td>
										<td width="92%">
											<table width="100%" border="0" cellspacing="1" cellpadding="1">
												<tr>
													<td align="center">
														<table width="50%" border="0" cellspacing="1" cellpadding="1">
															<form action="cadastro_cursos.php" method="post" name="novocurso">
															<input type="hidden" name="modo" value="add">
														  <tr> 
															<td width="15%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
															<td width="60%"><input type="text" name="curso" style="width: 100%" onKeyDown="if ((event.keyCode >= 48) && (event.keyCode <= 57)) return false;"></td>
															<td width="20%"><input type="submit" value="Adicionar" class="botao"></td>
														  </tr>
														  </form>
														</table>
													</td>
                      								<td align="right">&nbsp;</td>
												</tr>
											</table>
										<br>
										</td>
										<td width="4%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><iframe width="100%" frameborder="0" height="260" src="tabela_cursos.php"></iframe></td><!-- Iframe que executa a tabela de cursos -->
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