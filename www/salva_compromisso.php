<?php
#	Script que executa o cadastro dos compromissos.

$TITULO_PG = "COMPROMISSO";					//Titulo da p�gina
$PERMISSAO_DE_ACESSO = "aluno/professor";	//Permiss�es
require("includes/permissoes.php");

require("includes/selects_turmas_cursos.php"); //Include para constru��o dos menus de cursos e turmas.
constroi_select_turmas("");
$modo = $HTTP_POST_VARS["modo"];

if($modo == "add"){			//Caso o modo de execu��o seja para adicionar, o script vai buscar as informa��es digitadas no formul�rio.
	$tipo = $HTTP_POST_VARS["tipo"];
	$nome = $HTTP_POST_VARS["nome"];
	$descricao = $HTTP_POST_VARS["descricao"];
	$data_dia = $HTTP_POST_VARS["data_dia"];
	$data_mes = $HTTP_POST_VARS["data_mes"];
	$data_ano = $HTTP_POST_VARS["data_ano"];
	$horario_hora = $HTTP_POST_VARS["horario_hora"];
	$horario_minuto = $HTTP_POST_VARS["horario_minuto"];
	$duracao = $HTTP_POST_VARS["duracao"];
	$curso = $HTTP_POST_VARS["curso"];
	$turma = $HTTP_POST_VARS["turma"];
	$avisar = $HTTP_POST_VARS["avisar"];
	
	
	$inicio = mktime($horario_hora, $horario_minuto, 0, $data_mes, $data_dia, $data_ano); //A fun��o mktime() calcula o timestamp para a data e hora passada.
	$fim = $inicio + (($duracao * 60) * 60);	//O fim do compromisso � calculado a partir da hora de inicio e da dura��o.
	$avisar = $inicio - ($avisar * 86400);		//A mesma logica segue para o dia para avisar do compromisso.
	
	verifica_data($inicio);
	
	require("includes/conectar_mysql.php"); //Conecta ao banco.
	//A consulta abaixo verifica se h� compromissos marcados para este intervalo de tempo.
	$result = mysql_query("SELECT COUNT(cd) FROM compromissos where curso='" . $curso . "' AND turma='" . $turma . "' AND inicio<=" . $inicio . " AND fim>=" . $inicio) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
	$tmp = mysql_fetch_row($result);
	$total = $tmp[0];
	if ($total == 0) { //Caso a contagem de compromissos no intervalo de tempo seja igual a zero ent�o o script prosseguir� com a inclus�o no banco de dados das informa��es do compromisso.
		$query = "INSERT INTO compromissos (tipo, nome, descricao, inicio, fim, dia, mes, ano, curso, turma, avisar, avisado) VALUES ('";
		$query .= $tipo . "', '";
		$query .= $nome . "', '";
		$query .= $descricao . "', '";
		$query .= $inicio . "', '";
		$query .= $fim . "', '";
		$query .= $data_dia . "', '";
		$query .= $data_mes . "', '";
		$query .= $data_ano . "', '";
		$query .= $curso . "', '";
		$query .= $turma . "', '";
		$query .= $avisar . "', 'n')";
	
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error()); //Executa a query.
		if($result) $ok = true; //Caso a execu��o seja completada com suceso a variavel ok fica igual a verdadeiro para mais tarde ser mostrada a mensagem de inclus�o com sucesso. 
		
		$query = "SELECT nome, email FROM usuarios WHERE (turma='" . $turma . "' AND curso='" . $curso . "')";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
			mail($usuario["email"], "Aviso de Compromisso: " . $tipo, "Ol�, " . $usuario["nome"] . "\n\nEm: " . date("d/m/Y, \�\s H:i \h\o\\r\a\s",$inicio) . " voc� tem " . $tipo . ": " . $nome . ".\nDescri��o: " . $descricao . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
		}
		
		require("includes/desconectar_mysql.php"); //Desconecta do banco.
	}
}


function verifica_data($data){
	$html = '<html>
				<head>
					<title>Erro ao Agendar Compromisso</title>
				</head>
				<body>
					<center><h3>S� � possivel agendar compromissos para datas futuras.</h3></center><br>
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
			if(($modo == "add") && ($ok)) echo("alert('Compromisso Agendado!');"); //Se tudo OK ent�o a mensagem � de compromisso agendado.
			if(($modo == "add") && (!$ok)) echo("alert('J� existe um compromisso agendado nesta data e hor�rio!');"); //Sen�o a mensagem � de erro.
			for ($i = 0; $i <= sizeof($selects); $i ++){  //C�digo necess�rio para os menus de turma e curso.
				echo($selects[$i] . "\n");
			}
		?>
			self.location = "compromisso.php";
		</script>
	</head>
</html>