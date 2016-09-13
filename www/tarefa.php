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
			function valida_form(){ //Valida o formulário
				f = document.forms[0];
				if ((f.nome.value != "") && (f.descricao.value != "") && (f.curso.value != "") && (f.turma.value != "")){
					f.submit();
				}
				else alert("Os campos Nome, Descrição, Curso e Turma são obrigatórios!");
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
                <td width="22%"></td>
                <td width="51%"></td>
                <td width="27%"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <form name="tarefa" method="post" action="salva_tarefa.php">
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
							<?php 	for($i = 1; $i < 10; $i++) echo('<option value="0' . $i . '">0' . $i . '</option>');	//Utilizando o php para economizar digitar todas as opções... 
									for($i = 10; $i < 13; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
						</select>/
						<select name="data_ano">
							<?php 	for($i = (int)date("Y"); $i < (int)date("Y") + 10; $i++) echo('<option value="' . $i . '">' . $i . '</option>');	//Utilizando o php para economizar digitar todas as opções... ?>
						</select>
						</td>
                      </tr>
					  <tr> 
                      	<td align="right" class="nomecampo">Hor&aacute;rio:</td>
                    	<td>
							<select name="horario_hora">
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções...  
									for($i = 10; $i < 25; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>:
							<select name="horario_minuto">
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções...  
									for($i = 10; $i < 60; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>
						</td>
                    </tr>
                      <tr> 
                        <td align="right" class="nomecampo">&nbsp;Avisar com</td>
                        <td class="nomecampo"> <select name="avisar">
                            <?php 	for($i = 1; $i < 11; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções... 
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
                        <td><input class="campotxt" type="text" name="curso" value="<?=$curso?>" disabled></td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Turma:</td>
                        <td><input class="campotxt" type="text" name="turma" value="<?=$turma?>" disabled></td>
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