<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Saídas | Login </title>
    <link rel="stylesheet" href="Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="Views/Css/index.css">
</head>

<body>

    <main class="col-12 row">

        <section class="col-6 d-none d-sm-block">
            <div class="welcome">
                <h1>Olá! Bem Vindo(a)</h1>
                <h6>Sistema de Controle de Saídas</h6>
                <img src="Views/Images/index_logo.png" class="img-logo img-fluid" alt="Logo">
            </div>
            <div class="register">
                <h5>Ainda não possui cadastro?</h5>
                <a href="Views/Pages/cadastro.php" class=" button btn">Cadastrar</a>
            </div>
        </section>

        <section class="col-md-6 col-sm-12">
            <div class="login">
                <h2>Entrar</h2>
                <form method="POST" action="Controllers/UsuarioController.php">
                    <?php
                    if (isset($_SESSION['login_falha'])) {
                        echo "<div class='alert alert-danger' role='alert'>
                               <strong>Usuário ou Senha Inválidos</strong>, Tente Novamente
                              </div>";
                    }
                    if (isset($_SESSION['login_erro'])) {
                        $erro = $_SESSION['mostrar_erro'];
                        echo "<div class='alert alert-danger' role='alert'>
                                $erro
                             </div>";
                    }
                    unset($_SESSION['login_falha']);
                    unset($_SESSION['login_erro']);
                    unset($_SESSION['mostrar_erro']);
                    ?>
                    <div class="col-12 my-2">
                        <div class="input-group">
                            <input type="email" class="form-control" name="inptUser" id="inptUser" placeholder="Usuário">
                        </div>
                    </div>
                    <div class="col-12 my-3">
                        <div class="input-group">
                            <input type="password" name="inptPass" class="form-control" id="intpPass" placeholder="Senha">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" name="btnLogin" class="button btn">LOGIN</button> <br><br>
                        <a href="Views/Pages/cadastro.php" class="btn"> <strong>Cadastrar</a>
                    </div>
                </form>
            </div>
        </section>

    </main>

</body>

</html>