<?php

# A tabela alunos lista todos os alunos que fazem parte de uma turma de um determinado curso.
# Esta tabela está inserida no visualizar_alunos.php.

$PERMISSAO_DE_ACESSO = "professor";		//permissões
require("includes/permissoes.php");

$modo =  $HTTP_GET_VARS["modo"];

$turma = urldecode( $HTTP_GET_VARS["turma"]); //Tanto o curso quanto a turma são passados por parametros mas precisam passar por uma função que 
$curso = urldecode( $HTTP_GET_VARS["curso"]); //modifica alguns caracteres que não são permitidos.

if (($turma != "") && ($curso != "")){ //Caso não tenha sido escolhido um curso e uma turma o script interrompe a sua execução mostrando a mensagem de erro.
	$filtro_sql = " WHERE tipo='aluno' AND curso='" . $curso . "' AND turma='" . $turma . "'";
}
else die('<html>
			<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
				<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
				  <tr align="center" bgcolor="#00CCFF"> 
					<td colspan="3"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Selecione um Curso e uma Turma</strong></font></p></td>
				  </tr>
				</table>
			</body>
		</html>');

require("includes/conectar_mysql.php");

//Caso não exista alunos cadastrados no curso e turma especificados o script interrompe a sua execução mostrando a mensagem de erro.
$result = mysql_query("SELECT COUNT(cd) FROM usuarios" . $filtro_sql) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
$tmp = mysql_fetch_row($result);
$total = $tmp[0];
if ($total == 0) die('<html>
						<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
							<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
							  <tr align="center" bgcolor="#00CCFF"> 
								<td colspan="3"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Ainda não existem alunos cadastrados nesta turma!</strong></font></p></td>
							  </tr>
							</table>
						</body>
					</html>');
//Caso existam alunos o script continuará e a consulta abaixo retornará todos os alunos do curso/turma selecionados.
$result = mysql_query("SELECT cd, nome, email FROM usuarios" . $filtro_sql . "order by nome") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
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
<script language="JavaScript">
	function edita(cd){
		parent.location = 'cadastro_alunos.php?modo=update&cd=' + cd;
	}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
  <tr align="center" bgcolor="#00CCFF"> 
    <td colspan="3"> <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Turma:&nbsp;<?=$turma?>&nbsp;&nbsp;&nbsp;&nbsp;Curso:&nbsp;<?=$curso?></strong></font></p></td>
  </tr>
  <tr align="center"> 
    <td class="celula"><font color="#0099FF"><strong>Nome</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>E-mail</strong></font></td>
    <!--<td class="celula"><font color="#0099FF"><strong>Obs.</strong></font></td>-->
  </tr>
  <?php while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
	  <tr> 
		<td class="celula"><font color="#666666"><a href="javascript: edita('<?=$usuario["cd"]?>');"><?=$usuario["nome"]?></a></font></td>
		<td class="celula" align="center"><font color="#666666"><?=$usuario["email"]?></font></td>
		<!--<td class="celula"><font color="#666666">Notas fdlsa jfdlska</font></td>-->
	  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php require("includes/desconectar_mysql.php"); ?>