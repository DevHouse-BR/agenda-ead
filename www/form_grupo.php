<?php
#########################################################################################
# Este é o formulário que trata a criação e edição das informações de um novo grupo.	#
#########################################################################################

$PERMISSAO_DE_ACESSO = "aluno/professor";		//Permissões
require("includes/permissoes.php");

$turma = urldecode( $HTTP_GET_VARS["turma"]);		//os parâmetros enviados para este script são pela url 
$curso = urldecode( $HTTP_GET_VARS["curso"]);		//mas como nome de curso e turma podem conter caracteres não permitidos então são utilizadas as funções urlencode() de urldecode().
$modo =  $HTTP_GET_VARS["modo"];
$executar = $HTTP_POST_VARS["executar"];
if($HTTP_GET_VARS["cd"] == "")	$cd = $HTTP_POST_VARS["cd"];
else $cd = $HTTP_GET_VARS["cd"];
$ok = false;
$filtro_sql = " WHERE tipo='aluno' AND curso='" . $curso . "' AND turma='" . $turma . "'";
// A variável filtro_sql gera a condição para que sejam mostrados os alunos do curso e turma desejados.

if($modo == ""){ //Caso a variavel modo esteja em branco significa que o script executara em modo de formulário para digitação das informações do novo grupo.
	if(($turma == "") || ($curso == "")){ //Caso não tenha sido informado um curso e uma turma no script cadastro_grupo.php a execução deste script será interrompida e ele mostrará uma mensagem.
		die('<html>
				<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
					<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
					  <tr align="center" bgcolor="#00CCFF"> 
						<td colspan="3"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Selecione um Curso e uma Turma</strong></font></p></td>
					  </tr>
					</table>
				</body>
			</html>');
	}
	
	//Caso a condição acima seja falsa, o script não será interrompido e continuará abaixo: primeiro checando se já existem alunos cadastrados para o curso e turma selecionados.
	require("includes/conectar_mysql.php");
	$result = mysql_query("SELECT COUNT(cd) FROM usuarios" . $filtro_sql) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());	
	$tmp = mysql_fetch_row($result);
	$total = $tmp[0];
	require("includes/desconectar_mysql.php");
	//Caso o total de alunos seja zero o script será interrompido exibindo a mensagem de erro.
	if ($total == 0) die('<html>
							<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
								<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
								  <tr align="center" bgcolor="#00CCFF"> 
									<td colspan="3"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Ainda não existem alunos cadastrados nesta turma!</strong></font></p></td>
								  </tr>
								</table>
							</body>
						</html>');

}
//O Código abaixo só será executado com o script em modo "salva" que vai receber os valores digitados e armazená-los no banco de dados.
if($modo == "salva"){
	$nome = $HTTP_POST_VARS["nome"];
	$curso = $HTTP_POST_VARS["curso"];
	$turma = $HTTP_POST_VARS["turma"];
	$professor = $HTTP_POST_VARS["professor"];
	$integrantes = $HTTP_POST_VARS["integrantes"];

	if ($executar == "add")	{ //Caso seja um novo grupo.
		$query = "INSERT INTO grupos (nome, cd_criador, curso, turma, professor) VALUES ('";
		$query .= $nome ."','";
		$query .= $HTTP_COOKIE_VARS["cd_usuario_agenda"] ."','";
		$query .= $curso ."','";
		$query .= $turma ."','";
		$query .= $professor ."')";
	}
	if ($executar == "update"){  //Caso esteja alterando um grupo existente.
		$query = "UPDATE grupos SET ";
		$query .= "nome='" . $nome ."', ";
		$query .= "curso='" . $curso ."', ";
		$query .= "turma='" . $turma ."', ";
		$query .= "professor='" . $professor ."'";
		$query .= " WHERE cd='" . $cd . "'";
		$modo = "update";
	}
	require("includes/conectar_mysql.php"); //Executa ou a inserção ou a alteração.
		$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
		if($result) $ok = true;
	require("includes/desconectar_mysql.php");
	
	//No banco de dados as informações de um grupo ficam armazenadas um duas tabelas diferentes. A tabela grupos guarda o nome, curso e turma do grupo
	//a tabela grupos_integrantes guarda o nome do grupo para cada código do seu integrante.
	//O código abaixo serve para gravar as informações na tabela grupos_integrantes. Quando é feito o update, primeiro são removidos todos
	//os integrantes da tabela para depois inseri-los novamente (facilita a programação);

	if($executar == "add"){ 
		require("includes/conectar_mysql.php");
		for($i = 0; $i < count($integrantes); $i++){
			$result = mysql_query("INSERT INTO grupos_integrantes (nome_grupo, cd_integrante) VALUES ('". $nome . "', '" . $integrantes[$i] . "')") or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
		}
		require("includes/desconectar_mysql.php");
	}
	if($executar == "update"){
		require("includes/conectar_mysql.php");
		$result = mysql_query("DELETE FROM grupos_integrantes WHERE nome_grupo='" . $nome . "'") or die("Erro ao apagar registros no Banco de dados: " . mysql_error());
		$integrantes = array_unique($integrantes);
		for($i = 0; $i < count($integrantes) +1; $i++){
			if ($integrantes[$i] != 0){
				$result = mysql_query("INSERT INTO grupos_integrantes (nome_grupo, cd_integrante) VALUES ('". $nome . "', '" . $integrantes[$i] . "')") or die("Erro ao atualizar registros no Banco de dados: " . mysql_error());
			}
		}
		require("includes/desconectar_mysql.php");
	}
}

//Este código abaixo roda quando foi selecionado um grupo para ser modificado. Então ele busca no banco o grupo que tem o código passado
//por parâmetro ao script.
if($modo == "update"){
	require("includes/conectar_mysql.php");
		$query = "SELECT * FROM grupos where cd=" . $cd;
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$grupo = mysql_fetch_array($result, MYSQL_ASSOC);
	require("includes/desconectar_mysql.php");
}

if($modo == "apagar"){
	require("includes/conectar_mysql.php");
		$query = "DELETE FROM grupos where cd=" . $cd;
		$result_apagar = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$query = "DELETE FROM grupos_integrantes where nome_grupo='" .  $HTTP_GET_VARS["grupo"] . "'";
		$result_apagar = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	require("includes/desconectar_mysql.php");
	die('<html><head><script language="javascript">parent.location = "visualizar_grupos.php";</script></head></html>');
}
?>
<html>
<head>
<title>Tabela Turma</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.tabela {
	border-top: 1px solid #0099FF;
	border-right: 1px solid #0066FF;
	border-bottom: 1px solid #0066FF;
	border-left: 1px solid #0099FF;
}
.nomecampo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #003399;
}
body {
	scrollbar-Track-Color: white;
	scrollbar-Face-Color: #99CCFF;
	scrollbar-Arrow-Color: #5555FF;
	scrollbar-3dLight-Color: white;
	scrollbar-Highlight-Color: white;
	scrollbar-Shadow-Color: white;
	scrollbar-DarkShadow-Color: white;
}
@import url("includes/estilo.css");
-->
</style>
<script language="JavaScript">
	function valida_form(){
		var f = form_grupo;
		if ((f.nome.value != "") && (parent.form1.curso.value != "") && (parent.form1.turma.value != "") && (parent.form1.professor.value != "")){
			f.curso.value = parent.form1.curso.value;
			f.turma.value = parent.form1.turma.value;
			f.professor.value = parent.form1.professor.value;
			var integrantes = document.forms[0].elements['integrantes[]'];
			for(var i = 0; i < integrantes.options.length; i++) integrantes.options[i].selected = true;
			f.action = "form_grupo.php?modo=salva&curso=<?=urlencode($curso)?>&turma=<?=urlencode($turma)?>" ;
			f.submit();
		}
		else alert("Preencha todos os campos!");
	}
	function adiciona_ao_grupo(){ //Função tira um nome de aluno de uma caixa para a outra.
		var f = form_grupo;
		var integrantes = document.forms[0].elements['integrantes[]'];
		if(integrantes.options.length < 5){
			for(var i = 0; i < f.alunos.options.length; i++){
				if(f.alunos.options[i].selected){
					if(integrantes.options.length < 5){
						var opcao = document.createElement("OPTION");
						opcao.text = f.alunos.options[i].text;
						opcao.value = f.alunos.options[i].value;
						integrantes.options.add(opcao);
						f.alunos.options.remove(i);
						i = -1;
					}
				}
			}
		}
		else alert("São permitidos apenas 5 integrantes por grupo!");
	}
	function remove_do_grupo(){ //Função tira um nome de aluno de uma caixa para a outra.
		var f = form_grupo;
		var integrantes = document.forms[0].elements['integrantes[]'];
		for(var i = 0; i < integrantes.options.length; i++){
			if(integrantes.options[i].selected){
				var opcao = document.createElement("OPTION");
				opcao.text = integrantes.options[i].text;
				opcao.value = integrantes.options[i].value;
				f.alunos.options.add(opcao);
				integrantes.options.remove(i);
				i = -1;
			}
		}
	}
	<?php if($modo == "update"){ ?>
		function apagar(){
			if(confirm("Deseja apagar o grupo?")){
				location = "form_grupo.php?modo=apagar&cd=<?=$cd?>&grupo=<?=$grupo["nome"]?>";
			}
		}
	<? } ?>
</script>
<?php 
if($ok){ ?>
	<script language="JavaScript">
		alert("Dados Gravados com Sucesso!");
	</script>
<? } ?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="tabela">
  <tr align="center" bgcolor="#00CCFF"> 
    <td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Criação de Grupos de Trabalho</strong></font> </td>
  </tr>
  <tr>
  	<td align="center">
		<table width="60%" border="0" cellpadding="1" cellspacing="1">
        <form name="form_grupo" method="post">
          <tr> 
            <td width="20%" align="right" class="nomecampo">Nome do Grupo: </td>
            <td width="60%"><input type="text" name="nome" class="campotxt" <?php if($modo == "update") echo("value=\"". $grupo["nome"] . "\""); ?>></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"><br>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td width="45%" align="center" class="nomecampo">Alunos</td>
					  <td width="10%">&nbsp;</td>
					  <td width="45%" align="center" class="nomecampo">Integrantes do Grupo</td>
					</tr>
					<tr>
					  <td>
					  	<select size="6" class="campotxt" name="alunos" multiple>
							<?php //Monta a lista dos alunos da curso e turma especificados.
								require("includes/conectar_mysql.php");
								$result = mysql_query("SELECT cd, nome FROM usuarios" . $filtro_sql . "order by nome") or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
								while($aluno = mysql_fetch_array($result, MYSQL_ASSOC)) echo('<option value=' . $aluno["cd"] . '>' . $aluno["nome"] . '</option>');
								require("includes/desconectar_mysql.php");
							?>
						</select>
					 </td>
					  
                  <td align="center" valign="middle"><img src="img/seta2.gif" onMouseDown="src='img/seta3.gif'" onMouseUp="src='img/seta2.gif'; adiciona_ao_grupo();"><br><img src="img/seta4.gif" onMouseDown="src='img/seta5.gif'" onMouseUp="src='img/seta4.gif'; remove_do_grupo();"></td>
					  <td><select size="6" class="campotxt" name="integrantes[]" multiple>
					  		<?php //Monta a lista dos integrantes já cadastrados neste grupo. (somente em modo update).
								if($modo == "update"){
									require("includes/conectar_mysql.php");
									$query = "SELECT cd_integrante FROM grupos_integrantes WHERE nome_grupo='" . $grupo["nome"] . "'";
									$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
									while($integrante = mysql_fetch_array($result, MYSQL_ASSOC)){
										$query = "SELECT nome, email FROM usuarios WHERE cd=" . $integrante["cd_integrante"];
										$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
										while($aluno = mysql_fetch_array($result2, MYSQL_ASSOC)){
											echo('<option value=' . $integrante["cd_integrante"] . '>' . $aluno["nome"] . '</option>');
										}
									}
									require("includes/desconectar_mysql.php");
								}
							?>
						</select></td>
					</tr>
				  </table>
			  </td>
          </tr>
          <tr> 
            <td></td>
            <td align="right"><input name="cancelar" <?php if ($modo == "update") echo('value="Apagar" type="button" onclick="javascript: apagar();"'); else echo('type="reset" value="Cancelar"'); ?> class="botao" style="width:25%">&nbsp;<input name="incluir" type="button" value="<?php if($modo == "update") echo("Salvar"); else echo("Incluir"); ?>" class="botao" style="width:25%" onClick="valida_form();"></td>
          </tr>
          <input type="hidden" name="cd" <?php if($modo == "update") echo("value=\"". $grupo["cd"] . "\""); ?>>
          <input type="hidden" name="curso" <?php if($modo == "update") echo("value=\"". $grupo["curso"] . "\""); ?>>
          <input type="hidden" name="professor" <?php if($modo == "update") echo("value=\"". $grupo["professor"] . "\""); ?>>
          <input type="hidden" name="turma" <?php if($modo == "update") echo("value=\"". $grupo["turma"] . "\""); ?>>
          <input type="hidden" name="executar" <?php if($modo == "update") echo("value=\"update\""); else echo("value=\"add\"");?>>
        </form>
      </table>
	</td>
  </tr>
</table>
</body>
</html>
