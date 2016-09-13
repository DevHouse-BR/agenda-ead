<?php
	if ($HTTP_COOKIE_VARS["tipo_usuario_agenda"] == "professor") $prof = true;
?>
<html>
	<head>
		<title>D�vidas</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<style type="text/css">
			@import url("includes/estilo.css");
		</style>
	</head>
	<body>
		<table width="100%">
			<tr>
				<td align="center" valign="top">
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Agenda</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Trata-se do item inicial e um dos principais, pois atrav�s deste pode-se visualizar todas as atividades agendadas atrav�s de um Calend�rio interativo.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Visualizar: Visualizar o calend�rio e ap�s intera��o do usu�rio mostrar as atividades agendadas e tamb�m o detalhamento destas. Existem tr�s tipos de visualiza��es: Di�ria (clicar no dia), Semanal (clicar no �cone em forma de seta) e Mensal (clicar no m�s).<br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Fechar: Sair do sistema Agenda.</td>
						</tr>
					</table>
					<?php if($prof){ ?>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Cursos</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Pertinente aos cadastros que devem ser feitos na Agenda e tamb�m para visualiza��o dos mesmos.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Cursos: Cadastrar os Cursos na Agenda que ser�o ministrados no AVE. Este � o primeiro cadastro que deve ser feito. <br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Turmas: Cadastrar as turmas de acordo com os Cursos.</td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Novo Professor: Cadastrar os professores na Agenda preenchendo o formul�rio.</td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Professores: Visualizar os professores cadastrados na Agenda. Ao clicar em um dos nomes dos professores � poss�vel fazer altera��es necess�rias.</td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Novo Aluno: Cadastrar os alunos na Agenda de acordo com um curso e turma selecionados e informar o professor (caso quem esteja cadastrando n�o seja o professor desejado) e preencher o formul�rio.</td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Alunos: Visualizar os alunos cadastrados na Agenda de acordo com o curso e turma selecionados. Ao clicar em um dos nomes dos alunos � poss�vel fazer altera��es necess�rias.</td>
						</tr>
					</table>
					<? } ?>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Grupos</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Formar grupos para desenvolver atividades onde se queira dividir a turma e formar grupos de trabalho, para que atrav�s da atividade Tarefa (comentada adiante) possa-se desenvolver trabalhos pertinentes ao desenvolvimento do Curso.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Visualizar: Visualizar os grupos cadastrados na Agenda. Ao clicar em um dos nomes dos grupos � poss�vel fazer altera��es necess�rias (salientando que s� quem criou o grupo que pode fazer altera��es).<br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Novo Grupo: Cadastrar os grupos na Agenda de acordo com um curso e turma selecionados, informar o professor (caso quem esteja cadastrando n�o seja o professor desejado), dar um nome ao grupo e selecionar os alunos que ser�o integrantes do grupo.</td>
						</tr>
					</table>
					<?php if($prof){ ?>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Atividades</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Serve para o agendamento das Atividades dos Cursos, sendo que h� distin��o entre estas, com o objetivo de envolver as informa��es necess�rias e fazer uma organiza��o das diferentes atividades que podem decorrer durante o Curso.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Compromisso: trata-se de uma atividade obrigat�ria no Curso. Possibilita que professores e alunos se comuniquem em tempo real estando em lugares diferentes. Se distingue das outras atividades por ter um hor�rio pr�-estabelecido para acontecer numa determinada data e uma dura��o para n�o interferir em outro compromisso.<br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Tarefa: trata-se de uma atividade que deve ser realizada, tendo um prazo m�ximo para ser conclu�do e entregue. A tarefa � um trabalho estabelecido no Curso que pode ser realizado por um grupo de trabalho formado pelo professor ou pelos alunos, se assim o professor preferir.</td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Evento: trata-se de uma atividade que se queira divulgar. O evento � um acontecimento em rela��o a qualquer coisa que se deseje informar aos interessados para que possam participar se quiserem.</td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Mensagem: trata-se de uma op��o referente ao cancelamento de alguma das atividades j� agendada, que comunica aos interessados que determinada atividade n�o poder� acontecer.</td>
						</tr>
					</table>
					<? } ?>
					<?php if(!$prof){ ?>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Tarefa</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Serve para o agendamento das tarefas que devem ser desenvolvidas no Curso para que os alunos possam dividir o trabalho em partes entre o seu grupo. </td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Tarefa: trata-se de uma atividade que deve ser realizada, tendo um prazo m�ximo para ser conclu�do e entregue. A tarefa � um trabalho estabelecido no Curso que pode ser realizado por um grupo de trabalho formado pelo professor ou pelos alunos, se assim o professor preferir.<br></td>
						</tr>
					</table>
					<? } ?>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Dados Pessoais</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Disponibilizar as informa��es referentes ao usu�rio da Agenda para que este possa alterar alguma destas informa��es, caso necess�rio, e tamb�m possa trocar a senha.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Visualizar: Visualizar as informa��es cadastradas do usu�rio para que este possa consult�-las ou alter�-las, caso necess�rio.<br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Alterar Senha: Trocar a senha, caso o usu�rio desejar.</td>
						</tr>
					</table>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Contatos</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Anotar e-mails para que fique registrado, caso necessite consultar mais tarde, n�o precisando usar a velha agenda de papel, pois al�m de tratar-se de uma agenda para ensino tamb�m serve como agenda pessoal.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Visualizar: Visualizar os contatos j� registrados e/ou alter�-los.<br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Novo Contato: Inserir contatos.</td>
						</tr>
					</table>
					<br><br>
					<table width="90%" class="campotxt2">
						<tr>
							<td bgcolor="#3399FF" colspan="3" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Links</strong></font></td>
						</tr>
						<tr>
							<td colspan="3"><br>Anotar links interessantes ou importantes para o Curso que devem ser lembrados para mais tarde serem consultados.</td>
						</tr>
						<tr>
							<td><br>Op��es:</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Visualizar: Visualizar os links j� registrados e/ou alter�-los.<br></td>
						</tr>
						<tr>
							<td></td>
							<td valign="top"><img src="img/seta_cal.gif"></td>
							<td>Novo Link: Inserir links.</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
