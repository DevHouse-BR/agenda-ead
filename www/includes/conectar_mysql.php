<?php
//Conecta com o banco de dados informando o ip ou nome do servidor e login e senha do usuario do banco de dados.
$db = mysql_connect("localhost", "root", "vertrigo") or die("Erro de conexão com o banco: " . mysql_error());
mysql_select_db ("agenda");
?>