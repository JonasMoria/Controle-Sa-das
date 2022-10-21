<?php
session_start();

if (isset($_SESSION['autorizado']) != true) {
    header('Location: /controlechamados/index.php');
    exit(session_destroy());
}

require_once(__DIR__ . '../../../Models/Database/ChamadoDB.php');
$chamadoDB = new ChamadoDB();
$id = $_SESSION['dados_usuario'][1];
$chamadoDB->CarregarDadosChamado($_SESSION['getIdDep']);

if (isset($_SESSION['dados_chamado_E'])) {
    $dados = $_SESSION['dados_chamado_E'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Saídas | Editar Chamados</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <script src="../../Content/bootstrap_v5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../Css/editarChamado.css">
</head>

<body>

    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">
        <div class="col-12">
            <h3 class="pagina-local">Editar Chamados</h3>
        </div>
        <hr>
        <section class="box-editarChamado">
            <form action="../../Controllers/ChamadoController.php" method="POST">
                <?php

                if (isset($_SESSION['chamado_status']) && $_SESSION['chamado_status'][0] == true) {
                    $msg = $_SESSION['chamado_status'][1];
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                       <strong>$msg</strong>
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                }
                if (isset($_SESSION['chamado_status']) && $_SESSION['chamado_status'][0] == false) {
                    $erro = $_SESSION['chamado_status'][1];
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                       <strong>$erro</strong>
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                }

                unset($_SESSION['chamado_status']);
                ?>
                <section class='form-group col-12 row'>

                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <label><strong>Data</strong></label>
                            <div class='col-4'> <input type='number' class='form-control' name='chamado_diaE' min='1' max='31' value="<?php echo $dados[0] ?>"> </div>
                            <div class='col-4'> <input type='number' class='form-control' name='chamado_mesE' min='1' max='12' value="<?php echo $dados[1] ?>"> </div>
                            <div class='col-4'> <input type='number' class='form-control' name='chamado_anoE' min='1900' value="<?php echo $dados[2] ?>"> </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class='form-group col-12'>
                            <label><strong>Departamento</strong></label>
                            <select class="form-select" name="chamado_departamentoE" aria-label="Default select example">
                                <option value="<?php echo $dados[3] ?>"><?php echo $dados[3] ?></option>
                                <?php
                                $chamadoDB->listarDepartamentos($id);
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class='form-group col-12'>
                            <label><strong>Produto</strong></label>
                            <input type='text' class='form-control' name='chamado_produtoE' value="<?php echo $dados[4] ?>">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="col-12 row">
                            <div class='col-md-8 col-sm-12'>
                                <label><strong>Status</strong></label>
                                <input type='text' disabled class='form-control' name='chamado_observacaoE' value="<?php echo $dados[6] ?>">
                            </div>
                            <div class='col-md-4 col-sm-12'>
                                <div class="btn-acao"><button type="submit" name="btn_fechar_chamado" class="btn btn-dark" style="width: 100%; margin-top:10%;">Fechar Chamado</button></div>
                            </div>
                        </div>
                    </div>

                    <div class='form-group col-12'>
                        <label><strong>Observação</strong></label>
                        <input type='text' class='form-control' name='chamado_observacaoE' value="<?php echo $dados[5] ?>">
                    </div>
                </section>
        </section>
        <div class="box-botoesAcao col-12 row">
            <div class="col-6"><a class="btn btn-danger" href="chamados.php">VOLTAR</a></div>
            <div class="col-6"><button type="submit" name="editar_confirm" class="btn btn-success">SALVAR</button></div>
        </div>
        </form>
    </main>

</body>

</html>