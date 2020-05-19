<?php

require_once ("config.php");

//chamar por id
// $usuario = new Usuario();
//$usuario->loadById(3);
//echo $usuario;

//traz um lista de todos os usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);

//procura por um usuario com esses parametro de login
// $search = Usuario::search("r");
// echo json_encode($search);

//tenta logar com usuario e senha
// $usuario->login("bob", "bob");

//insere um novo usuario com senha
// $aluno = new Usuario("yeet", "yeeeeet");
// $aluno->insert();

//altera os valores de login e senha para dum user ja existente
$usuario =  new Usuario();
$usuario->loadById(4);
$usuario->update("new dude", "duuude");
echo $usuario;