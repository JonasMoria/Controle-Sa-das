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

function loadTable($id) {
    $chamadoDB = new ChamadoDB();
    $chamadoDB->listarChamados($id);
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
