<?php
//Praticamente idêntico ao cadastro de alunos mas no contexto de professor.

$TITULO_PG = "PROFESSOR";
$PERMISSAO_DE_ACESSO = "professor/root";
require("includes/permissoes.php");

$modo = $_GET["modo"];
$parametros = "";

if($modo == "update"){
	$parametros = "?modo=update&cd=" . $_GET["cd"];
}
if($modo == "update"){
	require("includes/conectar_mysql.php");
		$cd = $_GET["cd"];
		$query = "SELECT curso, turma, professor FROM usuarios where cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
}
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Eletr&ocirc;nica!</title>
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
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
                						<td width="92%"><br></td>
										<td width="4%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><iframe width="100%" frameborder="0" height="260" src="form_professor.php<?=$parametros?>"></iframe></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="center"><input name="ok" type="button" value=" OK " class="botao" onClick="location = 'visualizar_professores.php';"></td>
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