<?php
// Apenas insere este código em HTML para exibir o Titulo da janela que o usuario está, como isto se repetiria em todas as janelas
// foi melhor executa-lo via uma include
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr> 
	  <td width="720" height="24" align="center" bgcolor="#3399FF" style="border-bottom-width: thin; border-bottom-style: solid; border-bottom-color: #0071E1;"><font size="2" face="Arial, Helvetica, sans-serif" color="#66FFFF"><strong><?=$TITULO_PG?></strong></font></td>
	  <td bgcolor="#3399FF" style="border-bottom-width: thin; border-bottom-style: solid; border-bottom-color: #0071E1;"><input name="sair" type="button" id="sair" value="Sair" class="botao" style="width:100%" onClick="javascript: location = 'logout.php';"></td>
	</tr>
</table>