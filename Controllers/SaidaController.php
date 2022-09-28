<?php
require_once(__DIR__ . '../../Models/Saida.php');
require_once(__DIR__ . '../../Models/Database/SaidaDB.php');

session_start();

// Cadastar uma saída
if (isset($_POST['salvar_saida'])) {
   
    try {
        
        $saida = new Saida();
        $saidaDB = new SaidaDB();

        $id = $_SESSION['dados_usuario'][1];
        $dia = $_POST['saida_dia'];
        $mes = $_POST['saida_mes'];
        $ano = $_POST['saida_ano'];
        if($saida->verificaData($dia,$mes,$ano)){
            $saida->setDia($dia);
            $saida->setMes($mes);
            $saida->setAno($ano);
        }
        $saida->setDepartamento($_POST['saida_departamento']);
        $saida->setProduto($_POST['saida_produto']);
        $saida->setObservacao($_POST['saida_observacao']);

        if ($saidaDB->cadastrarSaida($saida,$id)) {
            $_SESSION['saida_cadastrada'] = true;
            header('Location: /controlesaidas/Views/pages/saidas.php');
            exit;
        } else {
            $_SESSION['falha_cadastro_saidas'] = true;
            header('Location: /controlesaidas/Views/pages/saidas.php');
            exit;
        }

    } catch (Exception $erro) {
        $erro = $erro->getMessage();
        $_SESSION['erro_cadastro_saida'] = true;
        $_SESSION['mostrar_erro_saida'] = $erro;
        exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
    }
}

