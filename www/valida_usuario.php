<?php

#Este script exerce uma funчуo muito importante dentro do sistema. Ele recebe o nome de usuario e senha digitados no
#script index.php e busca no banco de dados estas informaчѕes. Caso estejam corretas ele grava no browser do usuсrio
#cookies contendo informaчѕes necessсrias para o funcionamento do sistema. O sistema nуo funcionarс caso o browser esteja
#desabilitado para o uso de cookies.

#Outra funчуo importante deste script щ pesquisar no banco de dados a existъncia de usuсrios cadastrados.
#Caso o sistema esteja sendo implementado, o banco de dados vai estar vazio entуo o sistema permite a entrada de um usuсrio
#sem senha e com permissѕes apenas para cadastrar professores.


$login = $_POST["usuario"];	//Recebe as informaчѕes digitadas
$senha = $_POST["senha"];

require("includes/conectar_mysql.php");
	$query = "SELECT COUNT(*) FROM usuarios"; //Faz a contagem para verificar a existencia de usuarios cadastrados.
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	$qtd = mysql_fetch_row($result);
	
	if ($qtd[0] != 0){ //Caso existam usuarios cadastrados:
		//Busca no banco de dados as informaчѕes do usuario com o nome de usuario digitado no formulсrio.
		$query = "SELECT cd, nome, email, senha, tipo, alterar_senha FROM usuarios WHERE (email='" . $login . "')";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		$usuario = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if(($usuario == false) || (strcmp(trim($usuario["senha"]), trim($senha)) != 0)){ //A funчуo strcmp() compara strings e a funчуo trim remove espaчos em branco no comeчo ou no final da string.
			//Caso nуo exista usuario com este nome (email) ou a senha digitada seja diferente da senha contida no banco entуo:
			header("Location: index.php?status=erro1"); //Redireciona o browser para o formulario de login novamente sѓ que agora informa ao formulсrio que ele deve mostar a mensagem de erro.
			die(); //Finaliza a execuчуo do script
		}
		else { //Se nуo, ou seja, se o usuсrio exista e sua senha esteja correta entуo щ feita a verificaчуo se щ o primeiro login deste usuario (campo da tabela "alterar_senha" = "s")
			if ($usuario["alterar_senha"] == "s") novo_usuario();
			else valida();
		}
	}
	else valida_root(); //Caso nуo existam usuarios cadastrados no sistema a funчуo valida root possibilita que um usuario com permissѕes
						//para cadastrar professores seja logado no sistema.
	
require("includes/desconectar_mysql.php");

function valida(){
	global $usuario; //Determina que a variсvel $usuario deve ser lida do escopo global.
	//O codigo abaixo seta os cookies com as informaчѕes necessсrias para o funcionamento do software ou entуo interrompe o processamento exibingo uma mensagem de erro.
	if(!setcookie("cd_usuario_agenda", $usuario["cd"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("nome_usuario_agenda", $usuario["nome"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("tipo_usuario_agenda", $usuario["tipo"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("email_usuario_agenda", $usuario["email"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	header("Location: agenda.php"); //Redireciona o browser para a pagina especificada.
}
function valida_root(){
	if(!setcookie("cd_usuario_agenda", "0")) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("nome_usuario_agenda", "root")) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("tipo_usuario_agenda", "root")) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	header("Location: cadastro_professores.php"); 
}
function novo_usuario(){
	global $usuario;
	if(!setcookie("cd_usuario_agenda", $usuario["cd"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("nome_usuario_agenda", $usuario["nome"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("tipo_usuario_agenda", $usuario["tipo"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	if(!setcookie("email_usuario_agenda", $usuario["email"])) die("O seu browser deve aceitar Cookies para o bom funcionamento do software.");
	header("Location: form_senha1.php");
}

?>