<?php
require('view/template.php');
require_once('simplex.php');
$tela = new template;
$simplex = new Simplex;
$tela->SetTitle('Análise de Sensibilidade');
$tela->SetProjectName('SIMPLEX');
$conteudo=$conteudo.'';
session_start();
$tabelafinalinicial = array();
$tabelafinalfinal = array();
$qtdelinhas = $_SESSION['qtdelinhas'];
$qtdecolunas = $_SESSION['qtdecolunas'];
$tabelainicial = $_SESSION['tabelainicial'];
$tabelafinal = $_SESSION['tabelafinal'];

$conteudo=$conteudo.'<h1 style="text-align:center;" ><strong> Análise de Sensibilidade</strong></h1><br>';
$conteudo=$conteudo.'<h3><strong>Tabela Inicial</strong></h1><br>';

$simplex->SetTabela($tabelainicial);
$conteudo=$conteudo.$simplex->MostraTabela('12',$qtdecolunas,$qtdelinhas);  


$conteudo=$conteudo.'<h3><strong>Tabela Final</strong></h1><br>';

$simplex->SetTabela($tabelafinal);
$conteudo=$conteudo.$simplex->MostraTabela('12',$qtdecolunas,$qtdelinhas);  


$conteudo=$conteudo.'<h3><strong>Qual a interpretação do quadro final?</strong></h1><br>';

$conteudo=$conteudo.'<div class="col-lg-6"><h4>Variáveis Básicas</h4>';




  for ($linha=1; $linha < $qtdelinhas ; $linha++) { 
        	if ((substr(strtoupper(trim($tabelafinal[$linha][0])),0,1)=='F')){
      		     $conteudo=$conteudo.'<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'  ---->     indica sobra/falta (se resultado negativo) de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades do recurso R'.$linha.' e a ultilização de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades.</p>';
        	}else{
        		if((substr(strtoupper(trim($tabelafinal[$linha][0])),0,1)!='Z')){
        		 	$conteudo=$conteudo.'<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'  ---->     indica produção de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades do produto  P'.$linha.'.</p>';
          		}else{
          		//	$conteudo=$conteudo.'<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'<br>';
          		}
          	}
        }
$conteudo=$conteudo.'</div>';
$conteudo=$conteudo.'<div class="col-lg-6"><h4>Variáveis Não-Básicas</h4>';
	  
	    
	    $basicas=null;
	    $aux=0;
	    for ($i=1; $i < $qtdelinhas ; $i++) { 
     		$basicas[$aux]=$tabelafinal[$i][0];
			$aux++;
     	}



     	for ($i=1; $i < $qtdecolunas-1; $i++) { 
     		$contador=0;
     		$Variavel;
     		for ($y=1; $y < $qtdelinhas ; $y++) { 
     			if($tabelafinal[0][$i]==$tabelafinal[$y][0]){
     				$contador++;
     			}     			
     		}
     		if($contador==0){
     				$conteudo=$conteudo.'<p>'.$tabelafinal[0][$i].' = 0     ->    indica sobra/falta de 0 unidades do recurso R'.substr($tabelafinal[0][$i],6,1).' que significa a utilização total dos recursos.</p><br>';
     	    }
     	}
$conteudo=$conteudo.'</div>';


$tela->SetContent($conteudo);
$tela->ShowTemplate();
?>