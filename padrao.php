<?php
require('view/template.php');
$tela = new template;
$tela->SetTitle('Definições');
$tela->SetProjectName('SIMPLEX');
$conteudo=$conteudo.'';




$tela->SetContent($conteudo);
$tela->ShowTemplate();
?>