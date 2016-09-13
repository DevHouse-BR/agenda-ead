<?php
#################################################################################
# Este script exibe os dados pessoais do usuário podendo estes serem alterados 	#
# Neste script não há novidades. Há um formulario que envia informações para	#
# este próprio script gravar no banco de dados.									#
#################################################################################

$TITULO_PG = "DADOS PESSOAIS";
$PERMISSAO_DE_ACESSO = "professor/aluno";
require("includes/permissoes.php");

if($_POST["modo"] == "update"){
	require("includes/conectar_mysql.php");
		$query = "UPDATE usuarios SET ";
		$query .= "nome='" . $_POST["nome"] . "', ";
		$query .= "endereco='" . $_POST["endereco"] . "', ";
		$query .= "tel_res='" . $_POST["tel_res"] . "', ";
		$query .= "tel_com='" . $_POST["tel_com"] . "', ";
		$query .= "celular='" . $_POST["celular"] . "', ";
		$query .= "email='" . $_POST["email"] . "', ";
		$query .= "profissao='" . $_POST["profissao"] . "' ";
		$query .= "WHERE cd=" . $_COOKIE["cd_usuario_agenda"];
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		if($result) $ok = true;
	require("includes/desconectar_mysql.php");
}

require("includes/conectar_mysql.php");
	$query = "SELECT * FROM usuarios WHERE cd=" . $_COOKIE["cd_usuario_agenda"];
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
require("includes/desconectar_mysql.php");

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
			<?php if($ok) echo("alert('Dados Gravados com Sucesso!');"); ?>
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
												<tr>
													<td width="50%">
														<table width="70%" border="0" cellspacing="1" cellpadding="1">
															<tr> 
																<td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
																<td width="81%"><input type="text" name="turma" value="<?=$usuario["curso"]?>" disabled></td>
															</tr>
															<tr> 
																<td align="left"><font size="2" face="Arial, Helvetica, sans-serif">Turma:</font></td>
																<td><input type="text" name="turma" value="<?=$usuario["turma"]?>" disabled></td>
															</tr>
														</table>
													</td>
													<td align="right" width="50%">
														<table width="70%" border="0" cellspacing="1" cellpadding="1">
															<tr> 
																<td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Professor:</font></td>
																<td width="81%"><input type="text" name="professor" value="<?=$usuario["professor"]?>" disabled></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										<br>
										</td>
										<td width="4%">&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
										  <tr align="center" bgcolor="#00CCFF"> 
											<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Dados do Aluno</strong></font> </td>
										  </tr>
										  <tr>
											<td align="center">
												<table width="60%" border="0" cellpadding="1" cellspacing="1">
												<form name="form1" action="dados_pessoais.php" method="post">
												<tr> 
												  <td width="20%" align="right" class="nomecampo">Nome: </td>
													<td width="60%"><input type="text" name="nome" class="campotxt" value="<?=$usuario["nome"]?>"></td>
												  </tr>
												  <tr> 
													
												  <td align="right" class="nomecampo">Endereço: </td>
													<td><input type="text" name="endereco" class="campotxt" value="<?=$usuario["endereco"]?>"></td>
												  </tr>
												  <tr> 
													
												  <td align="right" class="nomecampo">Tel. Residêncial: </td>
													<td><input type="text" name="tel_res" class="campotxt" value="<?=$usuario["tel_res"]?>"></td>
												  </tr>
												  <tr> 
													
												  <td align="right" class="nomecampo">Tel. Comercial: </td>
													<td><input type="text" name="tel_com" class="campotxt" value="<?=$usuario["tel_com"]?>"></td>
												  </tr>
												  <tr> 
													
												  <td align="right" class="nomecampo">Celular: </td>
													<td><input type="text" name="celular" class="campotxt" value="<?=$usuario["celular"]?>"></td>
												  </tr>
												  <tr> 
													
												  <td align="right" class="nomecampo">Email: </td>
													<td><input type="text" name="email" class="campotxt" value="<?=$usuario["email"]?>"></td>
												  </tr>
												  <tr> 
												  <td align="right" class="nomecampo">Profissão: </td>
													<td><input type="text" name="profissao" class="campotxt" value="<?=$usuario["profissao"]?>"></td>
												  </tr>
												  <tr> 
												  <td></td>
													<td align="right"><input type="submit" class="botao" value="Salvar"></td>
												  </tr>
												  <input type="hidden" name="modo" value="update">
												  </form>
												</table>
											</td>
										  </tr>
										</table>
										</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td align="center">&nbsp;</td>
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