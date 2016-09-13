<?php
// O script tarefa.php trata da coleta e agendamento de uma tarefa no banco de dados.


$TITULO_PG = "TAREFA";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

require("includes/selects_turmas_cursos.php");	//Código para os selects de curso e turma
constroi_select_turmas("");

if($_POST["modo"] == "add"){	//Quando o script está rodando em modo de adição ao banco,
	$tipo = $_POST["tipo"];		//ele recolhe as informações digitadas previamente.
	$nome = $_POST["nome"];
	$descricao = $_POST["descricao"];
	$data_dia = $_POST["data_dia"];
	$data_mes = $_POST["data_mes"];
	$data_ano = $_POST["data_ano"];
	$email = $_POST["email"];
	$wap = $_POST["wap"];
	$curso = $_POST["curso"];
	$turma = $_POST["turma"];
	$avisar = $_POST["avisar"];
	$opcao = $_POST["opcoes"];
	$prioridade = $_POST["prioridade"];
	$horario_hora = $_POST["horario_hora"];
	$horario_minuto = $_POST["horario_minuto"];

	
	if($opcao == "em_grupo") $desc_opcao = $_POST["grupo"];	//Caso a tarefa seja para um grupo específico, o campo descrição da opção armazenará o nome do grupo.
	
	if($opcao == "privado") $desc_opcao = $_COOKIE["cd_usuario_agenda"]; //Caso a tarefa seja para apenas a pessoa que a agendou, o campo descrição da opção armazenará o código o usuário.
	
	if($email == true) $email = "s";
	else $email = "n";
	
	if($wap == true) $wap = "s";
	else $wap = "n";

	$dia = mktime($horario_hora, $horario_minuto, 0, $data_mes, $data_dia, $data_ano);
	$avisar = $dia - ($avisar * 86400);
		
	$query = "INSERT INTO tarefas (tipo, nome, descricao, prazo, email, wap, avisar, prioridade, curso, turma, opcao, desc_opcao, dia, mes, ano, avisado) VALUES ('";
	$query .= $tipo ."','";
	$query .= $nome ."','";
	$query .= $descricao ."','";
	$query .= $dia ."','";
	$query .= $email ."','";
	$query .= $wap ."','";
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
	require("includes/desconectar_mysql.php");
}
?>

<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Eletr&ocirc;nica!</title>
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
		<?php //Codigo necessário para os menus de cursos e turmas
			for ($i = 0; $i <= sizeof($selects); $i ++){
				echo($selects[$i] . "\n");
			}
			if($ok) echo('alert("Tarefa Agendada!");');
		?>
			function muda_turma(){ //Codigo necessário para os menus de cursos e turmas
				var str = new String(tarefa.curso.value);
				var variavel = str.split(" ");
				variavel = variavel.join("_");
				if (variavel.length != 0) eval("selects.innerHTML = " + variavel + ";");
			}
			function valida_form(){ //Valida o formulário
				f = document.forms[0];
				if ((f.nome.value != "") && (f.descricao.value != "") && (f.data.value != "")){
					f.submit();
				}
				else alert("Todos os campos são obrigatórios!");
			}
			function libera_grupo(botao){	//Como no envido de mensagem esta função libera o campo de texto de grupo para que seja editado somente se selecionada a opção em grupo.
				var x = document.forms[0].opcoes[botao].value;
				var y = document.forms[0].grupo;
				var z = document.forms[0].escolhe_grupo;
				if(x == "em_grupo")	{
					y.disabled = false;
					z.disabled = false;
				}
				else {
					y.disabled = true;
					z.disabled = true;
				}
			}
			function seleciona_grupo(onde){ //Chama a tabela de grupos e coloca ela em modo "escolhe"
				window.open('tabela_grupos.php?modo=escolhe&onde=' + onde, 'Tabela', 'width=610,height=280,status=no,resizable=no,top=20,left=100,dependent=yes,alwaysRaised=yes,scrollbars=yes');
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
          <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="22%" height="70">&nbsp;</td>
                <td width="51%">&nbsp;</td>
                <td width="27%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <form name="tarefa" method="post" action="tarefa.php">
                      <tr> 
                        <td width="31%" align="right" class="nomecampo">Tipo:</td>
                        <td width="69%"><select name="tipo" id="tipo">
                            <option value="Trabalho">Trabalho</option>
                            <option value="Trabalho em Grupo">Trabalho em Grupo</option>
                            <option value="Outros">Outros</option>
                          </select></td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Nome:</td>
                        <td><input type="text" name="nome" class="campotxt"></td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Descri&ccedil;&atilde;o:</td>
                        <td> <textarea name="descricao" rows="2" class="campotxt" id="descricao"></textarea></td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Prazo de Conclus&atilde;o:</td>
                        <td>
						<select name="data_dia">
							<?php 	for($i = 1; $i < 10; $i++) echo('<option value="0' . $i . '">0' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções...
									for($i = 10; $i < 32; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>/
						<select name="data_mes">
							<?php 	for($i = 1; $i < 10; $i++) echo('<option value="0' . $i . '">0' . $i . '</option>');	//Utilizando o php para economizar digitar todas as opções... :-) 
									for($i = 10; $i < 13; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
						</select>/
						<select name="data_ano">
							<?php 	for($i = (int)date("Y"); $i < (int)date("Y") + 10; $i++) echo('<option value="' . $i . '">' . $i . '</option>');	//Utilizando o php para economizar digitar todas as opções... :-) ?>
						</select>
						</td>
                      </tr>
					  <tr> 
                      	<td align="right" class="nomecampo">Hor&aacute;rio:</td>
                    	<td>
							<select name="horario_hora">
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções... :-) 
									for($i = 10; $i < 25; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>:
							<select name="horario_minuto">
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções... :-) 
									for($i = 10; $i < 60; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>
						</td>
                    </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Enviar por:</td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="4%" align="right"><input type="checkbox" name="email"> 
                              </td>
                              <td width="26%" class="nomecampo">E-mail</td>
                              <td width="8%" align="right"> <input type="checkbox" name="wap"> 
                              </td>
                              <td width="62%" class="nomecampo">Wap</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">&nbsp;Avisar com</td>
                        <td class="nomecampo"> <select name="avisar">
                            <?php 	for($i = 1; $i < 11; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções... :-) 
							?>
                          </select>
                          dias de anteced&ecirc;ncia.</td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Prioridade:</td>
                        <td>
							<select name="prioridade">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Curso:</td>
                        <td> 
                          <?=constroi_select_curso();?>
                        </td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Turma:</td>
                        <td><div id="selects"></div></td>
                      </tr>
					  <tr> 
                        <td align="right" valign="top" class="nomecampo">Op&ccedil;&otilde;es:</td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="7%" align="right"> <input type="radio" name="opcoes" value="todos" onClick="libera_grupo(0);"></td>
                              <td width="28%" class="nomecampo"> &nbsp;Para todos</td>
                              <td width="65%">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td align="right"> <input type="radio" name="opcoes" value="privado" onClick="libera_grupo(1);"></td>
                              <td class="nomecampo">&nbsp;Privada</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr> 
                              <td align="right"> <input type="radio" name="opcoes" value="em_grupo" onClick="libera_grupo(2);"></td>
                              <td class="nomecampo">&nbsp;Em grupo</td>
                              <td><input type="text" name="grupo" class="campotxt" style="width: 66%;" disabled>&nbsp;<input name="escolhe_grupo" type="button" value="Grupo" class="botao" onClick="seleciona_grupo('grupo');" disabled></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td align="right"><input name="incluir" type="button" value=" Agendar " class="botao" onClick="valida_form();"></td>
                        <td><input name="cancelar" type="reset" value="Cancelar" class="botao" onClick=""></td>
                      </tr>
                      <input type="hidden" name="modo" value="add">
                    </form>
                  </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table> 
				</td>
			</tr>
		</table>
	</body>
</html>