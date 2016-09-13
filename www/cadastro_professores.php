<?php
error_reporting(32);

//Praticamente id�ntico ao cadastro de alunos mas no contexto de professor.

$TITULO_PG = "PROFESSOR";
$PERMISSAO_DE_ACESSO = "professor/root";
require("includes/permissoes.php");

$modo =  $HTTP_GET_VARS["modo"];
$parametros = "";

if($modo == "update"){
	$parametros = "?modo=update&cd=" .  $HTTP_GET_VARS["cd"];
}
if($modo == "update"){
	require("includes/conectar_mysql.php");
		$cd =  $HTTP_GET_VARS["cd"];
		$query = "SELECT curso, turma, professor FROM usuarios where cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
}
############ Parte necess�ria para a constru��o dos menus selects de cursos e turmas #####################
$CURSO = $usuario["curso"];			//Caso esteja em modo update a Vari�vel CURSO guarda o nome do curso que o aluno faz parte para que o menu j� apare�a selecionado nesta op��o.	
require("includes/selects_turmas_cursos.php");	//Chama a include que cont�m as fun��es de constru��o dos menus SELECT turmas e cursos.
constroi_select_turmas("");	//Fun��o para construir os selects das turmas de acordo com os cursos. O par�metro desta fun��o ser� inserido
							//dentro da tag <select> das turmas e serve para inserir alguma fun��o para executar mediante algum evento.

?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Virtual!</title>
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
		<?php //C�digo em PHP para inserir vari�veis de javascript que cont�m os c�digos HTML dos selects de turmas. Tamb�m faz parte do c�digo necess�rio para gerar os menus dinamicos de cursos e turmas.
			for ($i = 0; $i <= sizeof($selects); $i ++){ //Este loop imprime o conteudo de cada um dos elementos do array selects que � construido dentro da include selects_turmas_cursos.php.
				echo($selects[$i] . "\n");
			}
		?>
			function muda_turma(){	//Esta fun��o em javascript tamb�m faz parte do c�digo para os selects dinamicos. Sua fun��o � mudar o select turmas para um que esteja de acordo com o curso selecionado. 
				var str = new String(form1.curso.value); //Pega o nome do curso que foi selecionado e cria um objeto do tipo string.
				var variavel = str.split(" ");	//Usa o metodo split da fun��o que vai criar um array contendo os elementos da string divididos por espa�o. Isto porque os selects de turmas levam o nome do curso correpondente e s�o carregados em forma de vari�veis mas as variaveis n�o podem ter espa�os em branco nos seus nomes.
				variavel = variavel.join("_");	//Une novamente o nome do curso s� que com o "underline" _ no lugar dos espa�os em branco.
				if (variavel.length != 0) eval("selects.innerHTML = " + variavel + ";"); //Troca todo o conteudo dentro da tag <div> de id="selects" para o html que est� contido na variavel de nome do curso selecionado.
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
										<?php if ($HTTP_COOKIE_VARS["nome_usuario_agenda"] == "root") { ?>
														<strong><font color="#FF0000" face="Arial, Helvetica, sans-serif">Os professores cadastrados nesta etapa n�o estar�o associados a nenhum curso nem turma. Efetue logon com um novo professor e cadastre cursos e turmas e associe aos professores.</font></strong>
													<? } else { ?>
											<table width="100%" border="0" cellspacing="1" cellpadding="1">
												<form name="form1">
											  <tr> 
												<td width="50%">
													<table width="70%" border="0" cellspacing="1" cellpadding="1">
														<tr> 
														  <td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
														  <td width="81%"><?=constroi_select_curso();?></td><!-- Roda a fun��o que est� escrita dentro do script selects_turmas_cursos.php -->
														</tr>
													</table>
												</td>
												<td align="right">
													<table border="0" width="250">
														<tr> 
                            								<td align="left" width="20%"><font size="2" face="Arial, Helvetica, sans-serif">Turma:</font></td>
															<td width="70%"><div id="selects">
																<?php // O layer (div) chamado "selects" a princ�pio n�o contem nenhum c�digo em html, mas caso o modo seja update o c�digo abaixo j� vai inserir o menu select da turma do aluno com a sua turma j� selecionada.
																			if($modo == "update"){
																				for ($i = 0; $i <= sizeof($selects); $i ++){ 
																					if (strpos($selects[$i],str_replace(" ", "_", $usuario["curso"])) == 4){
																						$tmp = 'var ' . str_replace(" ", "_", $usuario["curso"]) . ' = ';
																						$tmp = str_replace($tmp, "", $selects[$i]);
																						$tmp = str_replace("\\", "", $tmp);
																						$tmp = str_replace("\"<", "<", $tmp);
																						$tmp = str_replace(">\";", ">", $tmp);
																						$tmp = str_replace($usuario["turma"] . "\"", $usuario["turma"] . "\" selected", $tmp);
																						echo($tmp);
																					}
																				}
																			}
																			else echo('<select style="width:100%;"></select>');
																		?>
																	</div>
															</td>
															<td></td>
														</tr>
													</table>
												</td>
											  </tr>
											</form>
										  </table>
										  <? } ?>
										<br></td>
										<td width="4%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="center"><iframe width="100%" frameborder="0" height="260" src="form_professor.php<?=$parametros?>"></iframe></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="center"><input name="ok" type="button" value=" OK " class="botao" onClick="location = 'visualizar_professores.php';"></td>
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