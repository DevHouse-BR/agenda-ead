<?php

# Este Script é muito parecido com o script de compromisso só que com algumas particularidades. Ele não verifica a existência de outras
# Atividades agendadas para o mesmo horário.

$TITULO_PG = "EVENTO";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

if($_POST["modo"] == "add"){
	$categoria = "evento";
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
	$local = $_POST["local"];
	$avisar = $_POST["avisar"];
	
	if($email == true) $email = "s";
	else $email = "n";
	
	if($wap == true) $wap = "s";
	else $wap = "n";
	
	$inicio = mktime($horario_hora, $horario_minuto, 0, $data_mes, $data_dia, $data_ano);
	$fim = $inicio + (($duracao * 60) * 60);
	$avisar = $inicio - ($avisar * 86400);
		
	$query = "INSERT INTO eventos (tipo, nome, descricao, inicio, fim, dia, mes, ano, email, wap, avisar, local, avisado) VALUES ('";
	$query .= $tipo ."','";
	$query .= $nome ."','";
	$query .= $descricao ."','";
	$query .= $inicio ."','";
	$query .= $fim ."','";
	$query .= $data_dia ."','";
	$query .= $data_mes ."','";
	$query .= $data_ano ."','";
	$query .= $email ."','";
	$query .= $wap ."','";
	$query .= $avisar ."','";
	$query .= $local . "', 'n')";

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
			<?php if($ok) echo("alert('Evento agendado!');"); ?>
			function valida_form(){
				f = document.forms[0];
				if ((f.nome.value != "") && (f.descricao.value != "") && (f.data.value != "") && (f.local.value != "")){
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
					<form name="evento" method="post" action="evento.php">
                    <tr> 
                      <td width="31%" align="right" class="nomecampo">Tipo:</td>
                      <td width="69%"><select name="tipo" id="tipo">
                          <option value="Palestra">Palestra</option>
                          <option value="Reunião">Reunião</option>
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
                      <td align="right" class="nomecampo">Local:</td>
                      <td><input type="text" name="local" class="campotxt"></td>
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
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>');
									for($i = 10; $i < 25; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>:
							<select name="horario_minuto">
							<?php 	for($i = 0; $i < 10; $i++) echo('<option value="' . $i . '">0' . $i . '</option>');
									for($i = 10; $i < 60; $i++) echo('<option value="' . $i . '">' . $i . '</option>'); ?>
							</select>
						</td>
                    </tr>
					<tr> 
                      <td align="right" class="nomecampo">Dura&ccedil;&atilde;o:</td>
                      	<td>
							<select name="duracao">
							<?php 	for($i = 1; $i < 4; $i++) echo('<option value="' . $i . '">' . $i . '</option>');
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
                      <td align="right" class="nomecampo">&nbsp;Avisar com</td>
                      <td class="nomecampo">
					  	<select name="avisar">
                        	<?php 	for($i = 1; $i < 11; $i++) echo('<option value="' . $i . '">' . $i . '</option>');?>
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