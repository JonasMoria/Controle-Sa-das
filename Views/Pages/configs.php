<?php
session_start();
require_once(__DIR__ . '../../../Models/Database/usuarioDB.php');

if (isset($_SESSION['autorizado']) != true) {
    header('Location: /controlesaidas/index.php');
    exit(session_destroy());
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Saídas | Configurações</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/configs.css">
    <script src="../Js/jquery.js"></script>
    <script src="../../Content/bootstrap_v5/js/bootstrap.min.js"></script>
</head>

<body>

    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">

        <div class="col-12">
            <h3 class="pagina-local">Configurações</h3>
        </div>
        <hr>

        <section class="col-12 row box-configs">

            <div class="minhaConta col-md-6 col-sm-10" style="margin-right: 4%">
                <form action="../../Controllers/UsuarioController.php" method="post">
                    <div class="col-12 row">
                        <div class="col-12 text-center">
                            <h5>Meu Perfil</h5>
                            <hr>
                        </div>
                        <div class="col-4 box-img-conta">
                            <img src="../../Content/icones/conta.svg" class="img-conta" alt="conta" style="width: 100%;">
                        </div>
                        <div class="col-8">
                            <input type="text" value="nome" class="input-conta">
                            <input type="text" value="email" class="input-conta">
                            <button class="btn btn-sm btn-alterarDados" style="background-color:#4682B4; color:white;" name="btn-alterarDados">Alterar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="minhaConta minhaContaSeg col-md-5 col-sm-10">
                <form action="../../Controllers/UsuarioController.php" method="post">
                    <div class="col-12 row">
                        <div class="col-12 text-center">
                            <h5>Segurança</h5>
                            <hr>
                        </div>
                        <div class="col-4 box-img-conta">
                            <img src="../../Content/icones/seguranca.svg" class="img-conta" alt="conta" style="width: 100%;">
                        </div>
                        <div class="col-8">
                            <input type="password" class="input-conta" placeholder="Senha Antiga" name="senhaAntiga" required>
                            <input type="password" class="input-conta" placeholder="Nova Senha" name="senhaNova" required>
                            <input type="password" class="input-conta" placeholder="Confirma Senha" name="confNovaSenha" required>
                            <button class="btn btn-sm btn-alterarDados" style="background-color: #1E90FF; color: white" name="btn-alterarSenha">Alterar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="minhaConta col-md-5 col-sm-10" style="margin-top: 4%; margin-right:5%;">
                <form action="../../Controllers/UsuarioController.php" method="post">
                    <div class="col-12 row">
                        <div class="col-12 text-center">
                            <h5>Backup</h5>
                            <hr>
                        </div>
                        <div class="col-5 box-img-conta">
                            <img src="../../Content/icones/backup.svg" class="img-conta" alt="conta" style="width: 40%;">
                        </div>
                        <div class="col-7" style="margin-top: 2%;">
                            <button class="btn btn-sm btn-alterarDados" style="background-color:#229954; color:white;" name="btn-backup">Fazer backup</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="minhaConta col-md-6 col-sm-10" style="margin-top: 4%;">
                <div class="col-12 row">
                    <div class="col-12 text-center">
                        <h5>Excluir Conta</h5>
                        <hr>
                    </div>
                    <div class="col-5 box-img-conta">
                        <img src="../../Content/icones/excluir-conta.svg" class="img-conta" alt="conta" style="width: 30%;">
                    </div>
                    <div class="col-7" style="margin-top: 2%;">
                        <button class="btn btn-sm btn-alterarDados" style="background-color:#CB4335; color:white;" data-bs-toggle="modal" data-bs-target="#mdlExcluir">Excluir Conta</button>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <!-- Modal Confirmar Excluir Conta -->
    <div class="modal fade" id="mdlExcluir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="../../Controllers/UsuarioController.php" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">EXCLUIR CONTA</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 text-center">
                            <p class="fs-4">Tem certeza que deseja excluir esta conta? Todos os dados serão excluídos.</p>
                        </div>
                        <input type="password" name="senhaExcluir" class="form-control text-center" placeholder="digite sua senha..." required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" name="btn-excluir">Excluir Conta</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

</html>