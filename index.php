<?php

require_once ("config.php");

//chamar por id
$usuario = new Usuario();
//$usuario->loadById(3);
//echo $usuario;

//$lista = Usuario::getList();
//echo json_encode($lista);

// $search = Usuario::search("r");
// echo json_encode($search);

$usuario->login("bob", "bob");

echo $usuario;