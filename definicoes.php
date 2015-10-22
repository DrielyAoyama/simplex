<?php
require('view/template.php');
$tela = new template;
$tela->SetTitle('Definições-SIMPLEX');
$tela->SetProjectName('SIMPLEX');
session_start();


//é criado dinimicamente os campos para preennche-los

if (
	isset($_GET['qtdevariaveis']) and  
	isset($_GET['qtderestricoes']) and
	isset($_GET['objetivo'])
	){	
	$_SESSION['qtdevariaveis'] = $_GET['qtdevariaveis'];
	$_SESSION['qtderestricoes'] = $_GET['qtderestricoes'];
	$_SESSION['objetivo'] = $_GET['objetivo'];
}

$conteudo=$conteudo.
'
<strong>Função Objetiva</strong><br>
';

//Monta Z = .......
$conteudo=$conteudo.
	'<form name="frmdefinicao" method="GET" action="vizualizar.php">';
	 if ($_SESSION['objetivo']=='max'){
		$conteudo=$conteudo.'<strong>Maximizar  Z =  </strong>';
	}else{
		$conteudo=$conteudo.'<strong>Minimizar  Z =  </strong>';
	}

for ($i=1; $i <= $_SESSION['qtdevariaveis'] ; $i++) { 
	$conteudo=$conteudo.
	  '<input type="number" name="z'.$i.'" size="3" maxlength="3"> X<sub>'.$i.'</sub>';
	if($i<$_SESSION['qtdevariaveis']){
	   $conteudo=$conteudo.' + ';
	}
}
$conteudo=$conteudo.
'<br><br>';



//Monta requisicoes
$conteudo=$conteudo.
'<br><br><strong>Restrições</strong><br>';
//L de linha   C de coluna
for ($l=1; $l <= $_SESSION['qtderestricoes']; $l++) { 
	for ($c=1; $c <= $_SESSION['qtdevariaveis'] ; $c++) { 
		$conteudo=$conteudo.
		'
		<input type="number" name="r'.$l.'_'.$c.'" size="3" maxlength="3"> X<sub>'.$c.'</sub>
		';
		if($c<$_SESSION['qtdevariaveis']){ // se nao for a ultima coloca um ponto
	  	   $conteudo=$conteudo.' + ';
		}else{//se não acrescenta o resultado da linha
		$conteudo=$conteudo.
		'	
		<select id="relacao" name="relacao'.$l.'" >
           <option value="<=">   <=     </option>
           <option value=">=">   >=     </option>
        </select>
        <input type="number" name="resultado'.$l.'" size="3" maxlength="3">
		';
		}
	}
	$conteudo=$conteudo.'<br>';
}
$conteudo=$conteudo.'<br><br>';//espaçamento

//x1...>=0
$funcao='';
for ($c=1; $c <=$_SESSION['qtdevariaveis'] ; $c++) { 
	$funcao=$funcao.'X<sub>'.$c.'</sub>';
	if($c<$_SESSION['qtdevariaveis'] ){
		$funcao=$funcao.' , ';	
	}else{
		$funcao=$funcao.' >= 0;';
	}
}
$_SESSION['restricaopadrao']=$funcao;
$conteudo=$conteudo.$funcao;

$conteudo=$conteudo.'<br><br>';
$conteudo=$conteudo.'<button id="submit" name="submit" class="btn btn-success">Definir</button>';



$conteudo=$conteudo.'</form>';
$tela->SetContent($conteudo);
$tela->ShowTemplate();
?>