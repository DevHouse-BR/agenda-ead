<?php
#########################################################################################################################
#	Provavelmente um dos scripts mais complexos do sistema. Ele monta o Calendário que é visualizado dentro do iframe	#
#	contido no script agenda.php																						#
#########################################################################################################################

$PERMISSAO_DE_ACESSO = "aluno/professor";	//Permissões
require("includes/permissoes.php");

$mes = $_GET["mes"];						//Este script recebe como parâmetro o mês para que seja construido o calendário de acordo com este mes.
$ano = $_GET["ano"];						//Todo o código já está preparado para receber como parâmetro o ano também, apesar de não ser usado.

if ($mes == "") $mes = date("m");			//Caso não seja informado o mes a função date() seta o mes para o mes corrente no servidor.
if ($ano == "") $ano = date("Y");			//O mesmo para o ano.

if ($mes == date("m")){								//Caso o mês a ser construido seja o mês corrente
	$hoje = mktime(0,0,0,$mes,date("j"),$ano);		//a variável $hoje guardará o valor do timestamp do dia corrente para poder 	
}													//identifica-lo no calendário.

switch($mes){	//Monta o título do calendário informando o mês em português.
	case 1:
		$titulo_calendario = "Janeiro/" . $ano;
		break;
	case 2:
		$titulo_calendario = "Fevereiro/" . $ano;
		break;
	case 3:
		$titulo_calendario = "Março/" . $ano;
		break;
	case 4:
		$titulo_calendario = "Abril/" . $ano;
		break;
	case 5:
		$titulo_calendario = "Maio/" . $ano;
		break;
	case 6:
		$titulo_calendario = "Junho/" . $ano;
		break;
	case 7:
		$titulo_calendario = "Julho/" . $ano;
		break;
	case 8:
		$titulo_calendario = "Agosto/" . $ano;
		break;
	case 9:
		$titulo_calendario = "Setembro/" . $ano;
		break;
	case 10:
		$titulo_calendario = "Outubro/" . $ano;
		break;
	case 11:
		$titulo_calendario = "Novembro/" . $ano;
		break;
	case 12:
		$titulo_calendario = "Dezembro/" . $ano;
		break;
}


$primeiro_dia_mes = mktime(0,0,0,$mes,1,$ano);				//Timestamp para o primeiro dia do mes.
$primeiro_dia_mes_semana = date("w",$primeiro_dia_mes);		//O número do dia da semana que "cai" o primeiro dia do mês

$inicio_calendario = (($primeiro_dia_mes_semana) * 86400);				//A diferença entre o primeiro dia do mês para o primeiro dia a ser mostrado no calendário.
$primeiro_dia_calendario = $primeiro_dia_mes - $inicio_calendario;		//Subtraindo-se achamos o timestamp para o primeiro dia do calendário. (provavelmente do mês anterior.

$calendario = 	"<table height=153 width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"; //Inicia a construção da tabela do calendário.
	$calendario .=	"<tr>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">dom</td>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">seg</td>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">ter</td>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">qua</td>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">qui</td>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">sex</td>";
		$calendario .=	"<td class=\"calendario\" width=\"14%\">sab</td>";
	$calendario .=	"</tr>";
	
	//É construido em paralelo uma tabela para as setinhas laterais ao calendario que indicam as semanas do calendário.
	$setas = "<table height=153 border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td style=\"font-family: Arial, Helvetica, sans-serif;	font-size: 10px;\">&nbsp;</td></tr>";
	
	$dia = $primeiro_dia_calendario;		//A variavel dia é o timestamp do dia que o loop construtor do calendário estará tratando. 
	$ultimodia = "";						//A variavel ultimo dia guarda o ultimo dia em forma de string para comparar com a variavel dia para não repetir dias no calendário (bug que estava ocorrendo no mês de fevereiro). 
	for($j = 0; $j <6 ; $j++){				//Da semana 0 até a semana seis
		if (($j == 0) || (($j != 0) && (date("m", $dia) == $mes))) { //verifica se o primeiro dia desta semana começará com um dia que ainda está no mês corrente.
			$primeiro_dia_n_semana = $dia;	//A variavel primeiro_dia_n_semana guarda o valor do timestamp da zero hora do primeiro dia desta semana para depois passálo como parâmetro na visualização de atividades semanal.
			$calendario .=	"<tr>";			//Adiciona a tabela a tag de nova linha.
			for($i = 0; $i < 7; $i++){		//Do primeiro ao sétimo dia da semana:
				if ($ultimodia != date("j",$dia)){	//Só continuar se o dia for diferente do ultimo dia impresso.
					if($dia == $hoje) $calendario .= "<td class=\"hoje\">" . verifica_agendamento($dia) . "</td>";	//Caso o dia analizado seja o dia corrente no servidor ele será impresso no calendário em destaque.
					else {	//senão: se o dia estiver dentro do mês a ser construido ele será impresso em preto.
						if (date("m", $dia) == $mes) $calendario .= "<td class=\"interior\">" . verifica_agendamento($dia) . "</td>"; //A cada dia do mês é feita uma verificação no banco de dados para verificar a existência de alguma atividade agendada para aquele dia.
						else { //Senão será impresso em cinza:
							$calendario .= "<td class=\"outromes\">" . verifica_agendamento($dia) . "</td>";
						}
					}
				}
				else $i--; //Caso o ultimo dia for igual ao dia sendo analisado então a variavel i vai voltar em uma unidade para poder fechar 7 dias na semana.
				$ultimodia = date("j",$dia); //aqui é gravado a informação na variavel ultimo dia.
				$ultimo_dia_n_semana = $dia; //O timestamp da zero hora do ultimo dia da semana antes de ser acrecentado mais um dia a variavel dia. (86400 segundos)
				$dia = $dia + 86400;
			}
			$calendario .=	"</tr>"; //A seta abaixo vai com a informação para executar o javascript ver_semana com o intervalo do primeiro ao ultimo dia da semana.
			$setas .= "<tr><td class=\"setas\" align=\"center\" valign=\"middle\" onClick=\"ver_semana('" . $primeiro_dia_n_semana . "-" . $ultimo_dia_n_semana . "');\"><img src=\"img/seta_cal.gif\" alt=\"Visão Semanal\"></td></tr>"; 
		}
	}
$calendario .=	"</table>";
$setas .=	"</table>";
?>
<html>
<head>
<style type="text/css">
@import url("includes/estilo.css");
@import url("includes/calendario.css");
</style>
<script language="JavaScript">
	var corantiga;				//Duas variáveis utilizadas para a mudança de cores quando o mouse passa por cima do nome dos meses.
	var novacor = "#FF0000";
	function muda_mes(mes){		//Função que faz com que o próprio calendário seja carregado para o mês selecionado e também mostrando a tabela de atividades para o mês selecionado.
		self.location = "calendario.php?mes=" + mes;
		parent.viz.location = "atividades_mes.php?mes=" + mes;
	}
	function ver_dia(data){		//Função que mostra a tabela de atividades para um dia selecionado.
		var parametros = data.split("/");
		parent.viz.location = "atividades_dia.php?dia=" + parametros[0] + "&mes=" + parametros[1] + "&ano=" + parametros[2];
	}
	function ver_semana(intervalo){	//Função que mostra a tabela de atividades para uma semana selecionada.
		parent.viz.location = "atividades_semana.php?intervalo=" + intervalo;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" bottommargin="0" rightmargin="0" marginwidth="0" marginheight="0">
<table width="106%" border="0" cellpadding="0" cellspacing="0" height="200">
	<tr>
		<td align="right" valign="top">
			<table border="0" cellspacing="0" cellpadding="0">
			  <tr> 
				<td style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; border: solid 1px white;">&nbsp;</td>
			  </tr>
				<tr> 
				<td align="right" valign="top">
				  <?=$setas?><!--Monta a tabela das setas semanais -->
				</td>
			  </tr>
			</table>
		</td>
		<td width="100%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabelacalendario">
			  <tr> 
				<td class="titulo"><?=$titulo_calendario?></td>
			  </tr>
			  <tr> 
				<td align="left" valign="top">
				  <?=$calendario?><!-- Monta a tabela do calendário -->
				</td>
			  </tr>
			  <tr> 
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr> 
					  <td class="mes" onClick="muda_mes(1);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">jan</td>
					  <td class="mes" onClick="muda_mes(2);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">fev</td>
					  <td class="mes" onClick="muda_mes(3);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">mar</td>
					  <td class="mes" onClick="muda_mes(4);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">abr</td>
					  <td class="mes" onClick="muda_mes(5);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">mai</td>
					  <td class="mes" onClick="muda_mes(6);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">jun</td>
					</tr>
					<tr> 
					  <td class="mes" onClick="muda_mes(7);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">jul</td>
					  <td class="mes" onClick="muda_mes(8);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">ago</td>
					  <td class="mes" onClick="muda_mes(9);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">set</td>
					  <td class="mes" onClick="muda_mes(10);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">out</td>
					  <td class="mes" onClick="muda_mes(11);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">nov</td>
					  <td class="mes" onClick="muda_mes(12);" onMouseOver="corantiga = this.style.color; this.style.color = novacor;" onMouseOut="this.style.color = corantiga;">dez</td>
					</tr>
				  </table></td>
			  </tr>
			</table>
</td>
</tr>
</table>
</body></html>

<?php 
//A função abaixo verifica se há atividades para cada dia do calendário.
//As consultas do banco são muito parecidas com as consultas dos scripts que montam as tabelas de atividades diarias, semanais e mensais.
//A diferença é a utilização da função SQL count(). Ela não retorna as informações da atividade e sim quantas atividades satisfazem o 
//critério de busca. Caso não seja encontrada nenhuma atividade no dia analisado o dia é impresso em preto. Caso sim o dia é impresso em
//vermelho.
function verifica_agendamento($dia){
	require("includes/conectar_mysql.php");
	
	if($_COOKIE["tipo_usuario_agenda"] == "professor"){
		$query = "SELECT COUNT(cd) FROM compromissos WHERE dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$tmp = mysql_fetch_row($result);
		$ocorrencias = $tmp[0];
		
		$query = "SELECT COUNT(cd) FROM tarefas WHERE dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$tmp = mysql_fetch_row($result);
		$ocorrencias = $ocorrencias + $tmp[0];
	}
	if($_COOKIE["tipo_usuario_agenda"] == "aluno"){
		$query = "SELECT turma, curso FROM usuarios where cd=" . $_COOKIE["cd_usuario_agenda"];
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
		
		$query = "SELECT COUNT(cd) FROM compromissos WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$tmp = mysql_fetch_row($result);
		$ocorrencias = $tmp[0];
		
		$query = "SELECT COUNT(cd) FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "' AND opcao='todos'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$tmp = mysql_fetch_row($result);
		$ocorrencias = $ocorrencias + $tmp[0];
		
		$query = "SELECT nome_grupo FROM grupos_integrantes where cd_integrante=" . $_COOKIE["cd_usuario_agenda"];
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($grupo = mysql_fetch_array($result, MYSQL_ASSOC)){
			$query = "SELECT COUNT(cd) FROM tarefas WHERE turma='" . $usuario["turma"] . "' AND curso='" . $usuario["curso"] . "' AND dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "' AND desc_opcao='" . $grupo["nome_grupo"] . "'";
			$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			$tmp = mysql_fetch_row($result2);
			$ocorrencias = $ocorrencias + $tmp[0];
		}
	}
	
	$query = "SELECT COUNT(cd) FROM tarefas WHERE dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "' AND opcao='privado' AND desc_opcao='" . $_COOKIE["cd_usuario_agenda"] . "'";
	$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$tmp = mysql_fetch_row($result2);
	$ocorrencias = $ocorrencias + $tmp[0];
	
	$query = "SELECT COUNT(cd) FROM eventos WHERE dia='" . date("d",$dia) . "' AND mes='" . date("m",$dia) . "' AND ano='" . date("Y",$dia) . "'";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$tmp = mysql_fetch_row($result);
	$ocorrencias = $ocorrencias + $tmp[0];
	
	require("includes/desconectar_mysql.php");
	
	if($ocorrencias != 0) return '<div class="diaocorrencia" onclick="ver_dia(\'' . date("d",$dia) . "/" . date("m",$dia) . "/" . date("Y",$dia) . '\')" title="Veja Atividades para este dia.">' . date("j",$dia) . '</div>';
	else return date("j",$dia);
}
?>