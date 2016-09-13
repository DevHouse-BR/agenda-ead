<?php
//Como em quase todos os cadastros este também foi feito em duas partes sendo que uma roda dentro do iframe deste script.
//Praticamente este script tem o mesmo código do cadastro de alunos com algumas diferenças comentadas abaixo:

$TITULO_PG = "GRUPOS DE TRABALHO";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

$modo = $_GET["modo"];
$parametros = "";

if($modo == "update"){
	require("includes/conectar_mysql.php");
		$cd = $_GET["cd"];
		$query = "SELECT curso, turma, professor FROM grupos WHERE cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$grupo = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
}

if($modo == "update"){
	$parametros = "?modo=update&cd=" . $_GET["cd"] . "&curso=" . urlencode($grupo["curso"]) . "&turma=" . urlencode($grupo["turma"]); //É necessário passar o nome da turma e do curso para o php que será rodado no iframe para que ele já saiba os alunos envolvidos. A função "urlencode()" altera caracteres não permitidos na url por caracteres permitidos como por exemplo espaços viram %20.
}
$CURSO = $grupo["curso"];
require("includes/selects_turmas_cursos.php");
constroi_select_turmas('onChange=\\"escolhe_turma()\\"'); //Note que desta vez é passado um parâmetro nesta função ele faz com que ao selecionar uma turma no menu ele executa a função javascript: escolhe_turma().
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Eletr&ocirc;nica!</title>
		<style type="text/css">
			@import url("includes/estilo.css");
			input {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
				border: 1px solid #666666;
			}
		</style>
		<script language="JavaScript" src="includes/menuhorizontal.js"></script>
		<script language="JavaScript">
		<?php
			for ($i = 0; $i <= sizeof($selects); $i ++){
				echo($selects[$i] . "\n");
			}
		?>
			function muda_turma(){
				var str = new String(form1.curso.value);
				var variavel = str.split(" ");
				variavel = variavel.join("_");
				if (variavel.length != 0) eval("selects.innerHTML = " + variavel + ";");
			}
			function escolhe_turma(){	//Ao escolher a turma o browser atualiza o html dentro do iframe para mostrar os alunos da nova turma selecionada.
				viz.location = 'form_grupo.php?curso=' + escape(form1.curso.value) + '&turma=' + escape(form1.turma.value);
			}
		</script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0">
			<tr>
				<td align="center" valign="middle"><?php require("includes/menuhorizontal.php"); ?>
					<table width="775" height="383" border="0" cellpadding="0" cellspacing="0" class="janela">
					<tr>
							<td colspan="2" align="center"><?php require("includes/barra_titulo.php"); ?></td>
						</tr>
						<tr> 
							<td colspan="2" valign="middle">
								<table width="100%" border="0" cellspacing="1" cellpadding="1">
									<tr>
										<td width="4%">&nbsp;</td>
										<td width="92%">
											<table width="100%" border="0" cellspacing="1" cellpadding="1">
												<form name="form1">
												<tr>
													<td width="50%">
														<table width="70%" border="0" cellspacing="1" cellpadding="1">
															<tr> 
																<td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
																<td width="81%"><?=constroi_select_curso();?></td>
															</tr>
															<tr> 
																<td align="left"><font size="2" face="Arial, Helvetica, sans-serif">Turma:</font></td>
																<td><div id="selects">
																		<?php 
																			if($modo == "update"){
																				for ($i = 0; $i <= sizeof($selects); $i ++){
																					if (strpos($selects[$i],str_replace(" ", "_", $grupo["curso"])) == 4){
																						$tmp = 'var ' . str_replace(" ", "_", $grupo["curso"]) . ' = ';
																						$tmp = str_replace($tmp, "", $selects[$i]);
																						$tmp = str_replace("\\", "", $tmp);
																						$tmp = str_replace("\"<", "<", $tmp);
																						$tmp = str_replace(">\";", ">", $tmp);
																						$tmp = str_replace($grupo["turma"] . "\"", $grupo["turma"] . "\" selected", $tmp);
																						echo($tmp);
																					}
																				}
																			}
																		?>
																	</div>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="50%">
														<table width="70%" border="0" cellspacing="1" cellpadding="1">
															<tr> 
																<td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Professor:</font></td>
																<td width="81%"><input type="text" name="professor" <?php if($modo == "update") echo("value=\"". $grupo["professor"] . "\""); elseif ($_COOKIE["tipo_usuario_agenda"] == "professor") echo('value="' . $_COOKIE["nome_usuario_agenda"] . '"'); ?>></td>
															</tr>
														</table>
													</td>
												</tr>
												</form>
											</table>
										<br>
										</td>
										<td width="4%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td><iframe width="100%" id="viz" frameborder="0" height="260" src="form_grupo.php<?=$parametros?>"></iframe></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="center"><input name="ok" type="button" value=" OK " class="botao" onClick="location = 'visualizar_grupos.php';"></td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>