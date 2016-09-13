<?php

$TITULO_PG = "EVENTO";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

if($HTTP_POST_VARS["modo"] == "add"){
	$categoria = "evento";
	$tipo = $HTTP_POST_VARS["tipo"];
	$nome = $HTTP_POST_VARS["nome"];
	$descricao = $HTTP_POST_VARS["descricao"];
	$data_dia = $HTTP_POST_VARS["data_dia"];
	$data_mes = $HTTP_POST_VARS["data_mes"];
	$data_ano = $HTTP_POST_VARS["data_ano"];
	$horario_hora = $HTTP_POST_VARS["horario_hora"];
	$horario_minuto = $HTTP_POST_VARS["horario_minuto"];
	$duracao = $HTTP_POST_VARS["duracao"];
	$local = $HTTP_POST_VARS["local"];
	$avisar = $HTTP_POST_VARS["avisar"];
	
	$inicio = mktime($horario_hora, $horario_minuto, 0, $data_mes, $data_dia, $data_ano);
	$fim = $inicio + (($duracao * 60) * 60);
	$avisar = $inicio - ($avisar * 86400);
	
	verifica_data($inicio);
		
	$query = "INSERT INTO eventos (tipo, nome, descricao, inicio, fim, dia, mes, ano, avisar, local, avisado) VALUES ('";
	$query .= $tipo ."','";
	$query .= $nome ."','";
	$query .= $descricao ."','";
	$query .= $inicio ."','";
	$query .= $fim ."','";
	$query .= $data_dia ."','";
	$query .= $data_mes ."','";
	$query .= $data_ano ."','";
	$query .= $avisar ."','";
	$query .= $local . "', 'n')";

	require("includes/conectar_mysql.php");
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
		if($result) $ok = true;
	
		$query = "SELECT nome, email FROM usuarios";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
			mail($usuario["email"], "Aviso de Evento: " . $tipo, "Olá, " . $usuario["nome"] . "\n\nEm: " . date("d/m/Y, \à\s H:i \h\o\\r\a\s",$inicio) . " você tem " . $tipo . ": " . $nome . ".\nDescrição: " . $descricao . "\nLocal: " . $local . "\n\nObrigada,\n\nAgenda Virtual.", "From: Agenda CAD <crisj@terra.com.br>");
		}
	
	require("includes/desconectar_mysql.php");
}
function verifica_data($data){
	$html = '<html>
				<head>
					<title>Erro ao Agendar Evento</title>
				</head>
				<body>
					<center><h3>Só é possivel agendar eventos para datas futuras.</h3></center><br>
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
			<?php if($ok) echo("alert('Evento agendado!');"); ?>
			self.location = "evento.php";
		</script>
	</head>
</html>