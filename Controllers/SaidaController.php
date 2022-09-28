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
        if ($saida->verificaData($dia, $mes, $ano)) {
            $saida->setDia($dia);
            $saida->setMes($mes);
            $saida->setAno($ano);
        }
        $saida->setDepartamento($_POST['saida_departamento']);
        $saida->setProduto($_POST['saida_produto']);
        $saida->setObservacao($_POST['saida_observacao']);

        if ($saidaDB->cadastrarSaida($saida, $id)) {
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

// Filtrar Entre Datas
if (isset($_POST['filtrar_entre_datas'])) {

    try {

        $diaMin = $_POST['saida_dia_pesq_min'];
        $mesMin = $_POST['saida_mes_pesq_min'];
        $anoMin = $_POST['saida_ano_pesq_min'];

        $diaMax = $_POST['saida_dia_pesq_max'];
        $mesMax = $_POST['saida_mes_pesq_max'];
        $anoMax = $_POST['saida_ano_pesq_max'];

        $dataMin = $anoMin . '-' . $mesMin . '-' . $diaMin;
        $dataMax = $anoMax . '-' . $mesMax . '-' . $diaMax;

        $_SESSION['dados_filtro_datas'] = [true, $dataMin, $dataMax];

        exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
    } catch (Exception $erro) {
        $erro = $erro->getMessage();
        $_SESSION['erro_cadastro_saida'] = true;
        $_SESSION['mostrar_erro_saida'] = $erro;
        exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
    }
}

// Ordenar de forma Crescente
if (isset($_POST['orderna_crescente'])) {
    $_SESSION['orderna_crescente'] = [true];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}
// Ordenar de forma Decrescente
if (isset($_POST['orderna_decrescente'])) {
    $_SESSION['orderna_decrescente'] = [true];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}
// Ordenar de forma Alfabetica
if (isset($_POST['orderna_alfabeto'])) {
    $_SESSION['orderna_alfabeto'] = [true];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}



function loadTable()
{
    $id = $_SESSION['dados_usuario'][1];
    $listar = new SaidaDB();

    if (isset($_SESSION['dados_filtro_datas'])) {
        try {
            $data1 =  $_SESSION['dados_filtro_datas'][1];
            $data2 =  $_SESSION['dados_filtro_datas'][2];
            $listar->filtrarDatas($data1, $data2, $id);
        } catch (Exception $erro) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>" . $erro->getMessage() . "</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>";
        }
    } else if (isset($_SESSION['orderna_crescente'])) {
        $listar->ordenaCrescente($id);
    } else if (isset($_SESSION['orderna_decrescente'])) {
        $listar->ordenaDecrescente($id);
    } else if (isset($_SESSION['orderna_alfabeto'])) {
        $listar->ordenaAlfabetico($id);
    } else {
        $listar->listarSaidas($id);
    }

    unset($_SESSION['orderna_crescente']);
    unset($_SESSION['orderna_decrescente']);
    unset($_SESSION['orderna_alfabeto']);
    unset($_SESSION['dados_filtro_datas']);
}
