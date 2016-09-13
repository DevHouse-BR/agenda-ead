<?php
// O script tarefa.php trata da coleta e agendamento de uma tarefa no banco de dados.


$TITULO_PG = "TAREFA";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

require("includes/conectar_mysql.php");
$query = "SELECT curso, turma FROM usuarios WHERE cd='" . $HTTP_COOKIE_VARS["cd_usuario_agenda"] . "'";
$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
$aluno = mysql_fetch_array($result, MYSQL_ASSOC);
$curso = $aluno["curso"];
$turma = $aluno["turma"];
require("includes/desconectar_mysql.php");


if($HTTP_POST_VARS["modo"] == "add"){	//Quando o script está rodando em modo de adição ao banco,
	$tipo = $HTTP_POST_VARS["tipo"];		//ele recolhe as informações digitadas previamente.
	$nome = $HTTP_POST_VARS["nome"];
	$descricao = $HTTP_POST_VARS["descricao"];
	$data_dia = $HTTP_POST_VARS["data_dia"];
	$data_mes = $HTTP_POST_VARS["data_mes"];
	$data_ano = $HTTP_POST_VARS["data_ano"];
	$avisar = $HTTP_POST_VARS["avisar"];
	$opcao = $HTTP_POST_VARS["opcoes"];
	$prioridade = $HTTP_POST_VARS["prioridade"];
	$horario_hora = $HTTP_POST_VARS["horario_hora"];
	$horario_minuto = $HTTP_POST_VARS["horario_minuto"];
	
	
	if($opcao == "em_grupo") $desc_opcao = $HTTP_POST_VARS["grupo"];	//Caso a tarefa seja para um grupo específico, o campo descrição da opção armazenará o nome do grupo.
	
	if($opcao == "privado") $desc_opcao = $HTTP_COOKIE_VARS["cd_usuario_agenda"]; //Caso a tarefa seja para apenas a pessoa que a agendou, o campo descrição da opção armazenará o código o usuário.

	$dia = mktime($horario_hora, $horario_minuto, 0, $data_mes, $data_dia, $data_ano);
	$avisar = $dia - ($avisar * 86400);

	verifica_data($dia);
		
	$query = "INSERT INTO tarefas (tipo, nome, descricao, prazo, avisar, prioridade, curso, turma, opcao, desc_opcao, dia, mes, ano, avisado) VALUES ('";
	$query .= $tipo ."','";
	$query .= $nome ."','";
	$query .= $descricao ."','";
	$query .= $dia ."','";
	$query .= $avisar ."','";
	$query .= $prioridade ."','";
	$query .= $curso ."','";
	$query .= $turma ."','";
	$query .= $opcao ."','";
	$query .= $desc_opcao ."','";
	$query .= $data_dia ."','";
	$query .= $data_mes ."','";
	$query .= $data_ano ."',";
	$query .= "'n')";

	require("includes/conectar_mysql.php");
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
		if($result) $ok = true;

		switch($opcao){
		case "todos":
			$query = "SELECT nome, email FROM usuarios WHERE (turma='" . $turma . "' AND curso='" . $curso . "')";
			$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
				mail($usuario["email"], "Aviso de Tarefa: " . $tipo, "Olá, " . $usuario["nome"] . "\n\nVocê precisa completar até: " . date("d/m/Y, \à\s H:i \h\o\\r\a\s",$dia) . " a tarefa " . $tipo . ": " . $nome . ".\nDescrição: " . $descricao . "\nPrioridade: " . $prioridade . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
			}
			break;
		case "em_grupo":
			$query = "SELECT cd_integrante FROM grupos_integrantes WHERE nome_grupo='" . $desc_opcao . "'";
			$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			while($integrante = mysql_fetch_array($result, MYSQL_ASSOC)){
				$query = "SELECT nome, email FROM usuarios WHERE cd=" . $integrante["cd_integrante"];
				$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
				while($usuario = mysql_fetch_array($result2, MYSQL_ASSOC)){
					mail($usuario["email"], "Aviso de Tarefa: " . $tipo, "Olá, " . $usuario["nome"] . "\n\nVocê precisa completar até: " . date("d/m/Y, \à\s H:i \h\o\\r\a\s",$dia) . " a tarefa " . $tipo . ": " . $nome . ".\nDescrição: " . $descricao . "\nPrioridade: " . $prioridade . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
				}
			}
			break;
		case "privado":
			mail($HTTP_COOKIE_VARS["email_usuario_agenda"], "Aviso de Tarefa: " . $tipo, "Olá, " . $HTTP_COOKIE_VARS["nome_usuario_agenda"] . "\n\nVocê precisa completar até: " . date("d/m/Y, \à\s H:i \h\o\\r\a\s",$dia) . " a tarefa " . $tipo . ": " . $nome . ".\nDescrição: " . $descricao . "\nPrioridade: " . $prioridade . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
			break;
	}
		
		
	require("includes/desconectar_mysql.php");
}

function verifica_data($data){
	$html = '<html>
				<head>
					<title>Erro ao Agendar Tarefa</title>
				</head>
				<body>
					<center><h3>Só é possivel agendar tarefas para datas futuras.</h3></center><br>
					<a href="javascript: history.back();">Voltar</a>
				</body>
			</html>';
	$hoje = mktime();
	if ($data <= $hoje){
		die($html);
	}
}

?>

<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Virtual!</title>
		<style type="text/css">
			@import url("includes/estilo.css");
			select {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 10px;
			}
			.nomecampo {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				font-weight: bold;
				color: #003399;
			}
		</style>
		<script language="JavaScript" src="includes/menuhorizontal.js"></script>
		<script language="JavaScript">
		<?php 
			if($ok) echo('alert("Tarefa Agendada!");');
		?>
			self.location = "tarefa.php";
		</script>
	</head>
</html>