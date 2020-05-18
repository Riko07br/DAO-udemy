<?php

require_once ("config.php");

$usuario = new Usuario();

$usuario->loadById(3);

echo $usuario;