<?php

//O motor � a parte principal da agenda e garante o seu funcionamento.
//O motor deve ser executado peri�dicamente no servidor (de 10 em 10 minutos ou de 30 em 30...)
//Ele pesquisa no banco de dados se existe atividades que ainda n�o foram avisadas e determina quem deve ser avisado desta atividade.

require("includes/conectar_mysql.php");
$agora = mktime();  //retorna o timestamp da hora em que o script foi executado.

$query = "SELECT * FROM compromissos WHERE avisado='n' AND avisar<=" . $agora;
$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
	avisar_compromisso($atividade); //envia todas as informa��es desta atividade colhidas do banco de dados
}

$query = "SELECT * FROM eventos WHERE avisado='n' AND avisar<=" . $agora;
$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
	avisar_evento($atividade);
}

$query = "SELECT * FROM tarefas WHERE avisado='n' AND avisar<=" . $agora;
$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
	avisar_tarefa($atividade);
}

function avisar_compromisso($atividade){
	//Determina quem deve ser avisado de acordo com as informa��es gravadas na tabela compromisso.

	$query = "SELECT nome, email FROM usuarios WHERE (turma='" . $atividade["turma"] . "' AND curso='" . $atividade["curso"] . "')";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
		mail($usuario["email"], "Aviso de Compromisso: " . $atividade["tipo"], "Ol�, " . $usuario["nome"] . "\n\nN�o se esque�a que:\n\nEm: " . date("d/m/Y, \�\s H:i \h\o\\r\a\s",$atividade["inicio"]) . " voc� tem " . $atividade["tipo"] . ": " . $atividade["nome"] . ".\nDescri��o: " . $atividade["descricao"] . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
	}
	$query = "UPDATE compromissos SET avisado='s' WHERE cd=" . $atividade["cd"]; //Ao final � gravado no banco de dados a informa��o de que esta atividade j� foi avisada.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
}

function avisar_evento($atividade){
//Determina quem deve ser avisado de acordo com as informa��es gravadas na tabela eventos (todos os alunos e professores).

	$query = "SELECT nome, email FROM usuarios";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
		mail($usuario["email"], "Aviso de Evento: " . $atividade["tipo"], "Ol�, " . $usuario["nome"] . "\n\nN�o se esque�a que:\n\nEm: " . date("d/m/Y, \�\s H:i \h\o\\r\a\s",$atividade["inicio"]) . " voc� tem " . $atividade["tipo"] . ": " . $atividade["nome"] . ".\nDescri��o: " . $atividade["descricao"] . "\nLocal: " . $atividade["local"] . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
	}
	$query = "UPDATE eventos SET avisado='s' WHERE cd=" . $atividade["cd"]; //Ao final � gravado no banco de dados a informa��o de que esta atividade j� foi avisada.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
}

function avisar_tarefa($atividade){
//Determina quem deve ser avisado de acordo com as informa��es gravadas na tabela tarefa.

	switch($atividade["opcao"]){
		case "todos":
			$query = "SELECT nome, email FROM usuarios WHERE (turma='" . $atividade["turma"] . "' AND curso='" . $atividade["curso"] . "')";
			$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
				mail($usuario["email"], "Aviso de Tarefa: " . $atividade["tipo"], "Ol�, " . $usuario["nome"] . "\n\nN�o se esque�a voc� precisa completar at�: " . date("d/m/Y, \�\s H:i \h\o\\r\a\s",$atividade["prazo"]) . " a tarefa " . $atividade["tipo"] . ": " . $atividade["nome"] . ".\nDescri��o: " . $atividade["descricao"] . "\nPrioridade: " . $atividade["prioridade"] . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
			}
			break;
		case "em_grupo":
			$query = "SELECT cd_integrante FROM grupos_integrantes WHERE nome_grupo='" . $atividade["desc_opcao"] . "'";
			$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			while($integrante = mysql_fetch_array($result, MYSQL_ASSOC)){
				$query = "SELECT nome, email FROM usuarios WHERE cd=" . $integrante["cd_integrante"];
				$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
				while($usuario = mysql_fetch_array($result2, MYSQL_ASSOC)){
					mail($usuario["email"], "Aviso de Tarefa: " . $atividade["tipo"], "Ol�, " . $usuario["nome"] . "\n\nN�o se esque�a voc� precisa completar at�: " . date("d/m/Y, \�\s H:i \h\o\\r\a\s",$atividade["inicio"]) . " a tarefa " . $atividade["tipo"] . ": " . $atividade["nome"] . ".\nDescri��o: " . $atividade["descricao"] . "\nPrioridade: " . $atividade["prioridade"] . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
				}
			}
			break;
		case "privado":
			$query = "SELECT nome, email FROM usuarios WHERE cd=" . $atividade["desc_opcao"];
			$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			mail($usuario["email"], "Aviso de Tarefa: " . $atividade["tipo"], "Ol�, " . $usuario["nome"] . "\n\nN�o se esque�a voc� precisa completar at�: " . date("d/m/Y, \�\s H:i \h\o\\r\a\s",$atividade["inicio"]) . " a tarefa " . $atividade["tipo"] . ": " . $atividade["nome"] . ".\nDescri��o: " . $atividade["descricao"] . "\nPrioridade: " . $atividade["prioridade"] . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
			break;
	}
	$query = "UPDATE eventos SET avisado='s' WHERE cd=" . $atividade["cd"]; //Ao final � gravado no banco de dados a informa��o de que esta atividade j� foi avisada.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
}
require("includes/desconectar_mysql.php");
?>