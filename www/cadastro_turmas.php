<?php
###############################################################################
# Script que executa o cadastro das turmas de acordo com o curso selecionado. #
###############################################################################

$TITULO_PG = "GERENCIAMENTO DE TURMAS"; //Título
$PERMISSAO_DE_ACESSO = "professor";		//Permissões
require("includes/permissoes.php");

$modo = $HTTP_POST_VARS["modo"];					//Modo de execução do script;

if($modo == "add"){						//Adiciona no banco as informações digitadas.
	require("includes/conectar_mysql.php");
		$query = "INSERT INTO turma_curso (turma, curso) VALUES ('";
		$query .= $HTTP_POST_VARS["turma"] ."', '";
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
		<script language="JavaScript">
			function valida_form(){  //Esta função é executada antes de submeter as informações do formulário para impedir a inserção de informações em branco.
				var f = novaturma;
				if ((f.curso.value != "") && (f.turma.value != "")){
					f.submit();
				}
				else alert("Preencha todos os campos!");
			}
		</script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="novaturma.turma.focus();">
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
														<table width="80%" border="0" cellspacing="1" cellpadding="1">
															<form action="cadastro_turmas.php" method="post" name="novaturma">
															<input type="hidden" name="modo" value="add">
														  <tr> 
															<td width="10%" align="right"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
															<td width="35%">
																<select name="curso" style="width: 100%">
																	<option value=""></option>
																	<?php //Constroi um select de cursos de acordo com os cursos registrados no banco de dados. Parecido com o da include que tem a mesma função.
																		require("includes/conectar_mysql.php");
																		$result = mysql_query("SELECT curso FROM cursos order by curso") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
																		while($curso = mysql_fetch_array($result, MYSQL_ASSOC)){
																			echo("<option value=\"" . $curso["curso"] . "\">" . $curso["curso"] . "</option>");
																		}
																	?>
																</select>
															</td>
															<td width="10%" align="right"><font size="2" face="Arial, Helvetica, sans-serif">Turma:</font></td>
															<td width="30%"><input type="text" name="turma" style="width: 100%"></td>
															<td width="15%"><input type="button" value="Adicionar" class="botao" onClick="valida_form();"></td>
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
										<td><iframe width="100%" frameborder="0" height="260" src="tabela_turmas.php"></iframe></td>
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