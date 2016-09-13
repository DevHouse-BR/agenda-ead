<?php

#Este script exerce uma função muito importante dentro do sistema. Ele recebe o nome de usuario e senha digitados no
#script index.php e busca no banco de dados estas informações. Caso estejam corretas ele grava no browser do usuário
#cookies contendo informações necessárias para o funcionamento do sistema.

#Outra função importante deste script é pesquisar no banco de dados a existência de usuários cadastrados.
#Caso o sistema esteja sendo implementado, o banco de dados vai estar vazio então o sistema permite a entrada de um usuário
#sem senha e com permissões apenas para cadastrar professores.


$login = $HTTP_POST_VARS["usuario"];	//Recebe as informações digitadas
$senha = $HTTP_POST_VARS["senha"];

require("includes/conectar_mysql.php");
	$query = "SELECT COUNT(*) FROM usuarios"; //Faz a contagem para verificar a existencia de usuarios cadastrados.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$qtd = mysql_fetch_row($result);
	
	if ($qtd[0] != 0){ //Caso existam usuarios cadastrados:
		//Busca no banco de dados as informações do usuario com o nome de usuario digitado no formulário.
		$query = "SELECT cd, nome, email, senha, tipo, alterar_senha FROM usuarios WHERE (email='" . $login . "')";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if(($usuario == false) || (strcmp(trim($usuario["senha"]), trim($senha)) != 0)){ //A função strcmp() compara strings e a função trim remove espaços em branco no começo ou no final da string.
			//Caso não exista usuario com este nome (email) ou a senha digitada seja diferente da senha contida no banco então:
			header("Location: index.php?status=erro1"); //Redireciona o browser para o formulario de login novamente só que agora informa ao formulário que ele deve mostar a mensagem de erro.
			die(); //Finaliza a execução do script
		}
		else { //Se não, ou seja, se o usuário exista e sua senha esteja correta então é feita a verificação se é o primeiro login deste usuario (campo da tabela "alterar_senha" = "s")
			if ($usuario["alterar_senha"] == "s") novo_usuario();
			else valida();
		}
	}
	else valida_root(); //Caso não existam usuarios cadastrados no sistema a função valida root possibilita que um usuario com permissões
						//para cadastrar professores seja logado no sistema.
	
require("includes/desconectar_mysql.php");

function valida(){
	global $usuario; //Determina que a variável $usuario deve ser lida do escopo global.
	//O codigo abaixo seta os cookies com as informações necessárias para o funcionamento do software ou então interrompe o processamento exibingo uma mensagem de erro.
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
					<center><h3>Bem Vindo à Agenda CAD ' . $nomeusuario . '</h3></center>
				</body>
			</html>';
	die($html);
}
?>