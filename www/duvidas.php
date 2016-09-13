<?php
####################################################################
#	Este script não foi escrito, é uma cópia da lista de contatos. #
####################################################################

$PERMISSAO_DE_ACESSO = "professor";
require("includes/permissoes.php");

$TITULO_PG = "LISTA DE CONTATOS";
?>
<html>
	<head>
		<title>Bem Vindo &agrave; Agenda Eletr&ocirc;nica!</title>
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
				<td align="center" valign="middle"><?php require("includes/menuhorizontal.php"); ?>
					<table width="775" border="0" cellpadding="0" cellspacing="0" class="janela">
						<tr>
							<td colspan="2" align="center"><?php require("includes/barra_titulo.php"); ?></td>
						</tr>
        <tr> 
          <td colspan="2" valign="middle"><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="92%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </td>
                <td width="4%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><iframe width="100%" id="viz" frameborder="0" height="260" src="tabela_links.php"></iframe></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table> </td>
        </tr>
      </table> 
				</td>
			</tr>
		</table>
	</body>
</html>