<?php

# Este script serve como formulário para colher as informações e enviá-las por email.
# Ele contém o código para o envio da mensagem.

$TITULO_PG = "ENVIAR MENSAGEM";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

require("includes/selects_turmas_cursos.php");
constroi_select_turmas("");

if($HTTP_POST_VARS["modo"] == "enviar"){  //Caso esteja rodando em modo=enviar.
	$tipo = $HTTP_POST_VARS["tipo"];
	$assunto = $HTTP_POST_VARS["assunto"];		//Recolhe as informações digitadas
	$mensagem = $HTTP_POST_VARS["mensagem"];
	$opcao = $HTTP_POST_VARS["opcoes"];
	$curso = $HTTP_POST_VARS["curso"];
	$turma = $HTTP_POST_VARS["turma"];
	
	if ($HTTP_COOKIE_VARS["tipo_usuario_agenda"] == "professor") $de = "Prof. " . $HTTP_COOKIE_VARS["nome_usuario_agenda"]; //caso seja o professor a enviar a mensagem é adicionado a abreviatura de professor na frente do seu nome.
	else $de =  $HTTP_COOKIE_VARS["nome_usuario_agenda"];

	if($opcao == "todos"){ //Caso a mensagem seja para todos os usuarios da agenda.
		require("includes/conectar_mysql.php");
		$query = "SELECT nome, email FROM usuarios";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
			$ok = mail($usuario["email"], $tipo . ": " . $assunto, "Caro, " . $usuario["nome"] . "\n\n" . $mensagem, "From: " . $de . "<" . $HTTP_COOKIE_VARS["email_usuario_agenda"] . ">");
		}
		require("includes/desconectar_mysql.php");
	}
	if($opcao == "curso_turma"){ //Caso a mensagem seja para apenas uma turma de um determinado curso.
		require("includes/conectar_mysql.php");
		$query = "SELECT nome, email FROM usuarios WHERE curso='" . $curso . "' AND turma='" . $turma . "'";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($usuario = mysql_fetch_array($result, MYSQL_ASSOC)){
			$ok = mail($usuario["email"], $tipo . ": " . $assunto, "Caro, " . $usuario["nome"] . "\n\n" . $mensagem, "From: " . $de . "<" . $HTTP_COOKIE_VARS["email_usuario_agenda"] . ">");
		}
		require("includes/desconectar_mysql.php");
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
			for ($i = 0; $i <= sizeof($selects); $i ++){
				echo($selects[$i] . "\n");
			}
			if($ok) echo('alert("Mensagem Enviada!");');
		?>
			function muda_turma(){
				var str = new String(document.forms[0].curso.value);
				var variavel = str.split(" ");
				variavel = variavel.join("_");
				if (variavel.length != 0) eval("selects.innerHTML = " + variavel + ";");
			}
			function valida_form(){
				f = document.forms[0];
				if ((f.assunto.value != "") && (f.mensagem.value != "")){
					f.submit();
				}
				else alert("Todos os campos são obrigatórios!");
			}
			function libera_curso(botao){  //Esta função serve para abilitar o menu de curso após a escolha de envio por curso/turma
				var x = document.forms[0].opcoes[botao].value;
				var y = document.forms[0].curso;
				var z = document.forms[0].turma;
				if(x == "curso_turma")	{
					y.disabled = false;
					if(z) z.disabled = false;
				}
				else {
					y.disabled = true;
					if(z) z.disabled = true;
				}
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
                    <form method="post" action="mensagem.php">
                      <tr> 
                        <td width="31%" align="right" class="nomecampo">Tipo:</td>
                        <td width="69%"><select name="tipo" id="tipo">
                            <option value="Comunicado">Comunicado</option>
                            <option value="Alerta">Alerta</option>
                            <option value="Outros">Outros</option>
                          </select></td>
                      </tr>
                      <tr> 
                        <td align="right" class="nomecampo">Assunto:</td>
                        <td><input type="text" name="assunto" class="campotxt"></td>
                      </tr>
                      <tr> 
                        <td align="right" valign="top" class="nomecampo">Mensagem:</td>
                        <td><textarea name="mensagem" class="campotxt" rows="5"></textarea></td>
                      </tr>
                      <tr> 
                        <td align="right" valign="top" class="nomecampo">Op&ccedil;&otilde;es:</td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td width="7%" align="right"> <input type="radio" name="opcoes" value="todos" onClick="libera_curso(0);"></td>
                              <td width="25%" class="nomecampo"> &nbsp;Para todos</td>
                              <td width="68%">&nbsp;</td>
                            </tr>
                            <tr> 
                              <td align="right"><input type="radio" name="opcoes" value="curso_turma" onClick="libera_curso(1);"></td>
                              <td class="nomecampo">Curso:</td>
                              <td> 
                                <?=constroi_select_curso();?>
                              </td>
                            </tr>
                            <tr> 
                              <td align="right">&nbsp; </td>
                              <td class="nomecampo">Turma:</td>
                              <td><div id="selects"></div></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr> 
                        <td align="right"><input name="incluir" type="button" value="Enviar" class="botao" onClick="valida_form();"></td>
                        <td><input name="cancelar" type="reset" value="Cancelar" class="botao" onClick=""></td>
                      </tr>
                      <input type="hidden" name="modo" value="enviar">
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
	<script language="JavaScript">
		document.forms[0].curso.disabled = true; //Desabilita o menu curso.
	</script>
</html>