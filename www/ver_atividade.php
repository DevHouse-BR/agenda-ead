<?php
//O script ver_atividade.php é executado dentro do script agenda.php.
//Ele exibe os informações de uma determinada atividade que foi passada por parâmetro através das tabelas
//de atividades por dia, semana ou mês.

$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

$tipo =  $HTTP_GET_VARS["tipo"];	//Recebe pela URL os parâmetros necessários para a execução.
$cd =  $HTTP_GET_VARS["cd"];

//Elas montam o código HTML para exibir todas as informações gravadas no banco de dados de acordo
// com o tipo da atividade selecionada.

function coleta_informacoes_compromisso(){
	global $cd;

	require("includes/conectar_mysql.php");
	$query = "SELECT * FROM compromissos WHERE cd=" . $cd;
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$compromisso = mysql_fetch_array($result, MYSQL_ASSOC);
	
	$info_form 	= 	'<table width="100%" border="0" cellspacing="1" cellpadding="1">'
				.		'<tr>'
                .	     	'<td width="31%" align="right" class="interior">Tipo:</td>'
				.			'<td width="69%" class="interior"><input type="text" name="tipo" class="campotxt" value="' . $compromisso["tipo"] . '"></td>'
                .		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Nome:</td>'
				.			'<td class="interior"><input type="text" name="nome" class="campotxt" value="' . $compromisso["nome"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Descri&ccedil;&atilde;o:</td>'
				.			'<td class="interior"><textarea name="descricao" rows="2" class="campotxt" id="descricao">' . $compromisso["descricao"] . '</textarea></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Data:</td>'
				.			'<td class="interior"><input type="text" name="data" class="campotxt" value="' . date("d/m/Y", $compromisso["inicio"]) . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Hor&aacute;rio:</td>'
				.			'<td class="interior"><input type="text" name="horario" class="campotxt" value="' . date("H:i \h", $compromisso["inicio"]) . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Dura&ccedil;&atilde;o:</td>'
				.			'<td class="interior"><input type="text" name="duracao" class="campotxt" value="' . ((((int) $compromisso["fim"] - (int) $compromisso["inicio"])/60)/60) . ' horas"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Curso:</td>'
				.			'<td class="interior"><input type="text" name="curso" class="campotxt" value="' . $compromisso["curso"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Turma:</td>'
				.			'<td class="interior"><input type="text" name="turma" class="campotxt" value="' . $compromisso["turma"] . '"></td>'
                .		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">&nbsp;Avisar com</td>'
				.			'<td class="interior"><input type="text" name="avisar" class="campotxt" value="' . (((($compromisso["inicio"] - $compromisso["avisar"])/60)/60)/24) . ' dias de anteced&ecirc;ncia."></td>'
				.		'</tr>'
				.	'</table>';
	require("includes/desconectar_mysql.php");
	return $info_form;
}

function coleta_informacoes_evento(){
	global $cd;

	require("includes/conectar_mysql.php");
	$query = "SELECT * FROM eventos WHERE cd=" . $cd;
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$evento = mysql_fetch_array($result, MYSQL_ASSOC);
	
	if($evento["wap"] == "s") $wap = "checked";
	else $wap = "";
	
	if($evento["email"] == "s") $email = "checked";
	else $email = "";
	
	$info_form 	= 	'<table width="100%" border="0" cellspacing="1" cellpadding="1">'
				.		'<tr>'
                .	     	'<td width="31%" align="right" class="interior">Tipo:</td>'
				.			'<td width="69%" class="interior"><input type="text" name="tipo" class="campotxt" value="' . $evento["tipo"] . '"></td>'
                .		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Nome:</td>'
				.			'<td class="interior"><input type="text" name="nome" class="campotxt" value="' . $evento["nome"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Descri&ccedil;&atilde;o:</td>'
				.			'<td class="interior"><textarea name="descricao" rows="2" class="campotxt" id="descricao">' . $evento["descricao"] . '</textarea></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Local:</td>'
				.			'<td class="interior"><input type="text" name="local" class="campotxt" value="' . $evento["local"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Data:</td>'
				.			'<td class="interior"><input type="text" name="data" class="campotxt" value="' . date("d/m/Y", $evento["inicio"]) . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Hor&aacute;rio:</td>'
				.			'<td class="interior"><input type="text" name="horario" class="campotxt" value="' . date("H:i \h", $evento["inicio"]) . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Dura&ccedil;&atilde;o:</td>'
				.			'<td class="interior"><input type="text" name="duracao" class="campotxt" value="' . ((((int) $evento["fim"] - (int) $evento["inicio"])/60)/60) . ' horas"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">&nbsp;Avisar com</td>'
				.			'<td class="interior"><input type="text" name="avisar" class="campotxt" value="' . (((($evento["inicio"] - $evento["avisar"])/60)/60)/24) . ' dias de anteced&ecirc;ncia."></td>'
				.		'</tr>'
				.	'</table>';
	require("includes/desconectar_mysql.php");
	return $info_form;
}

function coleta_informacoes_tarefa(){
	global $cd;

	require("includes/conectar_mysql.php");
	$query = "SELECT * FROM tarefas WHERE cd=" . $cd;
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$tarefa = mysql_fetch_array($result, MYSQL_ASSOC);
	
	if($tarefa["wap"] == "s") $wap = "checked";
	else $wap = "";
	
	if($tarefa["email"] == "s") $email = "checked";
	else $email = "";
	
	$info_form 	= 	'<table width="100%" border="0" cellspacing="1" cellpadding="1">'
				.		'<tr>'
                .	     	'<td width="31%" align="right" class="interior">Tipo:</td>'
				.			'<td width="69%" class="interior"><input type="text" name="tipo" class="campotxt" value="' . $tarefa["tipo"] . '"></td>'
                .		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Nome:</td>'
				.			'<td class="interior"><input type="text" name="nome" class="campotxt" value="' . $tarefa["nome"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Descri&ccedil;&atilde;o:</td>'
				.			'<td class="interior"><textarea name="descricao" rows="2" class="campotxt" id="descricao">' . $tarefa["descricao"] . '</textarea></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Prazo:</td>'
				.			'<td class="interior"><input type="text" name="prazo" class="campotxt" value="' . date("d/m/Y", $tarefa["prazo"]) . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Hor&aacute;rio:</td>'
				.			'<td class="interior"><input type="text" name="horario" class="campotxt" value="' . date("H:i \h", $tarefa["prazo"]) . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Prioridade</td>'
				.			'<td class="interior"><input type="text" name="duracao" class="campotxt" value="' . $tarefa["prioridade"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Opção:</td>'
				.			'<td class="interior"><input type="text" name="opcao" class="campotxt" value="' . $tarefa["opcao"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Curso:</td>'
				.			'<td class="interior"><input type="text" name="curso" class="campotxt" value="' . $tarefa["curso"] . '"></td>'
				.		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">Turma:</td>'
				.			'<td class="interior"><input type="text" name="turma" class="campotxt" value="' . $tarefa["turma"] . '"></td>'
                .		'</tr>'
				.		'<tr>'
				.			'<td align="right" class="interior">&nbsp;Avisar com</td>'
				.			'<td class="interior"><input type="text" name="avisar" class="campotxt" value="' . (((($tarefa["prazo"] - $tarefa["avisar"])/60)/60)/24) . ' dias de anteced&ecirc;ncia."></td>'
				.		'</tr>'
				.	'</table>';
	require("includes/desconectar_mysql.php");
	return $info_form;
}
?>
<html>
<head>
<style type="text/css">
@import url("includes/estilo.css");
@import url("includes/calendario.css");
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" marginwidth="0" marginheight="0" class="tabelacalendario" bgcolor="#B7E4FB">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr> 
				<td class="titulo"><?
					//Mostra o título da janela de acordo com o tipo da atividade.
					switch($tipo){
						case "compromisso":
							echo("Compromisso");
							break;
						case "evento":
							echo("Evento");
							break;
						case "tarefa":
							echo("Tarefa");
							break;
					}?>
				</td>
			  </tr>
			  <tr> 
				<td align="left" valign="top"><?
				//Determina que função executar de acordo com o tipo da atividade passada por parâmetro.
				  switch($tipo){
						case "compromisso":
							echo(coleta_informacoes_compromisso());
							break;
						case "evento":
							echo(coleta_informacoes_evento());
							break;
						case "tarefa":
							echo(coleta_informacoes_tarefa());
							break;
					}?>
				</td>
			  </tr>
			</table>
</td>
</tr>
</table>
</body></html>