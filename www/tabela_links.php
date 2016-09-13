<?php
//A tabela de links esta inserida dentro do visualizar_links.php e exibe a lista de links cadastrados pelo usuario
// da agenda a acessar este script.
//O script busca no banco de dados todos os links onde o "dono" (campo da tabela onde é guardado o código do usuario) é igual
// ao código de usuario guardado no cookie.

$PERMISSAO_DE_ACESSO = "professor/aluno";
require("includes/permissoes.php");

require("includes/conectar_mysql.php");

$query = "SELECT COUNT(cd) FROM links WHERE dono=" . $HTTP_COOKIE_VARS["cd_usuario_agenda"];
$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
$total = mysql_fetch_row($result);

$query = "SELECT * FROM links WHERE dono=" . $HTTP_COOKIE_VARS["cd_usuario_agenda"];
$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
?>
<html>
<head>
<title>Tabela Turma</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	scrollbar-Track-Color: white;
	scrollbar-Face-Color: #99CCFF;
	scrollbar-Arrow-Color: #5555FF;
	scrollbar-3dLight-Color: white;
	scrollbar-Highlight-Color: white;
	scrollbar-Shadow-Color: white;
	scrollbar-DarkShadow-Color: white;
}
-->
</style>
<style type="text/css">
<!--
a:link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #0066FF;
	text-decoration: none;
}
a:visited {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #0066FF;
	text-decoration: none;
}
a:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #0066FF;
	text-decoration: underline;
}
a:active {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #0066FF;
	text-decoration: none;
}
.descricao {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
}
.link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FF0000;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
  <tr align="center" bgcolor="#00CCFF"> 
    <td colspan="3"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Links</strong></font></p></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <?php 
  	if ($total[0] > 0) {
		while($link = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
		  <tr><td width="20"><img src="img/seta_cal.gif" alt="Editar Link" style="cursor: hand;" onClick="parent.location='form_link.php?modo=update&cd=<?=$link["cd"]?>'"></td><td><a href="javascript: var lixo = window.open('<?=$link["link"]?>');"><?=$link["nome"]?></a></td></tr>
		  <tr><td></td><td class="descricao"><?=$link["descricao"]?></td></tr>
		  <tr><td></td><td class="link"><?=$link["link"]?></td></tr>
		  <tr><td></td><td><br></td></tr>
  <?php } 
  	}
	else { ?>
		<tr><td colspan="2" align="center" class="descricao">Nenhum Link Registrado</td></tr>
	<? } ?>
</table>
</body>
</html>
<?php require("includes/desconectar_mysql.php"); ?>