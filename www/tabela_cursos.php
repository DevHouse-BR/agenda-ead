<?php

# A tabela de cursos est� inserida dentro do cadastro_cursos.php e exibe todos os cursos cadastrados na tabela cursos.

$PERMISSAO_DE_ACESSO = "professor";
require("includes/permissoes.php");

require("includes/conectar_mysql.php");
$result = mysql_query("SELECT curso FROM cursos order by curso") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
?>
<html>
<head>
<title>Cursos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.tabela {
	border-top: 1px solid #0099FF;
	border-right: 1px solid #0066FF;
	border-bottom: 1px solid #0066FF;
	border-left: 1px solid #0099FF;
}
.celula {
	border-top: 1px solid #999999;
	border-right: 1px none #999999;
	border-bottom: 1px none #999999;
	border-left: 1px solid #999999;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
  <tr align="center" bgcolor="#00CCFF"> 
    <td colspan="3"> <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Cursos</strong></font></p></td>
  </tr>
  <tr align="center"> 
    <td class="celula"><font color="#0099FF"><strong>Nome</strong></font></td>
  </tr>
  <?php while($curso = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
	  <tr> 
		<td align="center" class="celula"><font color="#666666"><?=$curso["curso"]?></font></td>
	  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php require("includes/desconectar_mysql.php");