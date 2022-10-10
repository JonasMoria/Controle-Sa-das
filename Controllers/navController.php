<?php

session_start();

$host    = 'http://localhost/';
$project = 'controlesaidas/'; 

$login = $host.$project.'index.php';
$home = $host.$project.'views/pages/home.php';
$departamentos = $host.$project.'views/pages/departamentos.php';
$saidas = $host.$project.'views/pages/saidas.php';
$chamados = $host.$project.'views/pages/chamados.php';

if (isset($_POST['exit'])) {
    session_destroy();
    header("Location: $login");
    exit;
}

if (isset($_POST['go_home'])) {
    header("Location: $home");
    exit;
}

if (isset($_POST['go_departamentos'])) {
    header("Location: $departamentos");
    exit;
}
if (isset($_POST['go_saidas'])) {
    header("Location: $saidas");
    exit;
}
if (isset($_POST['go_chamados'])) {
    header("Location: $chamados");
    exit;
}


?>