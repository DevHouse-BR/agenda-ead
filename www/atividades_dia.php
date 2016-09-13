<?php
#############################################################
#	Tabela que relaciona as atividades agendadas para um	#
#	determinado dia passado como parâmetro.					#
#############################################################

$PERMISSAO_DE_ACESSO = "aluno/professor";			# Seta Permissão para o Aluno e o Professor (ambos podem acessar).
require("includes/permissoes.php");					# Chama a Include permissoes.php que executa as verificações para saber se o usuario
													# está logado no sistema e se ele é aluno ou professor.

$dia =  $HTTP_GET_VARS["dia"];								#Pega os parametros passado pela URL
$mes =  $HTTP_GET_VARS["mes"];								#(formato: atividades_dia.php?dia=00&mes=00&ano=0000)
$ano =  $HTTP_GET_VARS["ano"];

if ($dia == "") $dia = date("d");					#Caso o script seja rodado sem a passagem de paramentros via URL
if ($mes == "") $mes = date("m");					#O mesmo tira como base o dia, mes e ano atuais usando a função date().
if ($ano == "") $ano = date("Y");


switch(date("w", mktime(0,0,0,$mes,$dia,$ano))){	#O parametro "w" da função date() retorna o dia da semana na data especificada pela função mktime();
	case "0":										#Será feita uma comparação do numero retornado para dizer o dia em português.
		$dia_da_semana = "Domingo";
		break;
	case "1":
		$dia_da_semana = "Segunda-feira";
		break;
	case "2":
		$dia_da_semana = "Terça-feira";
		break;
	case "3":
		$dia_da_semana = "Quarta-feira";
		break;
	case "4":
		$dia_da_semana = "Quinta-feira";
		break;
	case "5":
		$dia_da_semana = "Sexta-feira";
		break;
	case "6":
		$dia_da_semana = "Sábado";
		break;
}
?>
<html>
	<head>
		<style type="text/css">	<!-- Chama a include de estilos padrão utilizados neste software -->
			@import url("includes/estilo.css");
			@import url("includes/calendario.css");
		</style>
		<script language="JavaScript">
			function mouse_em_cima(linha){
				linha.style.backgroundColor = "#FFCC00";	//Quando o mouse estiver passando em cima da linha da tabela (evento onMouseOver) a cor de fundo da linha mudará para esta selecionada.
			}
			function mouse_fora(linha){
				linha.style.backgroundColor = "#B7E4FB";	//Quando o mouse estiver saido de cima da linha da tabela (evento onMouseOut) a cor de fundo da linha mudará para esta selecionada.
			}
			function ver_atividade(codigo, tipo){			//Verifica o tipo da atividade selecionada e passa como parametro para o script ver_atividade.php junto com o código da mesma.
				var atividade = "";
				switch(tipo){
					case 1:
						atividade = "compromisso";
						break;
					case 2:
						atividade = "tarefa";
						break;
					case 3:
						atividade = "evento";
						break;
				}
				parent.atividade.location = "ver_atividade.php?tipo=" + atividade + "&cd=" + codigo;
			}
		</script>
	</head>
	<body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" marginwidth="0" marginheight="0" class="tabelacalendario" bgcolor="#B7E4FB">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr> 
							<td class="titulo"><?=$dia_da_semana . ", " . $dia . "/" . $mes . "/" . $ano?></td>
						</tr>
						<tr> 
							<td align="left" valign="top"><?=constroi_tabela()?><!--Chama a função de construção da tabela --></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<?php 
function constroi_tabela(){
	global $dia, $mes, $ano, $HTTP_COOKIE_VARS;		#Seta quais as variáveis devem ser lidas do escopo global.
	$linha = array();				#Cria o array linha onde serão armazenadas as informações das linhas da tabela para posteriormente utilizar uma função de ordenação de arrays para deixar as datas em ordem.
	$ocorrencias = 0;				#Contador que conta o numero de atividades para este dia.
	$tabela = 	'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
			.		'<tr>'
			.			'<td class="calendario" width="33%">Horário</td>'
			.			'<td class="calendario" width="33%">Atividade</td>'
			.			'<td class="calendario" width="33%">Tipo</td>'
			.		'</tr>';
	
	require("includes/conectar_mysql.php"); #Conecta ao banco.
	

	$query = "SELECT turma, curso FROM usuarios where cd=" . $HTTP_COOKIE_VARS["cd_usuario_agenda"]; #Consulta: Retorne o usuario onde o código = cookie
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
	$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
		
	$query = "SELECT cd, tipo, nome, inicio FROM compromissos WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND dia='" . $dia . "' AND mes='" . $mes . "' AND ano='" . $ano . "'"; #Consulta: retorne os compromissos onde turma = usuario_turma, curso = usuario_curso e data=data.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){#Executa enquanto tiver registros retornados da consulta (query).
		array_push($linha, date("H:i",$atividade["inicio"]) . "--" . "Compromisso" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--1");#insere mais um elemento no array linha.
		$ocorrencias++; #Soma mais um ao contador
	}
		
	$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND dia='" . $dia . "' AND mes='" . $mes . "' AND ano='" . $ano . "' AND opcao='todos'"; #Consulta: retorne as tarefas onde curso=usuario_curso, turma=usuario_turma, data=data e opcao="todos"
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){#Executa enquanto tiver registros retornados da consulta (query).
		array_push($linha, date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2"); #insere mais um elemento no array linha.
		$ocorrencias++; #Soma mais um ao contador
	}
		
	if($HTTP_COOKIE_VARS["tipo_usuario_agenda"] == "aluno"){ 	#Caso o usuario seja aluno
		$query = "SELECT nome_grupo FROM grupos_integrantes where cd_integrante=" . $HTTP_COOKIE_VARS["cd_usuario_agenda"]; #Consulta: Retorne o nome dos grupos da tabela grupos_integrantes onde o código do integrante = cookie
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
		while($grupo = mysql_fetch_array($result, MYSQL_ASSOC)){#Executa enquanto tiver registros retornados da consulta (query).
			$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND dia='" . $dia . "' AND mes='" . $mes . "' AND ano='" . $ano . "' AND desc_opcao='" . $grupo["nome_grupo"] . "'"; #Consulta: retorne as tarefas onde a turma=usuario_turma, curso=usuario_curso, data=data, desc_opcao=nome do grupo.
			$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
			while($atividade = mysql_fetch_array($result2, MYSQL_ASSOC)){#Executa enquanto tiver registros retornados da consulta (query).
				array_push($linha, date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2"); #insere mais um elemento no array linha.
				$ocorrencias++; #Soma mais um ao contador
			}
		}
	}
	
	$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE dia='" . $dia . "' AND mes='" . $mes . "' AND ano='" . $ano . "' AND opcao='privado' AND desc_opcao='" . $HTTP_COOKIE_VARS["cd_usuario_agenda"] . "'"; #Consulta: retorne as tarefas onde data=data, opcao="privado" e descrição da opcao="codigo usuario (cookie)"
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){#Executa enquanto tiver registros retornados da consulta (query).
		array_push($linha, date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2"); #insere mais um elemento no array linha.
		$ocorrencias++; #Soma mais um ao contador
	}
	
	$query = "SELECT cd, tipo, nome, inicio FROM eventos WHERE dia='" . $dia . "' AND mes='" . $mes . "' AND ano='" . $ano . "'"; #Consulta: Retorne os eventos onde data=data.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	#executa a query ou interrompe o script mostrando o erro.
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){#Executa enquanto tiver registros retornados da consulta (query).
		array_push($linha, date("H:i",$atividade["inicio"]) . "--" . "Evento" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--3");#insere mais um elemento no array linha.
		$ocorrencias++; #Soma mais um ao contador
	}
	
	require("includes/desconectar_mysql.php");
	
	if($ocorrencias == 0) return $tabela . '<tr><td align="center" colspan="3" style="border: solid thin #FFCC00" bgcolor="#FFCC00"><font color="#FFFFCC"><b>Não Há Atividades Para Hoje!</b></font></td></tr>';  #Caso o numero de ocorrências (atividades agendadas) seja 0 então o script retorna esta mensagem.
	else{		#senão:
		sort($linha);	#Ordena o array linha
		for ($i = 0; $i < count($linha); $i++){
			$valores = split("--", $linha[$i]);	#Monta as linhas da tabela apartir das informações gravadas no array linha usando o separador "--".
			$tabela .= '<tr class="linha" title="' . $valores[3] . '" onMouseOver="mouse_em_cima(this)" onMouseOut="mouse_fora(this)" onClick="ver_atividade(' . $valores[4] .',' . $valores[5] . ');"><td class="celula">' . $valores[0] . '</td><td class="celula">' . $valores[1] . '</td><td class="celula">' . $valores[2] . '</td></tr>';
		}	
		return $tabela; #Retorna o HTML que constroi a tabela.
	}
}
?>