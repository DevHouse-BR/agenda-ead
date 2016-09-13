<?php
#	Script que executa o cadastro dos compromissos.

$TITULO_PG = "COMPROMISSO";					//Titulo da página
$PERMISSAO_DE_ACESSO = "aluno/professor";	//Permissões
require("includes/permissoes.php");

require("includes/selects_turmas_cursos.php"); //Include para construção dos menus de cursos e turmas.
constroi_select_turmas("");
$modo = $_POST["modo"];

if($modo == "add"){			//Caso o modo de execução seja para adicionar, o script vai buscar as informações digitadas no formulário.
	$tipo = $_POST["tipo"];
	$nome = $_POST["nome"];
	$descricao = $_POST["descricao"];
	$data_dia = $_POST["data_dia"];
	$data_mes = $_POST["data_mes"];
	$data_ano = $_POST["data_ano"];
	$horario_hora = $_POST["horario_hora"];
	$horario_minuto = $_POST["horario_minuto"];
	$duracao = $_POST["duracao"];
	$email = $_POST["email"];
	$wap = $_POST["wap"];
	$curso = $_POST["curso"];
	$turma = $_POST["turma"];
	$avisar = $_POST["avisar"];
	
	if($email == true) $email = "s";
	else $email = "n";
	
	if($wap == true) $wap = "s";
	else $wap = "n";
	
	$inicio = mktime($horario_hora, $horario_minuto, 0, $data_mes, $data_dia, $data_ano); //A função mktime() calcula o timestamp para a data e hora passada.
	$fim = $inicio + (($duracao * 60) * 60);	//O fim do compromisso é calculado a partir da hora de inicio e da duração.
	$avisar = $inicio - ($avisar * 86400);		//A mesma logica segue para o dia para avisar do compromisso.
	
	require("includes/conectar_mysql.php"); //Conecta ao banco.
	//A consulta abaixo verifica se há compromissos marcados para este intervalo de tempo.
	$result = mysql_query("SELECT COUNT(cd) FROM compromissos where curso='" . $curso . "' AND turma='" . $turma . "' AND inicio<=" . $inicio . " AND fim>=" . $inicio) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
	$tmp = mysql_fetch_row($result);
	$total = $tmp[0];
	if ($total == 0) { //Caso a contagem de compromissos no intervalo de tempo seja igual a zero então o script prosseguirá com a inclusão no banco de dados das informações do compromisso.
		$query = "INSERT INTO compromissos (tipo, nome, descricao, inicio, fim, dia, mes, ano, email, wap, curso, turma, avisar, avisado) VALUES ('";
		$query .= $tipo . "', '";
		$query .= $nome . "', '";
		$query .= $descricao . "', '";
		$query .= $inicio . "', '";
		$query .= $fim . "', '";
		$query .= $data_dia . "', '";
		$query .= $data_mes . "', '";
		$query .= $data_ano . "', '";
		$query .= $email . "', '";
		$query .= $wap . "', '";
		$query .= $curso . "', '";
		$query .= $turma . "', '";
		$query .= $avisar . "', 'n')";
	
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error()); //Executa a query.
		if($result) $ok = true; //Caso a execução seja completada com suceso a variavel ok fica igual a verdadeiro para mais tarde ser mostrada a mensagem de inclusão com sucesso. 
		require("includes/desconectar_mysql.php"); //Desconecta do banco.
	}
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
		<?php
			if(($modo == "add") && ($ok)) echo("alert('Compromisso Agendado!');"); //Se tudo OK então a mensagem é de compromisso agendado.
			if(($modo == "add") && (!$ok)) echo("alert('Já existe um compromisso agendado nesta data e horário!');"); //Senão a mensagem é de erro.
			for ($i = 0; $i <= sizeof($selects); $i ++){  //Código necessário para os menus de turma e curso.
				echo($selects[$i] . "\n");
			}
		?>
			function muda_turma(){	//Código necessário para os menus de turma e curso.
				var str = new String(compromisso.curso.value);
				var variavel = str.split(" ");
				variavel = variavel.join("_");
				if (variavel.length != 0) eval("selects.innerHTML = " + variavel + ";");
			}
			function valida_form(){		//Validação do formulário antes de submeter as informações para evitar valores em branco.
				f = document.forms[0];
				if ((f.nome.value != "") && (f.descricao.value != "") && (f.curso.value != "") && (f.turma.value != "")){
					f.submit();
				}
				else alert("Todos os campos são obrigatórios!");
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
                <td width="27%" height="70">&nbsp;</td>
                <td width="42%">&nbsp;</td>
                <td width="31%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
					<form name="compromisso" method="post" action="compromisso.php">
                    <tr> 
                      <td width="31%" align="right" class="nomecampo">Tipo:</td>
                      <td width="69%"><select name="tipo" id="tipo">
                          <option value="Confer&ecirc;ncia">Confer&ecirc;ncia</option>
                          <option value="Video-Confer&ecirc;ncia">Video-Confer&ecirc;ncia</option>
                          <option value="Chat">Chat</option>
                          <option value="Outros">Outros</option>
                        </select></td>
                    </tr>
                    <tr> 
                      <td align="right" class="nomecampo">Nome:</td>
                      <td><input type="text" name="nome" class="campotxt"></td>
                    </tr>
                    <tr> 
                      <td align="right" class="nomecampo">Descri&ccedil;&atilde;o:</td>
                      <td> 
                        <textarea name="descricao" rows="2" class="campotxt" id="descricao"></textarea></td>
                    </tr>
                    <tr> 
                      <td align="right" class="nomecampo">Data:</td>
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
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções...
									for($i = 10; $i < 24; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>:
							<select name="horario_minuto">
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>');	//Utilizando o php para economizar digitar todas as opções... :-)
									for($i = 10; $i < 60; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>
						</td>
                    </tr>
                    <tr> 
                      <td align="right" class="nomecampo">Dura&ccedil;&atilde;o:</td>
                      	<td>
							<select name="duracao">
							<?php 	for($i = 1; $i < 4; $i++) echo('<option value="' . $i . '">' . $i . '</option>');	//Utilizando o php para economizar digitar todas as opções... :-)
							?>
							</select><font color="#003399" face="Arial, Helvetica, sans-serif" size="2"><b>&nbsp;horas</b></font>
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
                      <td align="right" class="nomecampo">Curso:</td>
                      <td><?=constroi_select_curso();?></td>
                    </tr>
                    <tr> 
                      <td align="right" class="nomecampo">Turma:</td>
                      <td><div id="selects"></div></td>
                    </tr>
                    <tr> 
                      <td align="right" class="nomecampo">&nbsp;Avisar com</td>
                      <td class="nomecampo">
					  	<select name="avisar">
                        	<?php 	for($i = 1; $i < 11; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); //Utilizando o php para economizar digitar todas as opções... :-) ?>
						</select>
                        dias de anteced&ecirc;ncia.</td>
                    </tr>
                    <tr> 
                      <td align="right"> <input name="incluir" type="button" value=" Agendar " class="botao" onClick="valida_form();"></td>
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