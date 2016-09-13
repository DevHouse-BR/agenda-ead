<?php
//Este script finaliza a seção apagando os cookies gravados no browser do cliente.
//Para apagar os cookies basta setar a data de expiração para uma data já passada.

setcookie("cd_usuario_agenda", "", time() - 3600);
setcookie("nome_usuario_agenda", "", time() - 3600);
setcookie("tipo_usuario_agenda", "", time() - 3600);
?>
<html>
	<head>
		<title>Logout do Sistema</title>
	</head>
	<body>
		<center><h3>Obrigado e volte sempre!</h3></center>
	</body>
</html>