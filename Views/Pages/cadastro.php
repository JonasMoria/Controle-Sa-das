<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Saidas | Cadastro </title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/cadastro.css">
</head>

<body>

    <main class="col-12 row">

        <section class="col-6 d-none d-sm-block">
            <div class="welcome">
                <h1>Cadastre-se!!</h1>
                <h6>Sistema de Controle de Saídas</h6>
                <img src="/controlesaidas/Views/Images/cadastro_logo.png" class="img-logo img-fluid" alt="Logo">
            </div>
            <div class="login">
                <h5>Já possui cadastro?</h5>
                <a href="/controlesaidas/index.php" class="btn button">Voltar para Login</a>
            </div>
        </section>

        <section class="col-md-6 col-sm-12">
            <div class="register">
                <h2 id="msg">Cadastrar</h2>
                <form method="post" action="../../Controllers/UsuarioController.php">
                    <?php
                    if (isset($_SESSION['cadastro_efetuado'])) {
                        echo "<div class='alert alert-success' role='alert'>
                               <strong>Cadastrado com sucesso!!</strong> <a href='/controlesaidas/index.php' class='alert-link'>Clique aqui para fazer Login!</a>
                              </div>";
                    }
                    if (isset($_SESSION['cadastro_falha'])) {
                        echo "<div class='alert alert-danger' role='alert'>
                               <strong>Erro no cadastro!!</strong> Tente novamente
                              </div>";
                    }
                    if (isset($_SESSION['senha_incorreta'])) {
                        echo "<div class='alert alert-danger' role='alert'>
                               <strong>Senhas Incompatíveis!!</strong> Tente novamente
                              </div>";
                    }
                    if (isset($_SESSION['cadastro_erro'])) {
                        $erro = $_SESSION['mostrar_erro'];
                        echo "<div class='alert alert-danger' role='alert'>
                               <strong>$erro!!</strong>
                              </div>";
                    }
                    unset($_SESSION['cadastro_efetuado']);
                    unset($_SESSION['cadastro_falha']);
                    unset($_SESSION['senha_incorreta']);
                    unset($_SESSION['cadastro_erro']);
                    unset($_SESSION['mostrar_erro']);
                    ?>
                    <div class="form-group">
                        <input name="name" type="text" class="form-control" id="ipntRegName" placeholder="Ex: Fulano">
                    </div>
                    <div class="form-group">
                        <input name="email" type="email" class="form-control" id="ipntRegEmail" placeholder="Ex: fulano@email.com">
                    </div>
                    <div class="form-group">
                        <input name="pass" type="password" class="form-control" id="ipntRegPass" placeholder="Senha deve conter no mínimo 8 caracteres">
                    </div>
                    <div class="form-group">
                        <input name="passRep" type="password" class="form-control" id="ipntRegRepeatPass" placeholder="Senha deve conter no mínimo 8 caracteres">
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="button btn" name="btnCadastro">CADASTRAR</button> <br><br>
                        <a href="/controlesaidas/index.php" class="btn"><strong>Voltar para Login</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

</body>

</html>