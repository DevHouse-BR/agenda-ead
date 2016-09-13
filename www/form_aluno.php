<?php
#####################################################################################################################
# Esta � a segunda parte do cadastro de alunos. Este � o formulario onde s�o digitados as informa��es e tamb�m �	#
# o script que grava estas informa��es no banco de dados. Tudo isto controlado pela vari�vel $modo					#
#####################################################################################################################

$PERMISSAO_DE_ACESSO = "professor";
require("includes/permissoes.php");

$modo =  $HTTP_GET_VARS["modo"];
$executar = $HTTP_POST_VARS["executar"];
if($HTTP_GET_VARS["cd"] == "")	$cd = $HTTP_POST_VARS["cd"];
else $cd = $HTTP_GET_VARS["cd"];

$ok = false;

if($modo == "salva"){
	$nome = $HTTP_POST_VARS["nome"];
	$endereco = $HTTP_POST_VARS["endereco"];
	$tel_res = $HTTP_POST_VARS["tel_res"];
	$tel_com = $HTTP_POST_VARS["tel_com"];
	$celular = $HTTP_POST_VARS["celular"];
	$email = $HTTP_POST_VARS["email"];
	$profissao = $HTTP_POST_VARS["profissao"];
	$curso = $HTTP_POST_VARS["curso"];
	$turma = $HTTP_POST_VARS["turma"];
	$professor = $HTTP_POST_VARS["professor"];
	$senha = str_replace("=", "", base64_encode(rand(10000000, 99999999))); //A senha provis�ria � gerada a partir de um numero aleat�rio de 8 digitos(rand()) que depois � transformado em texto (base64_encode()). O str_replace() tira o sinal de "=" gerado pela fun��o base64.
	$tipo = "aluno";
	$alterar_senha = "s";
	
	if ($executar == "add")	{	//Caso seja um novo cadastro.
		$query = "INSERT INTO usuarios (nome, endereco, tel_res, tel_com, celular, email, profissao, senha, tipo, turma, curso, professor, alterar_senha) VALUES ('";
		$query .= $nome ."','";
		$query .= $endereco ."','";
		$query .= $tel_res ."','";
		$query .= $tel_com ."','";
		$query .= $celular ."','";
		$query .= $email ."','";
		$query .= $profissao ."','";
		$query .= $senha ."','";
		$query .= $tipo ."','";
		$query .= $turma ."','";
		$query .= $curso ."','";
		$query .= $professor ."','";
		$query .= $alterar_senha ."')";
	}
	if ($executar == "update"){ //Caso seja a altera��o de um cadastro existente.
		$query = "UPDATE usuarios SET ";
		$query .= "nome='" . $nome ."', ";
		$query .= "endereco='" . $endereco ."', ";
		$query .= "tel_res='" . $tel_res ."', ";
		$query .= "tel_com='" . $tel_com ."', ";
		$query .= "celular='" . $celular ."', ";
		$query .= "email='" . $email ."', ";
		$query .= "profissao='" . $profissao ."', ";
		$query .= "turma='" . $turma ."', ";
		$query .= "curso='" . $curso ."', ";
		$query .= "professor='" . $professor ."'";
		$query .= " WHERE cd='" . $HTTP_POST_VARS["cd"] . "'";
		$modo = "update";
	}
	require("includes/conectar_mysql.php");
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
		if($result) $ok = true;
	require("includes/desconectar_mysql.php");
	//Caso seja um novo aluno ser� enviado um email para este aluno usando a fun��o mail().
	if ($executar == "add") mail($email, "Informa��es Cadastrais Agenda Virtual de Curso a Dist�ncia", "Ol�, " . $nome . "\n\nVoc� foi cadastrado(a) na Agenda Virtual!\nPara acess�-la aponte seu navegador para:\n\nwww.inf.univali.br/~cristiane\n\nUsu�rio: " . $email . "\nSenha: " . $senha, "From: Agenda CAD <crisj@terra.com.br>");
}


if($modo == "update"){ //Mosta as informa��es do aluno para serem editadas
	require("includes/conectar_mysql.php");
		$query = "SELECT * FROM usuarios where cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
}

if($modo == "apagar"){ //Apaga o aluno
	require("includes/conectar_mysql.php");
		$query = "DELETE FROM usuarios where cd=" . $cd;
		$result_apagar = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$query = "DELETE FROM grupos_integrantes where cd_integrante=" . $cd;
		$result_apagar = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	require("includes/desconectar_mysql.php");
}
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
.nomecampo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #003399;
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
@import url("includes/estilo.css");
-->
</style>
<script language="JavaScript">
	function valida_form(){
		var f = form_aluno;
		if ((f.nome.value != "") && (f.endereco.value != "") && (f.tel_res.value != "") && (f.tel_com.value != "") && (f.celular.value != "") && (f.email.value != "") && (f.profissao.value != "") && (parent.form1.curso.value != "") && (parent.form1.turma.value != "") && (parent.form1.professor.value != "")){
			f.curso.value = parent.form1.curso.value;
			f.turma.value = parent.form1.turma.value;
			f.professor.value = parent.form1.professor.value;
			f.action = "form_aluno.php?modo=salva";
			f.submit();
		}
		else alert("Todos os campos devem ser preenchidos!");
	}
</script>
<?php 
if($ok){ ?>
	<script language="JavaScript">
		alert("Dados Gravados com Sucesso!");
	</script>
<? } ?>
<?php
if($modo == "update"){?>
<script language="JavaScript">
	function apagar(){
		if(confirm("Deseja apagar o aluno?")){ //A fun��o confirm() exibe uma janela com um bot�o OK e outro Cancelar e Retorna True para OK e False para Cancelar.
			location = "form_aluno.php?modo=apagar&cd=<?=$cd?>";
		}
	}
</script>
<?php }?>
<?php 
if($result_apagar){?>
<script language="JavaScript">
	alert("Aluno Apagado");
</script>
<?php }?>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
  <tr align="center" bgcolor="#00CCFF"> 
    <td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Dados do Aluno</strong></font> </td>
  </tr>
  <tr>
  	<td align="center">
		<table width="60%" border="0" cellpadding="1" cellspacing="1">
		<form name="form_aluno" action="" method="post">
        <tr> 
          <td width="20%" align="right" class="nomecampo">Nome: </td>
			<td width="60%"><input type="text" name="nome" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["nome"] . "\""); ?>></td>
		  </tr>
		  <tr> 
			
          <td align="right" class="nomecampo">Endere�o: </td>
			<td><input type="text" name="endereco" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["endereco"] . "\""); ?>></td>
		  </tr>
		  <tr> 
			
          <td align="right" class="nomecampo">Tel. Residencial: </td>
			<td><input type="text" name="tel_res" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["tel_res"] . "\""); ?>></td>
		  </tr>
		  <tr> 
			
          <td align="right" class="nomecampo">Tel. Comercial: </td>
			<td><input type="text" name="tel_com" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["tel_com"] . "\""); ?>></td>
		  </tr>
		  <tr> 
			
          <td align="right" class="nomecampo">Celular: </td>
			<td><input type="text" name="celular" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["celular"] . "\""); ?>></td>
		  </tr>
		  <tr> 
			
          <td align="right" class="nomecampo">E-mail: </td>
			<td><input type="text" name="email" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["email"] . "\""); ?>></td>
		  </tr>
		  <tr> 
          <td align="right" class="nomecampo">Profiss�o: </td>
			<td><input type="text" name="profissao" class="campotxt" <?php if($modo == "update") echo("value=\"". $usuario["profissao"] . "\""); ?>></td>
		  </tr>
		  <tr>
		  	<td></td>
			<td align="right"><?php if($modo == "update") echo('<input type="button" value="Apagar" onclick="apagar();" class="botao" style="width:25%">'); else echo('<input name="cancelar" type="reset" value="Cancelar" class="botao" style="width:25%">');?>&nbsp;<input name="incluir" type="button" value="<?php if($modo == "update") echo("Salvar"); else echo("Incluir"); ?>" class="botao" style="width:25%" onClick="valida_form();"></td>
		  </tr>
		  	<input type="hidden" name="cd" <?php if($modo == "update") echo("value=\"". $usuario["cd"] . "\""); ?>>
		  	<input type="hidden" name="curso" <?php if($modo == "update") echo("value=\"". $usuario["curso"] . "\""); ?>>
			<input type="hidden" name="professor" <?php if($modo == "update") echo("value=\"". $usuario["professor"] . "\""); ?>>
			<input type="hidden" name="turma" <?php if($modo == "update") echo("value=\"". $usuario["turma"] . "\""); ?>>
		  	<input type="hidden" name="executar" <?php if($modo == "update") echo("value=\"update\""); else echo("value=\"add\"");?>>
		  </form>
		</table>
	</td>
  </tr>
</table>
</body>
</html>
