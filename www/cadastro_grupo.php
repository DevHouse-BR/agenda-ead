<?php
//Este cadastro esta dividido em duas partes sendo que uma roda dentro do iframe deste script.

$TITULO_PG = "GRUPOS DE TRABALHO";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

$modo =  $HTTP_GET_VARS["modo"];
$parametros = "";

if($modo == "update"){
	require("includes/conectar_mysql.php");
		$cd =  $HTTP_GET_VARS["cd"];
		$query = "SELECT curso, turma, professor FROM grupos WHERE cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$grupo = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
	$CURSO = $grupo["curso"];
}

if($modo == "update"){
	$parametros = "?modo=update&cd=" .  $HTTP_GET_VARS["cd"] . "&curso=" . urlencode($grupo["curso"]) . "&turma=" . urlencode($grupo["turma"]); //É necessário passar o nome da turma e do curso para o php que será rodado no iframe para que ele já saiba os alunos envolvidos. A função "urlencode()" altera caracteres não permitidos na url por caracteres permitidos.
}

else{
	require("includes/conectar_mysql.php");
		$cd = $HTTP_COOKIE_VARS["cd_usuario_agenda"];
		$query = "SELECT curso, turma, professor FROM usuarios WHERE cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
	if($modo == "update") $parametros = "?modo=update&cd=" .  $HTTP_GET_VARS["cd"] . "&curso=" . urlencode($grupo["curso"]) . "&turma=" . urlencode($grupo["turma"]);
	else $parametros = "?modo=add&curso=" . urlencode($usuario["curso"]) . "&turma=" . urlencode($usuario["turma"]); 

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
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0">
			<tr>
				<td align="center" valign="middle"><?php require("includes/menuhorizontal.php"); ?>
					<table width="775" border="0" cellpadding="0" cellspacing="0" class="janela">
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
												<form name="form1">
												<tr>
													<td width="50%">
														<table width="70%" border="0" cellspacing="1" cellpadding="1">
															<tr> 
																<td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
																<td width="81%"><input name="curso" type="text" value="<?php if($modo == "update") echo($grupo["curso"]); else echo($usuario["curso"]); ?>" disabled style="width: 100%"></td>
															</tr>
															<tr> 
																<td align="left"><font size="2" face="Arial, Helvetica, sans-serif">Turma:</font></td>
																<td><input name="turma" type="text" value="<?php if($modo == "update") echo($grupo["turma"]); else echo($usuario["turma"]); ?>" disabled style="width: 100%"></td>
															</tr>
														</table>
													</td>
													<td align="right" width="50%">
														<table width="70%" border="0" cellspacing="1" cellpadding="1">
															<tr> 
																<td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Professor:</font></td>
																<td width="81%"><input type="text" name="professor" <?php if($modo == "update") echo("value=\"". $grupo["professor"] . "\""); elseif ($HTTP_COOKIE_VARS["tipo_usuario_agenda"] == "professor") echo('value="' . $HTTP_COOKIE_VARS["nome_usuario_agenda"] . '"'); elseif ($HTTP_COOKIE_VARS["tipo_usuario_agenda"] == "aluno") echo('value="' . $usuario["professor"] . '"'); ?>disabled style="width: 90%"></td>
															</tr>
														</table>
													</td>
												</tr>
												</form>
											</table>
										<br>
										</td>
										<td width="4%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><iframe width="100%" id="viz" frameborder="0" height="250" src="form_grupo.php<?=$parametros?>"></iframe></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="center"><input name="ok" type="button" value=" OK " class="botao" onClick="location = 'visualizar_grupos.php';"></td>
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