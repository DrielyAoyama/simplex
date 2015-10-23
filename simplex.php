<?php
class Simplex{
	public $tabela=array();
	


	public function SetTabela($t){
		$this->tabela=null;
		$this->tabela=$t;
	}

	public function MostraTabela($tamanho,$qtdecolunas,$qtdelinhas){
		$conteudo='';
		if($tamanho==12){
			$conteudo=$conteudo.'<div class="row"><div class="col-lg-12">';
		}else{
			$conteudo=$conteudo.'<div class="col-lg-6">';
		}
		$conteudo=$conteudo.'<table class="table table-bordered">
		                     <thead><tr>';
		//cabeçalho              
		for ($c=0; $c <$qtdecolunas ; $c++) { 
			$conteudo=$conteudo.'<th>'.$this->tabela[0][$c].'</th>';
		}
		$conteudo=$conteudo.'</tr></thead>';		
		//apartir da segunda linha
		$conteudo=$conteudo.'<tbody>';
		for ($l=1; $l < $qtdelinhas ; $l++) {
			if ($l!=$qtdelinhas-1){
				$conteudo=$conteudo.'<tr>'; 
				for ($c=0; $c < $qtdecolunas; $c++) { 
						$conteudo=$conteudo.'<td>'.$this->tabela[$l][$c].'</td>';
				}
				$conteudo=$conteudo.'</tr>';
			}else{
				$conteudo=$conteudo.'<tr style="color:red;">'; 
				for ($c=0; $c < $qtdecolunas; $c++) { 
						$conteudo=$conteudo.'<td>'.$this->tabela[$l][$c].'</td>';
				}
				$conteudo=$conteudo.'</tr>';
			}
		}
		$conteudo=$conteudo.'</tbody>';
		$conteudo=$conteudo.'</table>';
		$conteudo=$conteudo.'</div>';
		if($tamanho==12){
			$conteudo=$conteudo.'</div>';
		}
		return $conteudo;
	}



	public function MostraColunaDoPivoAnulada($tabela,$linha,$coluna){
		$pivonegativo = ($tabela[$linha][$coluna])*-1;
		$Linhadopivo = $linha;
		$colunadopivo = $coluna;

		for ($linha=1; $linha < $_SESSION['qtdelinhas'] ; $linha++) { 
			if (isset($tabela[$linha][0])){//apenas validacao
				$anular = ($tabela[$linha][$colunadopivo])*-1;
				 //quem vai ser anulado	
					for ($coluna=1; $coluna < $_SESSION['qtdecolunas']; $coluna++) { 						
						if (isset($tabela[$Linhadopivo][$coluna])){  //apenas validacao							
							$a=$tabela[$Linhadopivo][$coluna];
							$b=$tabela[$linha][$coluna];
							if($linha!=$Linhadopivo){
								$tabela[$linha][$coluna]=($a * ($anular) + $b);   //linha do pivo * numero que esta sendo anulado*(-1)+linha do que esta sendo anulado
							}
						}//if (isset($tabela[$Linhadopivo][$coluna])){
					}//for ($coluna=1; $coluna < $_SESSION['qtdecolunas']; $coluna++) { 
			}//if (isset($tabela[$linha][0])){//apenas validacao
		}//for ($linha=1; $linha < $_SESSION['qtdelinhas'] ; $linha++) { 
		return $tabela;
	}








}


?>