<?php
require_once(__DIR__ . '../../../Controllers/ChamadoController.php');

if (isset($_SESSION['autorizado']) != true) {
    header('Location: /controlechamados/index.php');
    exit(session_destroy());
}
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Saídas | Chamados</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/chamados.css">
    <script src="../Js/jquery.js"></script>
    <script src='../Js/chamados.js'></script>
    <script src="../../Content/bootstrap_v5/js/bootstrap.min.js"></script>
</head>

<body>

    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">

        <div class="col-12">
            <h3 class="pagina-local">Chamados</h3>
        </div>
        <hr>

        <div class="col-12 row mb-3">
            <div class="col-md-6 col-sm-12 box-funcoes-1">
                <button type="button" data-bs-toggle="modal" data-bs-target="#mdlNovoChamado" class="btn btn-success btnFuncoes">NOVO CHAMADO</button>
                <button type="button" class="btn bntImprimir" onclick="gerarPDF()"><img src="../../Content/icones/imprimir.svg"></button>
            </div>
            <div class="col-md-6 col-sm-12 box-funcoes-2">
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalFiltros" class="btn btn-success"><img src="../../Content/icones/filtrar.svg"> Filtros</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalPesquisas" class="btn btn-success"><img src="../../Content/icones/pesquisar.svg"> Pesquisas</button>
            </div>
        </div>

        <div class="col-12 row box-msgErro">
            <?php
            if (isset($_SESSION['chamado_status'])) {

                $status = $_SESSION['chamado_status'][0];

                if ($status == true) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Chamado Cadastrado!</strong>
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                } else {
                    $erro = $_SESSION['chamado_status'][1];
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Erro!</strong> $erro
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                }
            }
            unset($_SESSION['chamado_status']);
            ?>
        </div>

        <!-- Tabela de Chamados -->
        <section class="table-responsive" id="TabelaChamados">
            <div id="cabecalho" style="display: none;">
                <img src="../Images/imgLogoImprimir.png" alt="imgLogoImprimir">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">DATA</th>
                        <th scope="col">PRODUTO</th>
                        <th scope="col">OBS</th>
                        <th scope="col">SETOR</th>
                        <th scope="col">STATUS</th>
                        <th scope="col" id="columAcoes">ACÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_SESSION['dados_usuario'][1];
                    loadTable($id);
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Modal Pesquisas -->
    <div class="modal fade" id="modalPesquisas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pesquisar Por:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../Controllers/ChamadoController.php" method="post">
                        <!-- Pesquisa por ID -->
                        <div class="form-group col-12 row">
                            <div class="col-9">
                                <input type="number" name="pesquisa_id" class="form-control" placeholder="ID">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-success" name="pesquisa_por_id"><img src="../../Content/icones/pesquisar.svg" alt=""></button>
                            </div>
                        </div>
                        <hr>
                        <!-- Pesquisa por Data -->
                        <div class="form-group col-12 row">
                            <div class="col-9 row">
                                <div class="form-group row">
                                    <div class="col-4"> <input type="number" class="form-control" name="pesquisa_dia" min="1" max="31" placeholder="Dia"> </div>
                                    <div class="col-4"> <input type="number" class="form-control" name="pesquisa_mes" min="1" max="12" placeholder="Mês"> </div>
                                    <div class="col-4"> <input type="number" class="form-control" name="pesquisa_ano" min="1900" placeholder="Ano"> </div>
                                </div>
                            </div>
                            <div class="col-3 text-center">
                                <button class="btn btn-success" name="pesquisa_por_data"><img src="../../Content/icones/pesquisar.svg" alt=""></button>
                            </div>
                        </div>
                        <hr>
                        <!-- Pesquisa por Departamento -->
                        <div class="form-group col-12 row">
                            <div class="col-9">
                                <input type="text" class="form-control" name="pesquisa_departamento" placeholder="Setor">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-success" name="pesquisa_por_departamento"><img src="../../Content/icones/pesquisar.svg" alt=""></button>
                            </div>
                        </div>
                        <hr>
                        <!-- Pesquisa por Produto -->
                        <div class="form-group col-12 row">
                            <div class="col-9">
                                <input type="text" class="form-control" name="pesquisa_produto" placeholder="Produto">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-success" name="pesquisa_por_produto"><img src="../../Content/icones/pesquisar.svg" alt=""></button>
                            </div>
                        </div>
                        <hr>
                        <!-- Pesquisa por Observação -->
                        <div class="form-group col-12 row">
                            <div class="col-9">
                                <input type="text" class="form-control" name="pesquisa_observacao" placeholder="Observação">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-success" name="pesquisa_por_observacao"><img src="../../Content/icones/pesquisar.svg" alt=""></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Filtros -->
    <div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltros" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../Controllers/ChamadoController.php" method="post" style="width:90%;margin-left:5%;margin-right:5%;text-align:center">
                        <section class="col-12 row box-filtar-data">
                            <div class="form-group col-12 row">
                                <h5 class="modal-title mb-3">Filtrar:</h5>
                                <div class="col-3">
                                    <h6 class="btn">De:</h6>
                                </div>
                                <div class="col-3"> <input type="number" class="form-control" name="chamado_dia_pesq_min" min="1" max="31" placeholder="Dia" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="chamado_mes_pesq_min" min="1" max="12" placeholder="Mês" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="chamado_ano_pesq_min" min="1900" placeholder="Ano" required> </div>
                            </div>
                            <div class="form-group col-12 row">
                                <div class="col-3">
                                    <h6 class="btn">Até:</h6>
                                </div>
                                <div class="col-3"> <input type="number" class="form-control" name="chamado_dia_pesq_max" min="1" max="31" placeholder="Dia" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="chamado_mes_pesq_max" min="1" max="12" placeholder="Mês" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="chamado_ano_pesq_max" min="1900" placeholder="Ano" required> </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" name="filtrar_entre_datas" class="btn btn-sm btn-success"> <img src="../../Content/icones/calendario.svg" alt="calendario"> filtrar por data</button>
                            </div>
                        </section>
                    </form>
                    <h5 class="modal-title text-center mt-4">Ordenar Por:</h5>
                    <form action="../../Controllers/ChamadoController.php" method="post">
                        <section class="col-12 mt-3 text-center row">
                            <div class="col-4">
                                <button class="btn btn-success btn-sm" name="ordena_crescente"><img src="../../Content/icones/recente.svg">Antigo</button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-sm" name="ordena_decrescente"> <img src="../../Content/icones/antigo.svg" alt="antigo">Recente</button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-sm" name="ordena_alfabeto"> <img src="../../Content/icones/alfabetica.svg" alt="alfabética"> Alfabética</button>
                            </div>
                        </section>
                        <section class="col-12 row text-center mt-3">
                            <div class="col-6">
                                <button class="btn btn-success btn-sm" name="ordena_abertos"> <img src="../../Content/icones/andamento.svg" alt="abertos"> Em Aberto</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-success btn-sm" name="ordena_fechados"> <img src="../../Content/icones/concluido.svg" alt="fechados"> Fechados</button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Novo Chamado -->
    <div class="modal fade" id="mdlNovoChamado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LANÇAR CHAMADO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../Controllers/ChamadoController.php" method="post">
                        <section class="row">
                            <div class="col-12 row">
                                <div class="form-group col-4">
                                    <label>Dia<strong style="color: red;">*</strong></label>
                                    <input type="number" class="form-control" name="chamado_dia" min="1" max="31" required>
                                </div>
                                <div class="form-group col-4">
                                    <label>Mês<strong style="color: red;">*</strong></label>
                                    <input type="number" class="form-control" name="chamado_mes" min="1" max="12" required>
                                </div>
                                <div class="form-group col-4">
                                    <label>Ano<strong style="color: red;">*</strong></label>
                                    <input type="number" class="form-control" name="chamado_ano" min="1900" required>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Departamento<strong style="color: red;">*</strong></label>
                                <select class="form-select" name="chamado_departamento" aria-label="Default select example" required>
                                    <option selected value="0" disabled>Selecione Um Departamento</option>
                                    <?php
                                    listarDepartamentos($_SESSION['dados_usuario'][1]);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Produto<strong style="color: red;">*</strong></label>
                                <input type="text" class="form-control" name="chamado_produto" required>
                            </div>
                            <div class="form-group col-12">
                                <label>Observação Técnica<strong style="color: red;">*</strong></label>
                                <textarea type="text" class="form-control" name="chamado_observacao" required></textarea>
                            </div>
                        </section>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCELAR</button>
                            <button type="submit" name="salvar_chamado" class="btn btn-success">SALVAR</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    let sts = document.getElementById('td-status').value;
    let bgStatus = document.getElementById('td-status').style.color;

    if (sts == 'em aberto') {
        bgStatus = 'red';
    } else {

    }
</script>

</html>