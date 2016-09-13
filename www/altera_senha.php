<?php
#############################################################
#	Script php que salva no banco de dados a nova senha		#
#	do usuario.												#
#############################################################


$PERMISSAO_DE_ACESSO = "aluno/professor"; 	#tanto alunos como professores podem rodar este script.
require("includes/permissoes.php");			#chama a include de verificação de permissões.

$cd = $HTTP_COOKIE_VARS["cd_usuario_agenda"];								#Pega o código do usuário através do cookie gravado no mesmo.
$nova_senha = $HTTP_POST_VARS["nova_senha"];									#Pega a nova senha que foi digitada no formulário via metodo POST
$confirmacao = $HTTP_POST_VARS["confirmacao"];								#Pega também a confirmação da senha.
if (strcmp(trim($usuario["senha"]), trim($senha)) != 0) {			#Compara a senha com a sua comfirmação.
	header("Location: form_senha.php?status=alerta");				#Se estiverem diferentes ele redireciona o browser para o formulario
	die();															#da senha mostrando uma mensagem de erro e interrompe a execução do script com a função die();
}
else{
	$query = "UPDATE usuarios SET ";								#Caso as duas sejam identicas o script monta a frase SQL para gravar no banco de dados a nova senha.
	$query .= "alterar_senha='n', ";
	$query .= "senha='" . $nova_senha ."'";
	$query .= " WHERE cd=" . $cd;

	require("includes/conectar_mysql.php");							#Chama a include que faz a conexão com o banco de dados (ip, usuario e senha).
	$result = mysql_query($query) or die("Erro ao atualizar registros no Banco de dados: " . mysql_error()); #Executa o comando SQL retornando True ou False. Caso não consiga vai interromper a execução mostrando a mensagem de erro do banco de dados.
	require("includes/desconectar_mysql.php"); 						#Chama a include que desconecta do banco.
?>
<html>
	<head>
		<title>Logout do Sistema</title>
		<script language="JavaScript" type="text/javascript">		//Se a alteração de senha não falhar o script manda este html para notificação ao usuário.
			setTimeout("finaliza();",2000); 						//Após dois segundos (2000 miliseconds) será executado a função finaliza().		
			function finaliza(){									// Esta função simplesmente redireciona o browser para a agenda.
				location = "agenda.php";
			}
		</script>
	</head>
	<body>
		<center><h3>Senha alterada com sucesso!</h3></center>
	</body>
</html>
<?php } ?>