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

// Pesquisar Por ID
if (isset($_POST['pesquisa_por_id'])) {
    $id_pesquisa = $_POST['pesquisa_id'];
    $_SESSION['pesquisa_por_id'] = [true, $id_pesquisa];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}

// Pesquisar Por Data Específica
if (isset($_POST['pesquisa_por_data'])) {

    $dia = $_POST['pesquisa_dia'];
    $mes = $_POST['pesquisa_mes'];
    $ano = $_POST['pesquisa_ano'];

    $data = $ano . '-' . $mes . '-' . $dia;
    $_SESSION['pesquisa_por_data'] = [true, $data];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}

// Pesquisar Por Departamento
if (isset($_POST['pesquisa_por_departamento'])) {
    $departamento = $_POST['pesquisa_departamento'];
    $_SESSION['pesquisa_por_departamento'] = [true, $departamento];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}

// Pesquisar Por Produto
if (isset($_POST['pesquisa_por_produto'])) {
    $produto = $_POST['pesquisa_produto'];
    $_SESSION['pesquisa_por_produto'] = [true, $produto];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}

// Pesquisar Por Observação
if (isset($_POST['pesquisa_por_observacao'])) {
    $produto = $_POST['pesquisa_observacao'];
    $_SESSION['pesquisa_por_observacao'] = [true, $produto];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}

function loadTable()
{
    $id = $_SESSION['dados_usuario'][1];
    $listar = new SaidaDB();

    if (isset($_SESSION['dados_filtro_datas'])) {

        $data1 =  $_SESSION['dados_filtro_datas'][1];
        $data2 =  $_SESSION['dados_filtro_datas'][2];
        $listar->filtrarDatas($data1, $data2, $id);
    } else if (isset($_SESSION['orderna_crescente'])) {

        $listar->ordenaCrescente($id);
    } else if (isset($_SESSION['orderna_decrescente'])) {

        $listar->ordenaDecrescente($id);
    } else if (isset($_SESSION['orderna_alfabeto'])) {

        $listar->ordenaAlfabetico($id);
    } else if (isset($_SESSION['pesquisa_por_id'])) {

        $idSaida = $_SESSION['pesquisa_por_id'][1];
        $listar->pesquisaID($id, $idSaida);
    } else if (isset($_SESSION['pesquisa_por_data'])) {

        $data = $_SESSION['pesquisa_por_data'][1];
        $listar->pesquisaData($id, $data);
    } else if (isset($_SESSION['pesquisa_por_departamento'])) {

        $departamento = $_SESSION['pesquisa_por_departamento'][1];
        $listar->pesquisaDepartamento($id, $departamento);
    } else if (isset($_SESSION['pesquisa_por_produto'])) {

        $produto = $_SESSION['pesquisa_por_produto'][1];
        $listar->pesquisaProduto($id, $produto);
    } else if (isset($_SESSION['pesquisa_por_observacao'])) {

        $obs = $_SESSION['pesquisa_por_observacao'][1];
        $listar->pesquisaObservacao($id, $obs);
    } else {
        $listar->listarSaidas($id);
    }

    unset($_SESSION['orderna_crescente']);
    unset($_SESSION['orderna_decrescente']);
    unset($_SESSION['orderna_alfabeto']);
    unset($_SESSION['dados_filtro_datas']);
    unset($_SESSION['pesquisa_por_id']);
    unset($_SESSION['pesquisa_por_data']);
    unset($_SESSION['pesquisa_por_departamento']);
    unset($_SESSION['pesquisa_por_produto']);
    unset($_SESSION['pesquisa_por_observacao']);
}

// Mostrar id Para Editar Saida
if (isset($_GET['editar'])) {
    $_SESSION['getIdDep'] = $_GET['editar'];
    header('Location: /controlesaidas/Views/pages/editarSaidas.php');
    exit;
}

//Atualiza Dados Saída
if (isset($_POST['editar_confirm'])) {

    try {

        $saida = new Saida();
        $saidaDB = new SaidaDB();

        $id = $_SESSION['dados_usuario'][1];

        $dia = $_POST['saida_diaE'];
        $mes = $_POST['saida_mesE'];
        $ano = $_POST['saida_anoE'];
        $saida->setDia($dia);
        $saida->setMes($mes);
        $saida->setAno($ano);
        $saida->setDepartamento($_POST['saida_departamentoE']);
        $saida->setProduto($_POST['saida_produtoE']);
        $saida->setObservacao($_POST['saida_observacaoE']);

        if ($saidaDB->alterarSaida($saida, $_SESSION['getIdDep'])) {

            $_SESSION['saida_status'] = [true, 'Saída Alterada Com Sucesso!!'];
            header('Location: /controlesaidas/Views/pages/editarSaidas.php');
            exit;
        } else {

            $_SESSION['saida_status'] = [false, 'Não Foi Possivel Alterar Os Dados, Tente Novamente'];
            header('Location: /controlesaidas/Views/pages/editarSaidas.php');
            exit;
        }
    } catch (Exception $erro) {
        $_SESSION['saida_status'] = [false, $erro->getMessage()];
        header('Location: /controlesaidas/Views/pages/editarSaidas.php');
        exit;
    } catch (Throwable $erro) {
        $_SESSION['saida_status'] = [false, 'Valores Inválidos, Insira Novamente!'];
        header('Location: /controlesaidas/Views/pages/editarSaidas.php');
        exit;
    }
}

// Excluir Saídas
if (isset($_GET['excluir'])) {
    $_SESSION['excluir_saida'] = [true, $_GET['excluir']];
    exit(header('Location: /controlesaidas/Views/pages/saidas.php'));
}
if (isset($_POST['excluir_sai_confirm'])) {
    try {
        $idSaida =  $_SESSION['confirma_excluir'];
        $idUsuario = $_SESSION['dados_usuario'][1];
        $saidaDB = new SaidaDB();
        $saidaDB->deletarSaida($idSaida,$idUsuario);
        header('Location: /controlesaidas/Views/pages/saidas.php');
        unset($_SESSION['confirma_excluir']);
        exit;
    } catch (Exception $erro) {
        $_SESSION['falha_excluir_saida'] = [true, $erro->getMessage()];
       header('Location: /controlesaidas/Views/pages/saidas.php');
        exit;
    }
}
