<?php
require_once(__DIR__ . '../../../Controllers/SaidaController.php');

if (isset($_SESSION['autorizado']) != true) {
    header('Location: /controlesaidas/index.php');
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

        <div class="col-12 row mb-3">
            <div class="col-md-6 col-sm-12 box-funcoes-1">
                <button type="button" data-bs-toggle="modal" data-bs-target="#mdlNovaSaida" class="btn btn-success btnFuncoes">NOVA SAÍDA</button>
                <button type="button" class="btn bntImprimir" onclick="gerarPDF()"><img src="../../Content/icones/imprimir.svg"></button>
            </div>
            <div class="col-md-6 col-sm-12 box-funcoes-2">
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalFiltros" class="btn btn-success"><img src="../../Content/icones/filtrar.svg"> Filtros</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalPesquisas" class="btn btn-success"><img src="../../Content/icones/pesquisar.svg"> Pesquisas</button>
            </div>
        </div>

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
                    loadTable();
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
                    <form action="../../Controllers/SaidaController.php" method="post">
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
                    <form action="../../Controllers/SaidaController.php" method="post" style="width:90%;margin-left:5%;margin-right:5%;text-align:center">
                        <section class="col-12 row box-filtar-data">
                            <div class="form-group col-12 row">
                                <h5 class="modal-title mb-3">Filtrar:</h5>
                                <div class="col-3">
                                    <h6 class="btn">De:</h6>
                                </div>
                                <div class="col-3"> <input type="number" class="form-control" name="saida_dia_pesq_min" min="1" max="31" placeholder="Dia" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="saida_mes_pesq_min" min="1" max="12" placeholder="Mês" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="saida_ano_pesq_min" min="1900" placeholder="Ano" required> </div>
                            </div>
                            <div class="form-group col-12 row">
                                <div class="col-3">
                                    <h6 class="btn">Até:</h6>
                                </div>
                                <div class="col-3"> <input type="number" class="form-control" name="saida_dia_pesq_max" min="1" max="31" placeholder="Dia" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="saida_mes_pesq_max" min="1" max="12" placeholder="Mês" required> </div>
                                <div class="col-3"> <input type="number" class="form-control" name="saida_ano_pesq_max" min="1900" placeholder="Ano" required> </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" name="filtrar_entre_datas" class="btn btn-sm btn-success"> <img src="../../Content/icones/calendario.svg" alt="calendario"> filtrar por data</button>
                            </div>
                        </section>
                    </form>
                    <h5 class="modal-title text-center mt-4">Ordenar Por:</h5>
                    <form action="../../Controllers/SaidaController.php" method="post">
                        <section class="col-12 mt-3 text-center row">
                            <div class="col-4">
                                <button class="btn btn-success btn-sm" name="orderna_crescente"><img src="../../Content/icones/recente.svg">Antigo</button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-sm" name="orderna_decrescente"> <img src="../../Content/icones/antigo.svg" alt="antigo">Recente</button>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success btn-sm" name="orderna_alfabeto"> <img src="../../Content/icones/alfabetica.svg" alt="alfabética"> Alfabética</button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Modal Excluir Saída -->
    <div class="modal fade" id="mdlExcluirSaida" tabindex="-1" aria-labelledby="mdlExcluirSai" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="../../Content/icones/atencao.svg" height="50%" width="50%" alt="atencão">
                    <h3>Deseja Excluir esta Saída? Não será possível recuperá-la!</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">CANCELAR</button>
                    <form action="../../Controllers/SaidaController.php" method="POST">
                        <button type="submit" name="excluir_sai_confirm" class="btn btn-danger">EXCLUIR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    <?php if (isset($_SESSION['excluir_saida'][0]) == true) : ?>
        $(window).on('load', function() {
            $('#mdlExcluirSaida').modal('show');
        });
    <?php 
    $_SESSION['confirma_excluir'] = $_SESSION['excluir_saida'][1];
    unset($_SESSION['excluir_saida']);
    endif; ?>
</script>

</html>