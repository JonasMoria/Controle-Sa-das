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
    <title>Controle Saídas | Setores</title>
    <link rel="stylesheet" href="../../Content/bootstrap_v5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/departamentos.css">
    <script src="../Js/jquery.js"></script>
    <script src='../Js/departamentos.js'></script>
    <script src="../../Content/bootstrap_v5/js/bootstrap.min.js"></script>
</head>

<body>

    <nav>
        <?php require_once "../components/nav.php"; ?>
    </nav>

    <main class="page">
        <div class="col-12">
            <h3 class="pagina-local">Setores</h3>
        </div>
        <hr>
        <form action="../../Controllers/DepartamentoController.php" method="POST">
            <div class="col-12 row box-Funcoes">
                <div class="col-md-4 col-sm-12">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#mdlNovoDepartamento" class="btn btn-success btnFuncoes btnNovoSetor">NOVO SETOR</button>
                    <button type="button" id="gerarPDFDep" name="gerarPDFDep" onclick="gerarPDF()" style="background-color: rgb(233, 0, 17);" class="btn btnFuncoes"><img src="../../Content/icones/imprimir.svg" alt="baixar"></button>
                </div>

                <div class="col-md-8 col-sm-12">
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
        </form>
        <br>
        <div class="col-12 row box-msgErro">
            <?php
            if (isset($_SESSION['departamento_cadastrado'])) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                       <strong>Departamento Cadastrado!</strong>
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            if (isset($_SESSION['falha_cadastro_departamento'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Falha ao cadastrar</strong> Tente Novamente...
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            if (isset($_SESSION['erro_cadastro_departamento'])) {
                $erro = $_SESSION['mostrar_erro_departamento'];
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Erro!</strong> $erro !
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            if (isset($_SESSION['falha_excluir_departamento'])) {
                $erro = $_SESSION['mostrar_erro_exclusao'];
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                       <strong>Erro!</strong> $erro !
                       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            unset($_SESSION['departamento_cadastrado']);
            unset($_SESSION['falha_cadastro_departamento']);
            unset($_SESSION['erro_cadastro_departamento']);
            unset($_SESSION['falha_excluir_departamento']);
            unset($_SESSION['mostrar_erro_exclusao']);
            ?>
        </div>
        <!-- Tabela de Departamentos -->
        <section class="table-responsive" id="TabelaDepartamentos">
            <div id="cabecalho" style="display: none;">
                <img src="../Images/imgLogoImprimir.png" alt="imgLogoImprimir">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOME</th>
                        <th scope="col">RESPONSÁVEL</th>
                        <th scope="col">TELEFONE</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col" id="columAcoes">ACÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $id = $_SESSION['dados_usuario'][1];
                    $listar = new DepartamentoDB();

                    if (isset($_SESSION['pesquisar_departamento'])) {
                        $palavra = $_SESSION['palavra'];
                        $listar->pesquisarDepartamentos($id, $palavra);
                    } else {
                        $listar->listarDepartamentos($id);
                    }
                    unset($_SESSION['palavra']);
                    unset($_SESSION['pesquisar_departamento']);
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <!-- Modal Modal Novo Departamento -->
    <div class="modal fade" id="mdlNovoDepartamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CADASTRAR SETOR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../Controllers/DepartamentoController.php" method="post">
                        <section class="row">
                            <div class="form-group col-12">
                                <label>Nome do setor <strong style="color: red;">*</strong></label>
                                <input type="text" class="form-control" name="departamento_nome">
                            </div>
                            <div class="form-group col-12">
                                <label>Responsável pelo setor <strong style="color: red;">*</strong></label>
                                <input type="text" class="form-control" name="departamento_responsavel">
                            </div>
                            <div class="form-group col-12">
                                <label>Telefone do setor <strong style="color: red;">*</strong></label>
                                <input type="text" class="form-control" name="departamento_telefone">
                            </div>
                            <div class="form-group col-12">
                                <label>Email do setor <strong style="color: red;">*</strong></label>
                                <input type="email" class="form-control" name="departamento_email">
                            </div>
                        </section>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CANCELAR</button>
                            <button type="submit" name="salvar_setor" class="btn btn-success">SALVAR</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Excluir Departamento -->
    <div class="modal fade" id="mdlExcluirDep" tabindex="-1" aria-labelledby="mdlExcluirDep" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="../../Content/icones/atencao.svg" height="50%" width="50%" alt="atencão">
                    <h3>Deseja Excluir este departamento? Não será possível recuperá-lo!</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">CANCELAR</button>
                    <form action="../../Controllers/DepartamentoController.php" method="POST">
                        <button type="submit" name="excluir_confirm" class="btn btn-danger">EXCLUIR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<script>
    <?php if (isset($_SESSION['excluir_departamento'])) : ?>
        $(window).on('load', function() {
            $('#mdlExcluirDep').modal('show');
        });
    <?php unset($_SESSION['excluir_departamento']);
    endif; ?>
</script>

</html>