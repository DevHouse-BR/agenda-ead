<?php
#############################################################
#	Tabela que relaciona as atividades agendadas para um	#
#	determinado mês passado como parâmetro.					#
#############################################################

// Este script é bem parecido com atividades_dias apenas mudando as sentenças SQL de modo a encontrar os registros daquele mês.

$PERMISSAO_DE_ACESSO = "aluno/professor"; //Permissões de acesso.
require("includes/permissoes.php");

$mes = $_GET["mes"];
$ano = date("Y");

switch((int)$mes){ //Descobre o Nome por extenso do mês em português.
	case 1:
		$extenso = "Janeiro";
		break;
	case 2:
		$extenso = "Fevereiro";
		break;
	case 3:
		$extenso = "Março";
		break;
	case 4:
		$extenso = "Abril";
		break;
	case 5:
		$extenso = "Maio";
		break;
	case 6:
		$extenso = "Junho";
		break;
	case 7:
		$extenso = "Julho";
		break;
	case 8:
		$extenso = "Agosto";
		break;
	case 9:
		$extenso = "Setembro";
		break;
	case 10:
		$extenso = "Outubro";
		break;
	case 11:
		$extenso = "Novembro";
		break;
	case 12:
		$extenso = "Dezembro";
		break;
}

if((int)$mes < 10) $mes = "0" . $mes; 	//Adiciona um zero na frente dos meses de 1 até 9, isto porque no banco de dados 
										//o mês está gravado com 0 na frente por causa da data dd/mm/aaaa.

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
	</head>
	<body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" marginwidth="0" marginheight="0" class="tabelacalendario" bgcolor="#B7E4FB">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%" align="left" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr> 
							<td class="titulo"><?=$extenso?></td>
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
#Como foi dito acima a única diferença do código desta função para o da função constroi_tabela() do atividades_dia.php é que as consultas
#são executadas passando a data de filtragem apenas o mes e o ano.
	global $mes, $ano;
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
		$query = "SELECT cd, tipo, nome, inicio FROM compromissos WHERE mes='" . $mes . "' AND ano='" . $ano . "'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["inicio"]) . "--" . date("H:i",$atividade["inicio"]) . "--" . "Compromisso" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--1");
			$ocorrencias++;
		}
		
		$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE mes='" . $mes . "' AND ano='" . $ano . "'";
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
		
		$query = "SELECT cd, tipo, nome, inicio FROM compromissos WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND mes='" . $mes . "' AND ano='" . $ano . "'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["inicio"]) . "--" . date("H:i",$atividade["inicio"]) . "--" . "Compromisso" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--1");
			$ocorrencias++;
		}
		
		$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND mes='" . $mes . "' AND ano='" . $ano . "' AND opcao='todos'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
			array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
			$ocorrencias++;
		}
		
		$query = "SELECT nome_grupo FROM grupos_integrantes where cd_integrante=" . $_COOKIE["cd_usuario_agenda"];
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($grupo = mysql_fetch_array($result, MYSQL_ASSOC)){
			$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND mes='" . $mes . "' AND ano='" . $ano . "' AND desc_opcao='" . $grupo["nome_grupo"] . "'";
			$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			while($atividade = mysql_fetch_array($result2, MYSQL_ASSOC)){
				array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
				$ocorrencias++;
			}
		}
	}
	
	$query = "SELECT cd, tipo, nome, prazo FROM tarefas WHERE mes='" . $mes . "' AND ano='" . $ano . "' AND opcao='privado' AND desc_opcao='" . $_COOKIE["cd_usuario_agenda"] . "'";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
		array_push($linha, date("d/m",$atividade["prazo"]) . "--" . date("H:i",$atividade["prazo"]) . "--" . "Tarefa" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--2");
		$ocorrencias++;
	}
	
	$query = "SELECT cd, tipo, nome, inicio FROM eventos WHERE mes='" . $mes . "' AND ano='" . $ano . "'";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($atividade = mysql_fetch_array($result, MYSQL_ASSOC)){
		array_push($linha, date("d/m",$atividade["inicio"]) . "--" . date("H:i",$atividade["inicio"]) . "--" . "Evento" . "--" . $atividade["tipo"] . "--" . $atividade["nome"] . "--" . $atividade["cd"] . "--3");
		$ocorrencias++;
	}
	
	require("includes/desconectar_mysql.php");
	
	if($ocorrencias == 0) return $tabela . '<tr><td align="center" colspan="4" style="border: solid thin #FFCC00" bgcolor="#FFCC00"><font color="#FFFFCC"><b>Não Há Atividades Para Este Mês!</b></font></td></tr>';
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