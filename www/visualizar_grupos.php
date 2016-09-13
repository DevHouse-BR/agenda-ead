<?php
//Este script chama as includes de menu e título e contém a tabela de grupos.

$TITULO_PG = "GRUPOS";
$PERMISSAO_DE_ACESSO = "aluno/professor";
require("includes/permissoes.php");
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Virtual!</title>
		<style type="text/css">
			@import url("includes/estilo.css");
			select {
				font-family: Arial, Helvetica, sans-serif;
				font-size: 12px;
			}
		</style>
		<script language="JavaScript" src="includes/menuhorizontal.js"></script>
	</head>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0">
			<tr>
				<td align="center" valign="middle">
				<?php require("includes/menuhorizontal.php"); ?>
					<table width="775" height="383" border="0" cellpadding="0" cellspacing="0" class="janela">
<tr>
							<td colspan="2" align="center"><?php require("includes/barra_titulo.php"); ?></td>
						</tr>
        <tr> 
          <td colspan="2" valign="top">
		  	<table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr> 
                <td width="4%">&nbsp;</td>
                <td width="92%"><br><iframe width="100%" frameborder="0" height="300" src="tabela_grupos.php"></iframe></td>
                <td width="4%">&nbsp;</td>
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