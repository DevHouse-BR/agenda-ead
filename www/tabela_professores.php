<?php
//A tabela de professores tem praticamente o mesmo código da tabela de alunos.
//Só que lista somente os professores e não filtra por curso ou turma.


$PERMISSAO_DE_ACESSO = "professor";
require("includes/permissoes.php");

$modo = $_GET["modo"];

if ($modo == "apagar"){
	require("includes/conectar_mysql.php");
	reset ($_POST); 
	while (list($chave, $valor) = each ($_POST)) {
		if (($chave != "allbox") && ($chave != "1") && ($valor == "on")){
			$query = "DELETE FROM usuarios WHERE (cd='" . $chave . "') LIMIT 1";
			$result = mysql_query($query) or die("Erro ao remover registros do Banco de dados: " . mysql_error());	
		}
	}
}
require("includes/conectar_mysql.php");

$result = mysql_query("SELECT cd, nome, email FROM usuarios WHERE tipo='professor' ORDER BY nome") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
?>
<html>
<head>
<title>Tabela Turma</title>
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
    <td colspan="3"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Professores</strong></font></td>
  </tr>
  <tr align="center"> 
    <td class="celula"><font color="#0099FF"><strong>Nome</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>Email</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>Obs.</strong></font></td>
  </tr>
  <?php while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
	  <tr> 
		<td class="celula"><font color="#666666"><a href="javascript: parent.location = 'cadastro_professores.php?modo=update&cd=<?=$usuario["cd"]?>'"><?=$usuario["nome"]?></a></font></td>
		<td class="celula" align="center"><font color="#666666"><?=$usuario["email"]?></font></td>
		<td class="celula"><font color="#666666">Notas fdlsa jfdlska</font></td>
	  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php require("includes/desconectar_mysql.php");