<?php
//A tabela de contatos esta inserida dentro do visualizar_contatos.php e exibe a lista de contatos cadastrados pelo usuario
// da agenda a acessar este script.
//O script busca no banco de dados todos os contatos onde o "dono" (campo da tabela onde é guardado o código do usuario) é igual
// ao código de usuario guardado no cookie.

$PERMISSAO_DE_ACESSO = "professor/aluno";
require("includes/permissoes.php");

require("includes/conectar_mysql.php");
$query = "SELECT cd, nome, email, obs FROM contatos WHERE dono=" . $_COOKIE["cd_usuario_agenda"];
$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
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
    <td colspan="3"> <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Lista de Contatos</strong></font></p></td>
  </tr>
  <!--<tr align="center" bgcolor="#00CCFF"> 
    <td colspan="3"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Professor.........</strong></font></td>
  </tr>-->
  <tr align="center"> 
    <td class="celula"><font color="#0099FF"><strong>Nome</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>Email</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>Obs.</strong></font></td>
  </tr>
  <?php while($contato = mysql_fetch_array($result, MYSQL_ASSOC)){ 
  	$obs = split("\r\n",chunk_split($contato["obs"],40));
  ?>
	  <tr> 
		<td class="celula"><font color="#666666"><a href="javascript: parent.location = 'form_contato.php?modo=update&cd=<?=$contato["cd"]?>'"><?=$contato["nome"]?></a></font></td>
		<td class="celula" align="center"><font color="#666666"><?=$contato["email"]?></font></td>
		<td class="celula"><font color="#666666"><?=$obs[0]?>...</font></td>
	  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php require("includes/desconectar_mysql.php"); ?>