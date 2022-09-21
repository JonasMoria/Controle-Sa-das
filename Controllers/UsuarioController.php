<?php

require('../Models/Usuario.php');
require('../Models/Database/UsuarioDB.php');

session_start();
    
    // Cadastro
    if (isset($_POST['btnCadastro']) ) {
      
        try {      
            $usuario = new Usuario();
            $usuarioDB = new UsuarioDB();

            $usuario->setNome(trim($_POST['name']));
            $usuario->setEmail(strtoupper(trim($_POST['email'])));
            $usuario->setSenha(trim($_POST['pass']));
            $usuarioPass = $_POST['passRep'];

            if ($usuario->verificaSenha($usuarioPass,$usuario->getSenha())) {
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
        
       try{
        
        $usuario = new Usuario();
        $usuarioDB = new UsuarioDB();
    
        $email = strtoupper(trim($_POST['inptUser']));
        $senha  = trim($_POST['inptPass']);

        if($usuarioDB->login($email,$senha)) {
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
       } catch(Exception $erro) {
         $_SESSION['login_erro'] = true;
         $_SESSION['mostrar_erro'] = $erro->getMessage();
         header('Location: /controlesaidas/index.php');
         exit;
       }

    }

    
