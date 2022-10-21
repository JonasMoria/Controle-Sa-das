<?php
require_once(__DIR__ . '../../../Controllers/HomeController.php');
if (isset($_SESSION['autorizado']) != true) {
    header('Location: /controlesaidas/index.php');
    exit(session_destroy());
}

$id = $_SESSION['dados_usuario'][1];
$nomeUsu = $_SESSION['dados_usuario'][0];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Saídas | Home</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/home.css">
</head>

<body>

    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">
        <div class="col-12">
            <h3 class="pagina-local">Home</h3>
        </div>
        <hr>

        <div class="col-12 row box-Home">
            <!-- Saudação -->
            <div class="col-md-12 col-sm-12 row dataHora">
                <div class="col-6 usu-saudacao">
                    <span><?php echo $nomeUsu ?></span>
                    <h6 id="saudacao" class="mt-2"></h6>
                </div>
                <div class="col-6 data-hora">
                    <div class="hora">
                        <h6 id="hora"></h6>
                        <h6 id="minuto"></h6>
                        <h6 id="segundo"></h6>
                        <h6>&NonBreakingSpace;&NonBreakingSpace;</h6>
                        <h6 id="data"></h6>
                    </div>
                </div>
            </div>

            <!-- Ultimos Chamados -->
            <div class="col-md-12 col-sm-12">
                <h6 class="text-center" style="color: darkgreen;font-weight: 600">Últimos Chamados Em Aberto</h6>
                <hr>
                <table class="table table-responsive text-center mt-3">
                    <tbody>
                        <?php
                        lastChamados($id);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>