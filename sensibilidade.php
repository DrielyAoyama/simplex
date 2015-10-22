<?php
require('view/template.php');
require_once('simplex.php');
$tela = new template;
$simplex = new Simplex;
$tela->SetTitle('Análise de Sensibilidade');
$tela->SetProjectName('SIMPLEX');
$conteudo='';
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




  for ($linha=1; $linha < $_SESSION['qtdelinhas'] ; $linha++) { 
        	if ((substr(strtoupper(trim($tabelafinal[$linha][0])),0,1)=='F')){
      		     $conteudo=$conteudo.'<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'  ->     indica sobra/falta (se resultado negativo) de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades do recurso R'.$linha.' e a ultilização de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades.</p>';
        	}else{
        		if((substr(strtoupper(trim($tabelafinal[$linha][0])),0,1)!='Z')){
        		 	$conteudo=$conteudo.'<p>'.$tabelafinal[$linha][0].' = '.$tabelafinal[$linha][$qtdecolunas-1].'  ->     indica produção de '.$tabelafinal[$linha][$qtdecolunas-1].' unidades do produto  P'.$linha.'.</p>';
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


$conteudo=$conteudo.'<h3><strong>Preço Sombra</strong></h1><br>';
$conteudo=$conteudo.'<p>O preço sombra é a taxa de variáção da função objetiva (Z) para uma alteração a disponibilidade de recursos.</p>';
$conteudo=$conteudo.'<p><strong>Isto é :</strong> refere-se a quantidade que o lucro total (Z) poderia ser melhorado caso a quantidade do recurso seja igual a 1</p><br><br>';


$tabelaprecosombra=array();
$aux=0;

$recursos=array();
$resultadorecurso=array();
for ($coluna=0; $coluna < $qtdecolunas ; $coluna++) { 
   if(trim(strtoupper(substr($tabelafinal[0][$coluna],0,1)))=='F'){
       $tabelaprecosombra[$aux][0]=$tabelafinal[0][$coluna];
       array_push($recursos, $tabelafinal[0][$coluna]);
       $tabelaprecosombra[$aux][1]=$tabelafinal[$_SESSION['qtdelinhas']-1][$coluna];
        array_push($resultadorecurso, $tabelafinal[$_SESSION['qtdelinhas']-1][$coluna]);
       $aux++;
   }
}


$deltas = array();
$lmin = array();
$lmax = array();
$minima=9999;
$maxima=-9999;
$aux = 0;
$aux2= 1;

//calculando e imprimindo o limite mino e maximo
for ($coluna=($_SESSION['qtdevariaveis']+1); $coluna < ($_SESSION['qtdecolunas']-1) ; $coluna++) { 
  $minima=9999;
  $maxima=-9999;
    for ($linha=1; $linha < ($_SESSION['qtdelinhas']-1); $linha++) {  
     $b = ($tabelafinal[$linha][$_SESSION['qtdecolunas']-1]);
     $f =  ($tabelafinal[$linha][$coluna]);       
     $vlrb = $tabelainicial[$aux2][$_SESSION['qtdecolunas']-1]; 
      if ((($tabelafinal[$linha][$_SESSION['qtdecolunas']-1])!=0)  and  (($tabelafinal[$linha][$coluna])!=0)){
        $deltas[$linha-1][$aux]   =   (round(((($b*-1)/$f)),2)+$vlrb);
      //  $conteudo=$conteudo.($b*-1).' /  '.$f.' = '. (round(((($b*-1)/$f)),2)+$vlrb).'<br>';
        ///// DELTA = ((B)*-1)/F
      }else{
         $deltas[$linha-1][$aux]=0+$vlrb; 
      }

      if( $deltas[$linha-1][$aux] < $minima){
         $minima=$deltas[$linha-1][$aux];
      }
      if( $deltas[$linha-1][$aux] > $maxima){
         $maxima=$deltas[$linha-1][$aux];
      }
    }
    $lmax[$aux]=$maxima;
    $lmin[$aux]=$minima;
    $aux++;
    $aux2++;
}


$conteudo=$conteudo.'<h3><strong>Limites</strong></h1><br>';
$conteudo=$conteudo.'<p>Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto </p>';
$conteudo=$conteudo.'<p>bla bla bla bla bla bla bla bla bla bla</p><br><br>';






//escrevendo os limites minimos
$aux=0;
$aux2= 1;
for ($coluna=($_SESSION['qtdevariaveis']+1); $coluna < ($_SESSION['qtdecolunas']-1) ; $coluna++) {
  $conteudo=$conteudo.'<strong>'.$tabelafinal[0][$coluna].'</strong><br>'; 
    for ($linha=1; $linha < ($_SESSION['qtdelinhas']-1); $linha++) {   
      if (  ($tabelafinal[$linha][$_SESSION['qtdecolunas']-1])!=0  and   ($tabelafinal[$linha][$coluna]) !=0){
        $b = ($tabelafinal[$linha][$_SESSION['qtdecolunas']-1]);
        $f =  ($tabelafinal[$linha][$coluna]);
        $vlrb = $tabelainicial[$aux2][$_SESSION['qtdecolunas']-1]; 
        $conteudo=$conteudo.($b*-1).' /  '.$f.' + '.$vlrb.' = '.  (round(((($b*-1)/$f)),2)+$vlrb).'<br>';
      }      
    }
   
    $conteudo=$conteudo.'<strong>Minimo :'.$lmin[$aux].'</strong><br>';
    $conteudo=$conteudo.'<strong>Máximo :'.$lmax[$aux].'</strong><br>';
    $conteudo=$conteudo.'<br><hr>';
    $aux++;    
    $aux2++;
}

    




$conteudo=$conteudo.'<div class="row"><div class="col-lg-12">';
$conteudo=$conteudo.'<table class="table table-bordered">
                         <thead><tr>';

$conteudo=$conteudo.'<th>Recursos</th>';
$conteudo=$conteudo.'<th>Preço Sombra</th>';
$conteudo=$conteudo.'<th>Limite Mínimo</th>';
$conteudo=$conteudo.'<th>Limite Máximo</th>';
$conteudo=$conteudo.'<th>Valor Inicial (B)</th>';

$conteudo=$conteudo.'</tr></thead>';  

for ($l=0; $l <= 2 ; $l++) {
     $conteudo=$conteudo.'<tr>'; 
     for ($c=0; $c < ($aux-1) ; $c++) { 
      if(trim($tabelaprecosombra[$l][$c])!=''){
        $conteudo=$conteudo.'<td>'.$tabelaprecosombra[$l][$c].'</td>';
      }
     }
}





$conteudo=$conteudo.'</tbody>';
$conteudo=$conteudo.'</table>';
$conteudo=$conteudo.'</div>';


$conteudo=$conteudo.'<br><br>';






$tela->SetContent($conteudo);
$tela->ShowTemplate();
?>