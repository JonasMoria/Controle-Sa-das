<?php

require_once(__DIR__ . '../../Models/Chamado.php');
require_once(__DIR__ . '../../Models/Database/ChamadoDB.php');

session_start();

// Listando Departamentos na Modal
function listarDepartamentos($id)
{
    $chamadoDB = new ChamadoDB();
    $chamadoDB->listarDepartamentos($id);
}

// Pesquisando por ID
if (isset($_POST['pesquisa_por_id'])) {
    $id_pesquisa = $_POST['pesquisa_id'];
    $_SESSION['pesquisa_por_id'] = [true, $id_pesquisa];
    exit(header('Location: /controlesaidas/Views/pages/chamados.php'));
}
// Pesquisar Por Data Específica
if (isset($_POST['pesquisa_por_data'])) {

    $dia = $_POST['pesquisa_dia'];
    $mes = $_POST['pesquisa_mes'];
    $ano = $_POST['pesquisa_ano'];

    $data = $ano . '-' . $mes . '-' . $dia;
    $_SESSION['pesquisa_por_data'] = [true, $data];
    exit(header('Location: /controlesaidas/Views/pages/chamados.php'));
}

// Pesquisar Por Departamento
if (isset($_POST['pesquisa_por_departamento'])) {
    $departamento = $_POST['pesquisa_departamento'];
    $_SESSION['pesquisa_por_departamento'] = [true, $departamento];
    exit(header('Location: /controlesaidas/Views/pages/chamados.php'));
}

// Pesquisar Por Produto
if (isset($_POST['pesquisa_por_produto'])) {
    $produto = $_POST['pesquisa_produto'];
    $_SESSION['pesquisa_por_produto'] = [true, $produto];
    exit(header('Location: /controlesaidas/Views/pages/chamados.php'));
}

// Pesquisar Por Observação
if (isset($_POST['pesquisa_por_observacao'])) {
    $produto = $_POST['pesquisa_observacao'];
    $_SESSION['pesquisa_por_observacao'] = [true, $produto];
    exit(header('Location: /controlesaidas/Views/pages/chamados.php'));
}

function loadTable($id)
{
    $id = $_SESSION['dados_usuario'][1];
    $listar = new ChamadoDB();

    if (isset($_SESSION['pesquisa_por_id'])) {
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
        $listar->listarChamados($id);
    }

    unset($_SESSION['pesquisa_por_id']);
    unset($_SESSION['pesquisa_por_data']);
    unset($_SESSION['pesquisa_por_departamento']);
    unset($_SESSION['pesquisa_por_produto']);
    unset($_SESSION['pesquisa_por_observacao']);
}

// Abrindo Um Novo Chamado
if (isset($_POST['salvar_chamado'])) {

    try {

        $chamadoDB = new ChamadoDB();
        $chamado   = new Chamado();

        $id = $_SESSION['dados_usuario'][1];
        $dia = $_POST['chamado_dia'];
        $mes = $_POST['chamado_mes'];
        $ano = $_POST['chamado_ano'];
        if ($chamado->verificaData($dia, $mes, $ano)) {
            $chamado->setDia($dia);
            $chamado->setMes($mes);
            $chamado->setAno($ano);
        }
        $chamado->setDepartamento($_POST['chamado_departamento']);
        $chamado->setProduto($_POST['chamado_produto']);
        $chamado->setObservacao($_POST['chamado_observacao']);

        if ($chamadoDB->lancarChamado($chamado, $id)) {
            $_SESSION['chamado_status'] = [true, 'Chamado Aberto com Sucesso!'];
            header('Location: /controlesaidas/Views/pages/chamados.php');
        } else {
            $_SESSION['chamado_status'] = [false, 'Falha ao Abrir Chamado!'];
            header('Location: /controlesaidas/Views/pages/chamados.php');
        }
    } catch (Throwable $th) {
        $_SESSION['chamado_status'] = [false, 'Falha ao Abrir Chamado!'];
        header('Location: /controlesaidas/Views/pages/chamados.php');
    }
}
