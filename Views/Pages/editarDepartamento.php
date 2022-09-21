<?php
session_start();
require_once(__DIR__ . '../../../Models/Database/DepartamentoDB.php');

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
    <title>Controle Saídas | Editar Setor</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <script src="../../Content/bootstrap_v5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Css/editarDepartamento.css">
</head>

<body>


    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">
        <div class="col-12">
            <h3 class="pagina-local">Editar Setor</h3>
        </div>
        <hr>

        <section class="box-editarDepartamento">
            <form action="../../Controllers/DepartamentoController.php" method="POST">
                <?php
                if (isset($_SESSION['departamento_editado'])) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Departamento Editado!</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
                }
                if (isset($_SESSION['falha_edicao_departamento'])) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Falha ao cadastrar</strong> Tente Novamente...
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                }
                if (isset($_SESSION['erro_editar_departamento'])) {
                    $erro = $_SESSION['mostrar_erro_departamentoE'];
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Erro!</strong> $erro !
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                }
                $id = $_SESSION['getIdDep'];
                $listar = new DepartamentoDB();
                $listar->CarregarDadosDepartamento($id);
                unset($_SESSION['erro_editar_departamento']);
                unset($_SESSION['mostrar_erro_departamentoE']);
                unset($_SESSION['falha_edicao_departamento']);
                unset($_SESSION['departamento_editado']);
                ?>
                <div class="box-botoesAcao">
                    <a class="btn btn-danger" href="departamentos.php">VOLTAR</a>
                    <button type="submit" name="editar_confirm" class="btn btn-success">SALVAR</button>
                </div>
            </form>
        </section>

    </main>

</body>

</html>