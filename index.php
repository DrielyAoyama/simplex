<?php
require('view/template.php');
$tela = new template;
$tela->SetTitle('Configuração');
$tela->SetProjectName('SIMPLEX');
$conteudo='

<form class="form-horizontal" action="definicoes.php" method="GET">
<fieldset>

<!-- Form Name -->
<legend>Configuração</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="qtdevariaveis">qtde de variáveis de decisão</label>  
  <div class="col-md-4">
  <input id="qtdevariaveis" name="qtdevariaveis" type="number" placeholder="variáveis de decisão" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="qtderestricoes">qtde de restrições</label>  
  <div class="col-md-4">
  <input id="qtderestricoes" name="qtderestricoes" type="number" placeholder="restrições" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="objetivo">objetivo</label>
  <div class="col-md-4">
    <select id="objetivo" name="objetivo" class="form-control">
      <option value="max">Maximizar</option>
      <option value="min">Minimizar</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button name="submit" class="btn btn-success">Continuar</button>
  </div>
</div>

</fieldset>
</form>


';

$tela->SetContent($conteudo);

$tela->ShowTemplate();




?>