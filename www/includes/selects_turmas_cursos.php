<?php
//Este é um código bastante utilizado no sistema e bastante complicado.
//a sua função é de gerar um menu select com o nome dos cursos e também gerar variáveis em javascript com o conteúdo
//de um menu select mostrando as turmas de cada curso.
//para perceber a sua funcionalidade descomente o código abaixo:


$selects = "";
function constroi_select_turmas($eventos){
	global $selects;
	require("includes/conectar_mysql.php");
		$query = "SELECT DISTINCT curso FROM turma_curso order by curso";
		$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
		while($curso = mysql_fetch_array($result, MYSQL_ASSOC)){	
			$query = "SELECT turma FROM turma_curso where curso='" . $curso["curso"] . "'";
			$result2 = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
			$select = 'var ' . str_replace(" ", "_", $curso["curso"]) . ' = "<select name=\\"turma\\" style=\\"width: 100%;\\" ' . $eventos . '><option value=\\"\\"></option>';
			while($turma = mysql_fetch_array($result2, MYSQL_ASSOC)){
				$select .= '<option value=\"' . $turma["turma"] . '\">' . $turma["turma"] . '</option>';
			}
			$select .= '</select>";';
			if (is_array($selects)){
				array_push($selects, $select);
			}
			else $selects = array($select);
		}
	require("includes/desconectar_mysql.php");
	/*foreach($selects as $valor){
		echo($valor . "<br>");
	}*/
	return $selects;
}

function constroi_select_curso(){
	global $CURSO, $modo;

	$saida = 	'<select name="curso" style="width: 100%" onChange="muda_turma();">';
	$saida .= 	'<option value=""></option>';

	require("includes/conectar_mysql.php");
	$query = "SELECT DISTINCT curso FROM turma_curso order by curso";
	$result = mysql_query($query) or die("Erro ao acessar registros no Banco de dados: " . mysql_error());
	while($curso = mysql_fetch_array($result, MYSQL_ASSOC)){
		if (($modo == "update") && ($CURSO == $curso["curso"])) $saida .= "<option value=\"" . $curso["curso"] . "\" selected>" . $curso["curso"] . "</option>";
		else  $saida .= "<option value=\"" . $curso["curso"] . "\">" . $curso["curso"] . "</option>";
	}
	$saida .= "</select>";
	return $saida;
}
?>