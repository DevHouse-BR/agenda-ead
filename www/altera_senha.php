<?php
#############################################################
#	Script php que salva no banco de dados a nova senha		#
#	do usuario.												#
#############################################################


$PERMISSAO_DE_ACESSO = "aluno/professor"; 	#tanto alunos como professores podem rodar este script.
require("includes/permissoes.php");			#chama a include de verifica��o de permiss�es.

$cd = $HTTP_COOKIE_VARS["cd_usuario_agenda"];								#Pega o c�digo do usu�rio atrav�s do cookie gravado no mesmo.
$nova_senha = $HTTP_POST_VARS["nova_senha"];									#Pega a nova senha que foi digitada no formul�rio via metodo POST
$confirmacao = $HTTP_POST_VARS["confirmacao"];								#Pega tamb�m a confirma��o da senha.
if (strcmp(trim($usuario["senha"]), trim($senha)) != 0) {			#Compara a senha com a sua comfirma��o.
	header("Location: form_senha.php?status=alerta");				#Se estiverem diferentes ele redireciona o browser para o formulario
	die();															#da senha mostrando uma mensagem de erro e interrompe a execu��o do script com a fun��o die();
}
else{
	$query = "UPDATE usuarios SET ";								#Caso as duas sejam identicas o script monta a frase SQL para gravar no banco de dados a nova senha.
	$query .= "alterar_senha='n', ";
	$query .= "senha='" . $nova_senha ."'";
	$query .= " WHERE cd=" . $cd;

	require("includes/conectar_mysql.php");							#Chama a include que faz a conex�o com o banco de dados (ip, usuario e senha).
	$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error()); #Executa o comando SQL retornando True ou False. Caso n�o consiga vai interromper a execu��o mostrando a mensagem de erro do banco de dados.
	require("includes/desconectar_mysql.php"); 						#Chama a include que desconecta do banco.
?>
<html>
	<head>
		<title>Logout do Sistema</title>
		<script language="JavaScript" type="text/javascript">		//Se a altera��o de senha n�o falhar o script manda este html para notifica��o ao usu�rio.
			setTimeout("finaliza();",2000); 						//Ap�s dois segundos (2000 miliseconds) ser� executado a fun��o finaliza().		
			function finaliza(){									// Esta fun��o simplesmente redireciona o browser para a agenda.
				location = "agenda.php";
			}
		</script>
	</head>
	<body>
		<center><h3>Senha alterada com sucesso!</h3></center>
	</body>
</html>
<?php } ?>