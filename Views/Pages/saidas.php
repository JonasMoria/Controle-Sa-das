<?php
session_start();
//require_once(__DIR__ . '../../../Models/Database/DepartamentoDB.php');

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
    <title>Controle Saídas | Saídas</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/saidas.css">
</head>

<body>

    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">
        <div class="col-12">
            <h3 class="pagina-local">Saídas</h3>
        </div>
        <hr>
        <form action="../../Controllers/DepartamentoController.php" method="POST">
            <div class="col-12 row box-Funcoes">
                <div class="col-md-2 col-sm-12">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#mdlNovaSaida" class="btn btn-success btnFuncoes btnNovoSetor">NOVA SAÍDA</button>
                </div>
            </div>
        </form>
    </main>

</body>

</html>