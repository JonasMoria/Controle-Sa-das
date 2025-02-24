<?php

require('../Models/Usuario.php');
require('../Models/Database/UsuarioDB.php');

session_start();

// Cadastro
if (isset($_POST['btnCadastro'])) {

    try {

        $usuario = new Usuario();
        $usuarioDB = new UsuarioDB();

        $usuario->setNome(trim($_POST['name']));
        $usuario->setEmail(strtoupper(trim($_POST['email'])));
        $usuario->setSenha(trim($_POST['pass']));
        $usuarioPass = $_POST['passRep'];

        if ($usuario->verificaSenha($usuarioPass, $usuario->getSenha())) {
            if ($usuarioDB->cadastro($usuario)) {
                $_SESSION['cadastro_efetuado'] = true;
                header('Location: /controlesaidas/Views/Pages/cadastro.php');
                exit;
            } else {
                $_SESSION['cadastro_falha'] = true;
                header('Location: /controlesaidas/Views/pages/cadastro.php');
                exit;
            }
        } else {
            $_SESSION['senha_incorreta'] = true;
            header('Location: /controlesaidas/Views/pages/cadastro.php');
            exit;
        }
    } catch (Exception $erro) {
        $erro = $erro->getMessage();
        $_SESSION['cadastro_erro'] = true;
        $_SESSION['mostrar_erro'] = $erro;
        header('Location: /controlesaidas/Views/pages/cadastro.php');
        exit;
    }
}

// Login
if (isset($_POST['btnLogin'])) {

    try {

        $usuario = new Usuario();
        $usuarioDB = new UsuarioDB();

        $email = strtoupper(trim($_POST['inptUser']));
        $senha  = trim($_POST['inptPass']);

        if ($usuarioDB->login($email, $senha)) {
            $user = $usuarioDB->getUser($email);
            $_SESSION['autorizado'] = true;
            $_SESSION['dados_usuario'] = $user;
            header('Location: /controlesaidas/Views/Pages/home.php');
            exit;
        } else {
            $_SESSION['login_falha'] = true;
            header('Location: /controlesaidas/index.php');
            exit;
        }
    } catch (Exception $erro) {
        $_SESSION['login_erro'] = true;
        $_SESSION['mostrar_erro'] = $erro->getMessage();
        header('Location: /controlesaidas/index.php');
        exit;
    }
}

//Alterar Cadastro
if (isset($_POST['btn-alterarDados'])) {

    $id = $_SESSION['dados_usuario'][1];
    $nome = trim($_POST['nome']);
    $email = strtoupper(trim($_POST['email']));

    try {

        if (validaDados($nome, $email)) {
            $usuarioDB = new UsuarioDB();

            if ($usuarioDB->alterarCadastro($nome, $email, $id)) {
                $_SESSION['update_cad_status'] = [true, 'Dados Alterados com Sucesso!'];
                exit(header('Location: /controlesaidas/index.php'));
                session_destroy();
            } else {
                $_SESSION['update_cad_status'] = [false, 'Falha ao alterar dados, Tente Novamente!'];
                exit(header('Location: /controlesaidas/Views/pages/configs.php'));
            }
        }
    } catch (Throwable $erro) {
        $_SESSION['update_cad_status'] = [false, $erro->getMessage()];
        exit(header('Location: /controlesaidas/Views/pages/configs.php'));
    }
}

//Alterar Senha
if (isset($_POST['btn-alterarSenha'])) {

    try {

        $id = $_SESSION['dados_usuario'][1];
        $senhaAntiga = trim($_POST['senhaAntiga']);
        $senhaNova = trim($_POST['senhaNova']);
        $confNovaSenha = trim($_POST['confNovaSenha']);

        $usuarioDB = new UsuarioDB();
        $usuario = new Usuario();

        if ($usuario->verificaSenha($senhaNova, $confNovaSenha)) {
            if ($usuarioDB->alterarSenha($senhaAntiga, $senhaNova, $id)) {
                $_SESSION['update_cad_status'] = [true, 'Senha Alterada Com Sucesso!'];
                exit(header('Location: /controlesaidas/Views/pages/configs.php'));
            }
        }
    } catch (Throwable $erro) {
        $_SESSION['update_cad_status'] = [false, $erro->getMessage()];
        exit(header('Location: /controlesaidas/Views/pages/configs.php'));
    }
}

//Fazer backup chamados
if (isset($_POST['btn-bkpChamado'])) {
    try {
        $usuario = new UsuarioDB();
        $id = $_SESSION['dados_usuario'][1];
        $usuario->bkpChamados($id);
    } catch (\Throwable $th) {
        $_SESSION['update_cad_status'] = [false, 'Erro Ao Gerar Backup!'];
        exit(header('Location: /controlesaidas/Views/pages/configs.php'));
    }
}

//Fazer backup Saidas
if (isset($_POST['btn-bkpSaida'])) {
    try {
        $usuario = new UsuarioDB();
        $id = $_SESSION['dados_usuario'][1];
        $usuario->bkpSaidas($id);
    } catch (\Throwable $th) {
        $_SESSION['update_cad_status'] = [false, 'Erro Ao Gerar Backup!'];
        exit(header('Location: /controlesaidas/Views/pages/configs.php'));
    }
}

//Fazer backup Departamentos
if (isset($_POST['btn-bkpDept'])) {
    try {
        $usuario = new UsuarioDB();
        $id = $_SESSION['dados_usuario'][1];
        $usuario->bkpDepartamentos($id);
    } catch (\Throwable $th) {
        $_SESSION['update_cad_status'] = [false, 'Erro Ao Gerar Backup!'];
        exit(header('Location: /controlesaidas/Views/pages/configs.php'));
    }
}

//Excluir Conta
if (isset($_POST['btn-excluirConta'])) {

    try {
        $senha = trim($_POST['senhaExcluir']);

        $id = $_SESSION['dados_usuario'][1];
        $usuario = new UsuarioDB();

        if ($usuario->checarSenha($senha, $id)) {
            if ($usuario->deletarConta($id)) {
                session_destroy();
                exit(header('Location: /controlesaidas/index.php'));
            } else {
                $_SESSION['update_cad_status'] = [false, 'Erro Ao Deletar Conta!'];
                exit(header('Location: /controlesaidas/Views/pages/configs.php'));
            }
        } else {
            $_SESSION['update_cad_status'] = [false, 'Senha Incorreta!'];
            exit(header('Location: /controlesaidas/Views/pages/configs.php'));
        }
    } catch (Throwable $th) {
        $_SESSION['update_cad_status'] = [false, $th->getMessage()];
        exit(header('Location: /controlesaidas/Views/pages/configs.php'));
    }
}

function validaDados($nome, $email)
{
    if (!empty($nome) && !is_null($nome)) {
        if (!empty($email) && !is_null($email)) {
            return true;
        } else {
            throw new Exception('Campo Email Não Pode Ser Vazio!');
        }
    } else {
        throw new Exception('Campo Nome Não Pode Ser Vazio!');
    }
}
