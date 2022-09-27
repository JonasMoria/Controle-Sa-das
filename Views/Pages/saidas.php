<?php
session_start();
require_once(__DIR__ . '../../../Models/Database/SaidaDB.php');

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
    <script src="../Js/jquery.js"></script>
    <script src='../Js/saidas.js'></script>
    <script src="../../Content/bootstrap_v5/js/bootstrap.min.js"></script>
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
                    <button type="button" data-bs-toggle="modal" data-bs-target="#mdlNovaSaida" class="btn btn-success btnFuncoes">NOVA SAÍDA</button>
                </div>
                <div class="col-md-1 col-sm-12">
                    <button type="button" class="btn bntImprimir" onclick="gerarPDF()"><img src="../../Content/icones/imprimir.svg"></button>
                </div>
                <div class="col-md-2 col-sm-12">
                    <button type="button" data-bs-toggle="modal" class="btn btn-success"><img src="../../Content/icones/filtrar.svg">  Filtros</button>
                </div>
                <div class="col-md-7 col-sm-12">
                    <div class="row g-3 align-items-center inputPesquisa">
                        <div class="col-auto">
                            <label class="col-form-label">PESQUISAR: </label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="palavraPesquisar" class="form-control" placeholder="Pesquisar...">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="btnPesquisar" class="btn btn-success btnPesquisar"><img src="../../Content/icones/pesquisar.svg" alt=""></button>
                        </div>
                    </div>
                </div>
            </div>
        </form><br>
        <div class="col-12 row box-msgErro">
            <?php
            if (isset($_SESSION['saida_cadastrada'])) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                               <strong>Saída Cadastrada!</strong>
                               <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                              </div>";
            }
            if (isset($_SESSION['falha_cadastro_saidas'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Falha ao Cadastrar</strong> Tente Novamente...
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            if (isset($_SESSION['erro_cadastro_saida'])) {
                $erro = $_SESSION['mostrar_erro_saida'];
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Erro!</strong> $erro!
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            unset($_SESSION['saida_cadastrada']);
            unset($_SESSION['falha_cadastro_saidas']);
            unset($_SESSION['erro_cadastro_saida']);
            unset($_SESSION['mostrar_erro_saida']);
            ?>
        </div>
        <!-- Tabela de Saídas -->
        <section class="table-responsive" id="TabelaSaidas">
            <div id="cabecalho" style="display: none;">
                <img src="../Images/imgLogoImprimir.png" alt="imgLogoImprimir">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">DATA</th>
                        <th scope="col">DEPT.</th>
                        <th scope="col">RESP.</th>
                        <th scope="col">PRODUTO</th>
                        <th scope="col">OBS</th>
                        <th scope="col" id="columAcoes">ACÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_SESSION['dados_usuario'][1];
                    $listar = new SaidaDB();
                    $listar->listarSaidas($id);
                    ?>
                </tbody>
            </table>
        </section>
    </main>


    <!-- Modal Modal Nova Saída -->
    <div class="modal fade" id="mdlNovaSaida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CADASTRAR SAÍDA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../Controllers/SaidaController.php" method="post">
                        <section class="row">
                            <div class="col-12 row">
                                <div class="form-group col-4">
                                    <label>Dia<strong style="color: red;">*</strong></label>
                                    <input type="number" class="form-control" name="saida_dia" min="1" max="31" required>
                                </div>
                                <div class="form-group col-4">
                                    <label>Mês<strong style="color: red;">*</strong></label>
                                    <input type="number" class="form-control" name="saida_mes" min="1" max="12" required>
                                </div>
                                <div class="form-group col-4">
                                    <label>Ano<strong style="color: red;">*</strong></label>
                                    <input type="number" class="form-control" name="saida_ano" min="1900" required>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Departamento<strong style="color: red;">*</strong></label>
                                <select class="form-select" name="saida_departamento" aria-label="Default select example" required>
                                    <option selected value="0" disabled>Selecione Um Departamento</option>
                                    <?php
                                    $id = $_SESSION['dados_usuario'][1];
                                    $saidaDB = new SaidaDB();
                                    $saidaDB->listarDepartamentos($id);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Produto<strong style="color: red;">*</strong></label>
                                <input type="text" class="form-control" name="saida_produto" required>
                            </div>
                            <div class="form-group col-12">
                                <label>Observação<strong style="color: red;">*</strong></label>
                                <textarea type="text" class="form-control" name="saida_observacao" required></textarea>
                            </div>
                        </section>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCELAR</button>
                            <button type="submit" name="salvar_saida" class="btn btn-success">SALVAR</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>