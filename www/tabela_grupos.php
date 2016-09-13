<?php

# A tabela Grupos exibe a lista de todos os grupos cadastrados no sistema.
# Ela � utilizada em duas ocasi�es: Pode estar inserida dentro do visualizar_grupos.php ou
# pode ser aberta pelo formulario de agendamento de tarefas (tarefa.php) para funcionar como uma lista onde
# o usu�rio pode escolher qual grupo direcionar a tarefa.

$PERMISSAO_DE_ACESSO = "professor/aluno";
require("includes/permissoes.php");

$modo = $_GET["modo"];
$filtro = trim($_POST["filtro"]);

$turma = urldecode($_GET["turma"]);	//Decodifica��o de caracteres.
$curso = urldecode($_GET["curso"]);

require("includes/conectar_mysql.php");
$result = mysql_query("SELECT * FROM grupos" . $filtro_sql . " order by curso") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
?>
<html>
<head>
<title>Tabela Grupos</title>
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
<?php 
//Caso a tabela esteja sendo executada em modo "escolhe" (chamada pelo tarefa.php) ent�o ser� inserida no html uma fun��o em javascript
//que preenche o campo do tarefa.php com o nome do grupo escolhido.

if($_GET["modo"] == "escolhe"){ ?>
<script language="JavaScript">
	function seleciona(grupo){
		opener.document.forms[0].<?=$_GET["onde"]?>.value = grupo;
		self.close();
	}
</script>
<?php } ?>
<script language="JavaScript">
	function edita(codigo){ //Redireciona o browser para o cadastro de grupo passando o modo update e o codigo do grupo como par�metros.
		parent.location = "cadastro_grupo.php?modo=update&cd=" + codigo;
	}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
  <tr align="center" bgcolor="#00CCFF"> 
    <td colspan="7"> <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Grupos</strong></font></p></td>
  </tr>
  <tr align="center"> 
    <td class="celula"><font color="#0099FF"><strong>Nome</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>Criador</strong></font></td>
    <td class="celula"><font color="#0099FF"><strong>Elementos</strong></font></td>
	<td class="celula"><font color="#0099FF"><strong>Email</strong></font></td>
	<td class="celula"><font color="#0099FF"><strong>Curso</strong></font></td>
	<td class="celula"><font color="#0099FF"><strong>Turma</strong></font></td>
	<td class="celula"><font color="#0099FF"><strong>Professor</strong></font></td>
  </tr>
  <?php	while($grupo = mysql_fetch_array($result, MYSQL_ASSOC)){ //Para cada grupo encontrado na tabela grupos:
  			//Codigo que monta a tabela de grupos. A variavel linha guarda o c�digo em HTML de cada linha da tabela.
			$linha  =	'<tr>';
			$linha .=	'	<td class="celula"><font color="#666666">';
			if($_GET["modo"] == "escolhe") $linha .= '<a href="javascript: seleciona(\'' . $grupo["nome"] . '\');">'; //Caso o script esteja rodando em modo escolhe ent�o o nome do grupo estar� dentro da tag <a> (link) que chamar� a fun��o para preencher o nome do grupo.
			elseif($grupo["cd_criador"] == $_COOKIE["cd_usuario_agenda"]) $linha .= '<a href="javascript: edita(' . $grupo["cd"] . ');">'; //Sen�o o script faz outra verifica��o: Se o codigo do criador do grupo � igual ao c�digo do usuario que esta visualizando a tabela neste momento. Caso seja verdadeiro o nome do grupo estar� dentro da tag <a> (link) que chamar� a fun��o para editar as informa��es deste grupo.
			$linha .= $grupo["nome"]; //Insere o nome do grupo na linha.
			if(($_GET["modo"] == "escolhe") || ($grupo["cd_criador"] == $_COOKIE["cd_usuario_agenda"])) $linha .= '</a>'; //Fecha a tag <a>
			$linha .= '</font></td>';
			$linha .= 	'	<td class="celula" align="center"><font color="#666666">';
			
			//A consulta abaixo busca as informa��es de cada usuario integrante deste grupo para poder mostar o seu nome e email.
			$result2 = mysql_query("SELECT nome FROM usuarios WHERE cd=" . $grupo["cd_criador"]) or die("Erro ao acessar registros no Banco de dados: " . mysql_error()); 	
			$tmparray = mysql_fetch_array($result2, MYSQL_ASSOC);
			$nome_criador = $tmparray["nome"];
			
			$linha .= $nome_criador . '</font></td>';
			
			$nome_elementos = "";
			$email_elementos = "";
			$result2 = mysql_query("SELECT cd_integrante FROM grupos_integrantes WHERE nome_grupo='" . $grupo["nome"] . "'") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
			while($integrante = mysql_fetch_array($result2, MYSQL_ASSOC)){
				$result3 = mysql_query("SELECT nome, email FROM usuarios WHERE cd=" . $integrante["cd_integrante"]) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
				$tmparray = mysql_fetch_array($result3, MYSQL_ASSOC);
				$primeiro_nome = split(" ", $tmparray["nome"]); //Separa o nome do integrante pelos espa�os.
				$nome_elementos .= $primeiro_nome[0]  . ", ";	//S� ser� mostrado o primeiro nome dos integrantes de cada grupo.
				$email_elementos .= $tmparray["email"] . ", ";
			}
			$linha .=	'	<td class="celula"><font color="#666666">&nbsp;'. chop($nome_elementos, ", ") . '</font></td>'; //As fun��es chop() e rtrim() s�o sinonimas elas removem espa�o em branco no final de uma string. Neste caso vai remover a �ltima virgua inserida tamb�m.
			$linha .=	'	<td class="celula"><font color="#666666">&nbsp;' . rtrim($email_elementos, ", ") . '</font></td>';
			
			$linha .=	'	<td class="celula"><font color="#666666">' . $grupo["curso"] . '</font></td>';
			$linha .=	'	<td class="celula"><font color="#666666">' . $grupo["turma"] . '</font></td>';
			$linha .=	'	<td class="celula"><font color="#666666">' . $grupo["professor"] . '</font></td>';
			
			$linha .=	'</tr>';
			echo($linha);
	}
?>
</table>
</body>
</html>
<?php require("includes/desconectar_mysql.php"); ?>