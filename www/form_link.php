<?php

//Formulario para inserção, modificação e remoção de um link.

$TITULO_PG = "EDITAR LINK";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");

if($HTTP_GET_VARS["modo"] == "")	$modo = $HTTP_POST_VARS["modo"];
else $modo = $HTTP_GET_VARS["modo"];

$executar = $HTTP_POST_VARS["executar"];
if($HTTP_GET_VARS["cd"] == "")	$cd = $HTTP_POST_VARS["cd"];
else $cd = $HTTP_GET_VARS["cd"];

if($modo == "salvar"){
	$nome = $HTTP_POST_VARS["nome"];
	$descricao = $HTTP_POST_VARS["descricao"];
	$link = $HTTP_POST_VARS["link"];
	
	if($executar == "inserir"){
		$query = "INSERT INTO links (dono, nome, descricao, link) VALUES ('";
		$query .= $HTTP_COOKIE_VARS["cd_usuario_agenda"] ."','";
		$query .= $nome ."','";
		$query .= $descricao ."','";
		$query .= $link ."')";
	}
	
	if($executar == "update"){
		$query = "UPDATE links SET ";
		$query .= "nome='" . $nome ."', ";
		$query .= "descricao='" . $descricao ."', ";
		$query .= "link='" . $link ."'";
		$query .= " WHERE cd=" . $cd;
	}
	require("includes/conectar_mysql.php");
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
		if($result) $ok = true;
	require("includes/desconectar_mysql.php");
}
if($modo == "update"){
	require("includes/conectar_mysql.php");
		$result = mysql_query("SELECT * FROM links WHERE cd=" . $cd) or die("Erro ao Ler registros do Banco de dados: " . mysql_error());
		$link = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
}
if($modo == "apagar"){
	require("includes/conectar_mysql.php");
		$result = mysql_query("DELETE FROM links WHERE cd=" . $cd) or die("Erro ao Ler registros do Banco de dados: " . mysql_error());
	require("includes/desconectar_mysql.php");
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
			<?php if(($ok)) echo('alert("Link Gravado!");') ;
				if(($modo == "apagar") && ($result)){
					echo('alert("Link Apagado!");');
					echo("location = 'visualizar_links.php';");
				}
			?>
			function valida_form(){
				var f = document.forms[0];
				if((f.nome.value != "") && (f.link.value != "")){
					f.submit();
				}
				else alert("Nome e Link são campos obrigatórios!");
			}
			function apaga(){
				location = "form_link.php?modo=apagar&cd=<?=$cd?>";
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
                <td width="15%" height="70">&nbsp;</td>
                <td width="70%">&nbsp;</td>
                <td width="15%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                    <form method="post" action="form_link.php">
                      <tr> 
                        <td width="13%" align="right" class="nomecampo">Nome:</td>
                        <td width="87%"><input type="text" name="nome" class="campotxt" <?php if($modo == "update") echo('value="' . $link["nome"] . '"');?>></td>
                      </tr>
					  <tr> 
                        <td align="right" class="nomecampo">Link:</td>
                        <td><input type="text" name="link" class="campotxt"<?php if($modo == "update") echo('value="' . $link["link"] . '"');?>></td>
                      </tr>
                      <tr> 
                        <td align="right" valign="top" class="nomecampo">Descrição:</td>
                        <td><textarea name="descricao" class="campotxt" rows="10"><?php if($modo == "update") echo($link["descricao"]);?></textarea></td>
                      </tr>
                      <tr> 
                        <td align="right">&nbsp;</td>
                        <td align="right">
							<?php if($modo == "update") echo('<input name="apagar" type="button" value="Apagar" class="botao" onClick="apaga();">');?>
                          <input name="incluir" type="button" value="Salvar" class="botao" onClick="valida_form();">
                        </td>
                      </tr>
					  <input type="hidden" name="cd" value="<?=$cd?>">
                      <input type="hidden" name="modo" <?php if($modo == "update") echo('value="salvar"'); else echo('value="salvar"');?>>
					  <input type="hidden" name="executar" <?php if($modo == "update") echo('value="update"'); else echo('value="inserir"');?>>
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