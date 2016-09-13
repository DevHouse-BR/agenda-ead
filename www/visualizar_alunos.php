<?php
//Este script contém a tabela_alunos.php e serve para passar o parâmetro do curso e turma selecionados para
//o script tabela_alunos.php.

$PERMISSAO_DE_ACESSO = "professor";
require("includes/permissoes.php");

$TITULO_PG = "ALUNOS POR CURSO E TURMA";
require("includes/selects_turmas_cursos.php");
constroi_select_turmas('onChange=\\"escolhe_turma()\\"'); 	//Cada vez que o usuario escolhe uma turma de um determinado curso é 
															//executada a função escolhe_turma() que passa os parâmetros para a tabela alunos.
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
		<script language="JavaScript">
			<?php
				for ($i = 0; $i <= sizeof($selects); $i ++){
					echo($selects[$i] . "\n");
				}
			?>
			function muda_turma(){
				var str = new String(form1.curso.value);
				var variavel = str.split(" ");
				variavel = variavel.join("_");
				if (variavel.length != 0) eval("selects.innerHTML = " + variavel + ";");
			}
			function escolhe_turma(){ //Passa as informações para a tabela de alunos. A novidade aqui é a utilização da função javascript escape que tem a mesma função da função em PHP urlencode();
				viz.location = 'tabela_alunos.php?curso=' + escape(form1.curso.value) + '&turma=' + escape(form1.turma.value);
			}
		</script>
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
                <td width="92%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                      <td align="right">
						<table width="40%" border="0" cellspacing="1" cellpadding="1">
							<form name="form1">
                          <tr> 
                            <td width="19%" align="left"><font size="2" face="Arial, Helvetica, sans-serif">Curso:</font></td>
                            <td width="81%"><?=constroi_select_curso();?></td>
                          </tr>
                          <tr> 
                            <td align="left"><font size="2" face="Arial, Helvetica, sans-serif">Turma:</font></td>
                            <td><div id="selects"></div></td>
                          </tr>
						  </form>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td width="4%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><iframe width="100%" id="viz" frameborder="0" height="260" src="tabela_alunos.php"></iframe></td>
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