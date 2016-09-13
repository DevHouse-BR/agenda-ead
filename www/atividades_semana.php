<?php
#############################################################
#	Tabela que relaciona as atividades agendadas para um	#
#	determinado intervalo de tempo passado como parâmetro.	#
#############################################################

// Neste script não são usados mais as informações dia, mês e ano e sim um
//intervalo de tempo medido em numeros de segundos desde 31/12/169 chamado timestamp.
//Este intervalo também é gravado no banco de dados junto com o dia, mês e ano.
//Usaremos este recurso para ser mais fácil a busca no banco em intervalos de numeros inteiros(timestamp)

$PERMISSAO_DE_ACESSO = "aluno/professor"; //Checa Permissões.
require("includes/permissoes.php");

$intervalo = split("-",$_GET["intervalo"]); //Como o intervalo foi passado como um unico parametro separado por um "-" a função split o separa em dois.
$inicio = $intervalo[0];
$fim = $intervalo[1] + 86399;
?>
<html>
	<head>
	<style type="text/css">
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
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	</head>
	<body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" marginwidth="0" marginheight="0" class="tabelacalendario" bgcolor="#B7E4FB">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td class="titulo">De&nbsp;<?=date("d/m/Y",$inicio)?>&nbsp;até&nbsp;<?=date("d/m/Y",$fim)?></td><!-- Título da Tabela = Quando é passado um "timestamp" como parametro da função date() ela retorna a string de data referente ao timestamp. -->
					  </tr>
					  <tr> 
						<td align="left" valign="top"><?=constroi_tabela()?><!-- Chama a função de construção da tabela -->
						</td>
					  </tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>

<?php 
function constroi_tabela(){
# Para construção desta função foi usada como base a função controi_tabela() do atividades_dia.php a diferença estão nas consultas
# ao banco de dados que utiliza agora os timestamps recebidos como parâmetro e comparanto com os campos inicio das tabelas eventos e
# compromissos e o campo prazo da tabela tarefas.
	global $inicio, $fim;
	$linha = array();
	$ocorrencias = 0;
	$tabela = 	'<table width="100%" border="0" cellspacing="0" cellpadding="0">'
			.		'<tr>'
			.			'<td class="calendario" width="20%">Dia</td>'
			.			'<td class="calendario" width="20%">Horário</td>'
			.			'<td class="calendario" width="30%">Atividade</td>'
			.			'<td class="calendario" width="30%">Tipo</td>'
			.		'</tr>';
	
	require("includes/conectar_mysql.php");
	
	if($_COOKIE["tipo_usuario_agenda"] == "professor"){
		$query = "SELECT cd, tipo, nome, inicio FROM compromissos WHERE inicio>=" . $inicio . " AND inicio<=" . $fim; #Consulta: Retorne os compromissos onde o timestamp_inicio_compromisso seja maior ou igual ao timestamp_inicio_semana e  o timestamp_inicio_compromisso seja igual ou menor ao timestamp_fim_da_semana. As outras consultas seguem esta mesma lógica com relação as datas.
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["inicio"]) . "--" . date("H:i",$atividade["inicio"]) . "--" . "Compromisso" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--1");
			$ocorrencias++;
		}
		
		$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE prazo>=" . $inicio . " AND prazo<=" . $fim;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
			$ocorrencias++;
		}
	}
	if($_COOKIE["tipo_usuario_agenda"] == "aluno"){
		$query = "SELECT turma, curso FROM usuarios where cd=" . $_COOKIE["cd_usuario_agenda"];
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
		
		$query = "SELECT cd, tipo, nome, inicio FROM compromissos WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND inicio>=" . $inicio . " AND inicio<=" . $fim;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["inicio"]) . "--" . date("H:i",$atividade["inicio"]) . "--" . "Compromisso" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--1");
			$ocorrencias++;
		}
		
		$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND prazo>=" . $inicio . " AND prazo<=" . $fim . " AND opcao='todos'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
			$ocorrencias++;
		}
		
		$query = "SELECT nome_grupo FROM grupos_integrantes where cd_integrante=" . $_COOKIE["cd_usuario_agenda"];
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($grupo = mysql_fetch_array($result, MYSQL_ASSOC)){
			$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND prazo>=" . $inicio . " AND prazo<=" . $fim . " AND desc_opcao='" . $grupo["nome_grupo"] . "'";
			$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			while($atividade = mysql_fetch_array($result2, MYSQL_ASSOC)){
				array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
				$ocorrencias++;
			}
		}
	}
	
	$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE prazo>=" . $inicio . " AND prazo<=" . $fim . " AND opcao='privado' AND desc_opcao='" . $_COOKIE["cd_usuario_agenda"] . "'";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
		array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
		$ocorrencias++;
	}
	
	$query = "SELECT cd, tipo, nome, inicio FROM eventos WHERE inicio>=" . $inicio . " AND inicio<=" . $fim;
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
		array_push($linha, date("d/m",$atividade["inicio"]) . "--" . date("H:i",$atividade["inicio"]) . "--" . "Evento" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--3");
		$ocorrencias++;
	}
	
	require("includes/desconectar_mysql.php");
	
	if($ocorrencias == 0) return $tabela . '<tr><td align="center" colspan="4" style="border: solid thin #FFCC00" bgcolor="#FFCC00"><font color="#FFFFCC"><b>Não Há Atividades Para Esta Semana!</b></font></td></tr>';
	else{
		sort($linha);
		for ($i = 0; $i < count($linha); $i++){
			$valores = split("--", $linha[$i]);
			$tabela .= '<tr class="linha" title="' . $valores[4] . '" onMouseOver="mouse_em_cima(this)" onMouseOut="mouse_fora(this)" onClick="ver_atividade(' . $valores[5] .',' . $valores[6] . ');"><td class="celula">' . $valores[0] . '</td><td class="celula">' . $valores[1] . '</td><td class="celula">' . $valores[2] . '</td><td class="celula">' . $valores[3] . '</td></tr>';
		}	
		return $tabela;
	}
}
?>