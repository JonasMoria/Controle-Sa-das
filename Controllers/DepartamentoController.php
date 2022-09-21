<?php
require_once(__DIR__ . '../../Models/Departamento.php');
require_once(__DIR__ . '../../Models/Database/DepartamentoDB.php');

session_start();

// Cadastrar Um Departamento
if (isset($_POST['salvar_setor'])) {
    try {

        $departamento = new Departamento();
        $departamentoDB = new DepartamentoDB();

        $id = $_SESSION['dados_usuario'][1];
        $departamento->setNome(mb_strtoupper($_POST['departamento_nome'], 'utf-8'));
        $departamento->setResponsavel(mb_strtoupper($_POST['departamento_responsavel'], 'utf-8'));
        $departamento->setTelefone($_POST['departamento_telefone']);
        $departamento->setEmail(mb_strtoupper($_POST['departamento_email'], 'utf-8'));

        if ($departamentoDB->cadastrarDepartamento($departamento, $id)) {
            $_SESSION['departamento_cadastrado'] = true;
            header('Location: /controlesaidas/Views/pages/departamentos.php');
            exit;
        } else {
            $_SESSION['falha_cadastro_departamento'] = true;
            header('Location: /controlesaidas/Views/pages/departamentos.php');
            exit;
        }
    } catch (Exception $erro) {
        $erro = $erro->getMessage();
        $_SESSION['erro_cadastro_departamento'] = true;
        $_SESSION['mostrar_erro_departamento'] = $erro;
        exit(header('Location: /controlesaidas/Views/pages/departamentos.php'));
    }
}

// Pesquisar Departamentos
if (isset($_POST['btnPesquisar'])) {
    $_SESSION['pesquisar_departamento'] = true;
    $_SESSION['palavra'] = $_POST['palavraPesquisar'];
    exit(header('Location: /controlesaidas/Views/pages/departamentos.php'));
}

// Excluir Departamentos
if (isset($_GET['excluir'])) {
    $_SESSION['getIdDep'] = $_GET['excluir'];
    $_SESSION['excluir_departamento'] = true;
    exit(header('Location: /controlesaidas/Views/pages/departamentos.php?'));
}
if (isset($_POST['excluir_confirm'])) {
    try {
        $id = $_SESSION['getIdDep'];
        $departamentoDB = new DepartamentoDB();
        $departamentoDB->deletarDepartamento($id);
        header('Location: /controlesaidas/Views/pages/departamentos.php');
        exit;
    } catch (Exception $erro) {
        $_SESSION['falha_excluir_departamento'] = true;
        $_SESSION['mostrar_erro_exclusao'] = $erro;
        header('Location: /controlesaidas/Views/pages/departamentos.php');
        exit;
    }
}

// Mostrar id Para Editar
if (isset($_GET['editar'])) {
    $_SESSION['getIdDep'] = $_GET['editar'];
    header('Location: /controlesaidas/Views/pages/editarDepartamento.php');
}

//Salvar Dados Editados
if (isset($_POST['editar_confirm'])) {
    try {
        $departamento = new Departamento();
        $departamentoDB = new DepartamentoDB();
        $id = $_SESSION['getIdDep'];
        $departamento->setNome(mb_strtoupper($_POST['departamento_nomeE'], 'utf-8'));
        $departamento->setResponsavel(mb_strtoupper($_POST['departamento_responsavelE'], 'utf-8'));
        $departamento->setTelefone($_POST['departamento_telefoneE']);
        $departamento->setEmail(mb_strtoupper($_POST['departamento_emailE'], 'utf-8'));

        if ($departamentoDB->alterarDepartamento($departamento, $id)) {
            $_SESSION['departamento_editado'] = true;
            header('Location: /controlesaidas/Views/pages/editarDepartamento.php');
            exit;
        } else {
            $_SESSION['falha_edicao_departamento'] = true;
            header('Location: /controlesaidas/Views/pages/editarDepartamento.php');
            exit;
        }
    } catch (Exception $erro) {
        $erro = $erro->getMessage();
        $_SESSION['erro_editar_departamento'] = true;
        $_SESSION['mostrar_erro_departamentoE'] = $erro;
        exit(header('Location: /controlesaidas/Views/pages/editarDepartamento.php'));
    }
}
