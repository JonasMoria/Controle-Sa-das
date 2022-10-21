<?php

require_once(__DIR__ . '../../Models/Database/HomeDB.php');
session_start();

function lastChamados($id) {
    try {
        $chamados = new HomeDB();
        $id = $_SESSION['dados_usuario'][1];
        $chamados->showChamados($id);
        echo '<script src="../Js/home.js"></script>';
        exit;
    } catch (Throwable $th) {
        echo $th;
        exit;
    }
}

?>