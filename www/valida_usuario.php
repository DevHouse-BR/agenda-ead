<?php

#Este script exerce uma fun��o muito importante dentro do sistema. Ele recebe o nome de usuario e senha digitados no
#script index.php e busca no banco de dados estas informa��es. Caso estejam corretas ele grava no browser do usu�rio
#cookies contendo informa��es necess�rias para o funcionamento do sistema.

#Outra fun��o importante deste script � pesquisar no banco de dados a exist�ncia de usu�rios cadastrados.
#Caso o sistema esteja sendo implementado, o banco de dados vai estar vazio ent�o o sistema permite a entrada de um usu�rio
#sem senha e com permiss�es apenas para cadastrar professores.


$login = $HTTP_POST_VARS["usuario"];	//Recebe as informa��es digitadas
$senha = $HTTP_POST_VARS["senha"];

require("includes/conectar_mysql.php");
	$query = "SELECT COUNT(*) FROM usuarios"; //Faz a contagem para verificar a existencia de usuarios cadastrados.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$qtd = mysql_fetch_row($result);
	
	if ($qtd[0] != 0){ //Caso existam usuarios cadastrados:
		//Busca no banco de dados as informa��es do usuario com o nome de usuario digitado no formul�rio.
		$query = "SELECT cd, nome, email, senha, tipo, alterar_senha FROM usuarios WHERE (email='" . $login . "')";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if(($usuario == false) || (strcmp(trim($usuario["senha"]), trim($senha)) != 0)){ //A fun��o strcmp() compara strings e a fun��o trim remove espa�os em branco no come�o ou no final da string.
			//Caso n�o exista usuario com este nome (email) ou a senha digitada seja diferente da senha contida no banco ent�o:
			header("Location: index.php?status=erro1"); //Redireciona o browser para o formulario de login novamente s� que agora informa ao formul�rio que ele deve mostar a mensagem de erro.
			die(); //Finaliza a execu��o do script
		}
		else { //Se n�o, ou seja, se o usu�rio exista e sua senha esteja correta ent�o � feita a verifica��o se � o primeiro login deste usuario (campo da tabela "alterar_senha" = "s")
			if ($usuario["alterar_senha"] == "s") novo_usuario();
			else valida();
		}
	}
	else valida_root(); //Caso n�o existam usuarios cadastrados no sistema a fun��o valida root possibilita que um usuario com permiss�es
						//para cadastrar professores seja logado no sistema.
	
require("includes/desconectar_mysql.php");

function valida(){
	global $usuario; //Determina que a vari�vel $usuario deve ser lida do escopo global.
	//O codigo abaixo seta os cookies com as informa��es necess�rias para o funcionamento do software ou ent�o interrompe o processamento exibingo uma mensagem de erro.
	if(!setcookie("cd_usuario_agenda", $usuario["cd"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("nome_usuario_agenda", $usuario["nome"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("tipo_usuario_agenda", $usuario["tipo"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("email_usuario_agenda", $usuario["email"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	redirect("agenda.php", $usuario["nome"]);
}
function valida_root(){
	if(!setcookie("cd_usuario_agenda", "0")) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("nome_usuario_agenda", "root")) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("tipo_usuario_agenda", "root")) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	redirect("cadastro_professores.php", "root");
}
function novo_usuario(){
	global $usuario;
	if(!setcookie("cd_usuario_agenda", $usuario["cd"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("nome_usuario_agenda", $usuario["nome"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("tipo_usuario_agenda", $usuario["tipo"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("email_usuario_agenda", $usuario["email"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	redirect("form_senha1.php", $usuario["nome"]);
}
function redirect($pagina, $nomeusuario){
	$html = '<html>
				<head>
					<script language="JavaScript">
						window.open("' . $pagina . '", "Agenda", "width=781,height=415,status=yes,resizable=yes,top=20,left=100,dependent=yes,alwaysRaised=yes");
					</script>
				</head>
				<body>
					<center><h3>Bem Vindo � Agenda CAD ' . $nomeusuario . '</h3></center>
				</body>
			</html>';
	die($html);
}
?>