<?php

require_once(__DIR__ . '../../Saida.php');
require_once(__DIR__ . '../../Database/ConnectionDB.php');

class SaidaDB
{

    // Cadastro de Saídas
    function cadastrarSaida(Saida $saida, $id)
    {

        $connect = new ConnectionDB();

        $dia = mysqli_real_escape_string($connect->connect(), $saida->getDia());
        $mes = mysqli_real_escape_string($connect->connect(), $saida->getMes());
        $ano = mysqli_real_escape_string($connect->connect(), $saida->getAno());
        $departamento = mysqli_real_escape_string($connect->connect(), $saida->getDepartamento());
        $produto = mysqli_real_escape_string($connect->connect(), $saida->getProduto());
        $observacao = mysqli_real_escape_string($connect->connect(), $saida->getObservacao());

        $data = $ano . "-" . $mes . "-" . $dia;
        $query = "insert into saidas(usu_id,sai_data,sai_departamento,sai_produto,sai_observacao) VALUES ($id,'$data','$departamento','$produto','$observacao' )";

        if (mysqli_query($connect->connect(), $query)) {
            return true;
        } else {
            throw new Exception('Falha ao Cadastrar Saída!!');
        }
    }

    //Selecionar Departamento na Modal
    function listarDepartamentos($id)
    {
        $connect = new ConnectionDB();
        $query = "select dep_id,dep_nome from departamentos where usu_id = $id order by dep_nome";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {
            do {
                $id = $list['dep_id'];
                $nome = $list['dep_nome'];
                echo "<option value='$nome'>$nome</option>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    //Listar Saidas
    function listarSaidas($id)
    {

        $connect = new ConnectionDB();
        $query = "select sai_id,sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data =  date('d/m/Y',  strtotime($list['sai_data']));
                $departamento = $list['sai_departamento'];
                $produto = $list['sai_produto'];
                $observacao = $list['sai_observacao'];

                // Buscando Responsável pelo departamento
                $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                $resultado = mysqli_query($connect->connect(), $queryResp);
                $responsavel = mysqli_fetch_assoc($resultado);
                $responsavel = $responsavel['dep_responsavel'];

                echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Filtrar Entre Datas
    function filtrarDatas($data1, $data2, $id)
    {

        $connect = new ConnectionDB();
        $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where sai_data BETWEEN '$data1' AND '$data2' and usu_id = $id";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data = date('d/m/Y',  strtotime($list['sai_data']));
                $departamento = $list['sai_departamento'];
                $produto = $list['sai_produto'];
                $observacao = $list['sai_observacao'];

                // Buscando Responsável pelo departamento
                $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                $resultado = mysqli_query($connect->connect(), $queryResp);
                $responsavel = mysqli_fetch_assoc($resultado);
                $responsavel = $responsavel['dep_responsavel'];

                echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        } else {
            throw new Exception('Nenhuma Saída Encontrada Ou Datas Incorretas. Tente Novamente..!!', 1);
        }
    }

    // Ordenar Em Ordem Crescente
    function ordenaCrescente($id)
    {

        $connect = new ConnectionDB();
        $query = "select sai_id,sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_data asc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data = date('d/m/Y',  strtotime($list['sai_data']));
                $departamento = $list['sai_departamento'];
                $produto = $list['sai_produto'];
                $observacao = $list['sai_observacao'];

                // Buscando Responsável pelo departamento
                $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                $resultado = mysqli_query($connect->connect(), $queryResp);
                $responsavel = mysqli_fetch_assoc($resultado);
                $responsavel = $responsavel['dep_responsavel'];

                echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar Mais Novo para Mais Antigo
    function ordenaDecrescente($id)
    {

        $connect = new ConnectionDB();
        $query = "select sai_id,sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data = date('d/m/Y',  strtotime($list['sai_data']));
                $departamento = $list['sai_departamento'];
                $produto = $list['sai_produto'];
                $observacao = $list['sai_observacao'];

                // Buscando Responsável pelo departamento
                $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                $resultado = mysqli_query($connect->connect(), $queryResp);
                $responsavel = mysqli_fetch_assoc($resultado);
                $responsavel = $responsavel['dep_responsavel'];

                echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar Em Ordem Alfabática
    function ordenaAlfabetico($id)
    {

        $connect = new ConnectionDB();
        $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_departamento ";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data = date('d/m/Y',  strtotime($list['sai_data']));
                $departamento = $list['sai_departamento'];
                $produto = $list['sai_produto'];
                $observacao = $list['sai_observacao'];

                // Buscando Responsável pelo departamento
                $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                $resultado = mysqli_query($connect->connect(), $queryResp);
                $responsavel = mysqli_fetch_assoc($resultado);
                $responsavel = $responsavel['dep_responsavel'];

                echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    //Pesquisa Por ID
    function pesquisaID($id, $idSaida)
    {
        try {
            $connect = new ConnectionDB();
            $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id and sai_id = $idSaida";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   =  $list['sai_id'];
                    $data = date('d/m/Y',  strtotime($list['sai_data']));
                    $departamento = $list['sai_departamento'];
                    $produto = $list['sai_produto'];
                    $observacao = $list['sai_observacao'];

                    // Buscando Responsável pelo departamento
                    $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                    $resultado = mysqli_query($connect->connect(), $queryResp);
                    $responsavel = mysqli_fetch_assoc($resultado);
                    $responsavel = $responsavel['dep_responsavel'];

                    echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>ID Informado Incorretamente</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
    }

    //Pesquisa Por Data
    function pesquisaData($id, $dataSaida)
    {
        try {

            $connect = new ConnectionDB();
            $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id and sai_data = '$dataSaida'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   =  $list['sai_id'];
                    $data = date('d/m/Y',  strtotime($list['sai_data']));
                    $departamento = $list['sai_departamento'];
                    $produto = $list['sai_produto'];
                    $observacao = $list['sai_observacao'];

                    // Buscando Responsável pelo departamento
                    $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                    $resultado = mysqli_query($connect->connect(), $queryResp);
                    $responsavel = mysqli_fetch_assoc($resultado);
                    $responsavel = $responsavel['dep_responsavel'];

                    echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Data Informada Incorretamente</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
    }

    //Pesquisa Por Departamento
    function pesquisaDepartamento($id, $departamento)
    {
        try {

            $connect = new ConnectionDB();
            $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id and sai_departamento like '%$departamento%'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   =  $list['sai_id'];
                    $data = date('d/m/Y',  strtotime($list['sai_data']));
                    $departamento = $list['sai_departamento'];
                    $produto = $list['sai_produto'];
                    $observacao = $list['sai_observacao'];

                    // Buscando Responsável pelo departamento
                    $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                    $resultado = mysqli_query($connect->connect(), $queryResp);
                    $responsavel = mysqli_fetch_assoc($resultado);
                    $responsavel = $responsavel['dep_responsavel'];

                    echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Setor Informado Incorretamente</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
    }

    //Pesquisa Por Produto
    function pesquisaProduto($id, $produto)
    {
        try {
            $connect = new ConnectionDB();
            $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as 
            sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id and sai_produto like '%$produto%'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   =  $list['sai_id'];
                    $data = date('d/m/Y',  strtotime($list['sai_data']));
                    $departamento = $list['sai_departamento'];
                    $produto = $list['sai_produto'];
                    $observacao = $list['sai_observacao'];

                    // Buscando Responsável pelo departamento
                    $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                    $resultado = mysqli_query($connect->connect(), $queryResp);
                    $responsavel = mysqli_fetch_assoc($resultado);
                    $responsavel = $responsavel['dep_responsavel'];

                    echo " <tr>
                            <th scope='row'>$Id</th>
                            <td>$data</td>
                            <td>$departamento</td>
                            <td>$responsavel</td>
                            <td>$produto</td>
                            <td class='table-observacao'>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Setor Informado Incorretamente</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
    }

    //Pesquisa Por Observação
    function pesquisaObservacao($id, $observacao)
    {
        try {
            $connect = new ConnectionDB();
            $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as 
            sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id and sai_observacao like '%$observacao%'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   =  $list['sai_id'];
                    $data = date('d/m/Y',  strtotime($list['sai_data']));
                    $departamento = $list['sai_departamento'];
                    $produto = $list['sai_produto'];
                    $observacao = $list['sai_observacao'];

                    // Buscando Responsável pelo departamento
                    $queryResp = "select dep_responsavel from departamentos where dep_nome = '$departamento' and usu_id = $id";
                    $resultado = mysqli_query($connect->connect(), $queryResp);
                    $responsavel = mysqli_fetch_assoc($resultado);
                    $responsavel = $responsavel['dep_responsavel'];

                    echo " <tr>
                                <th scope='row'>$Id</th>
                                <td>$data</td>
                                <td>$departamento</td>
                                <td>$responsavel</td>
                                <td>$produto</td>
                                <td class='table-observacao'>$observacao</td>
                                <td class='col-12 row ocultarImprimir'>
                                    <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btn-sm btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                    <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                                </td>
                                </tr>";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Setor Informado Incorretamente</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
    }

    //Carregar Dados Saida
    function CarregarDadosSaida($id)
    {
        $connect = new ConnectionDB();
        $query = "select day(sai_data) as dia, month(sai_data) as mes, year(sai_data) as ano,sai_departamento,sai_produto,sai_observacao from saidas where sai_id = $id";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        $dados = [];

        if ($total > 0) {
            do {

                $dia = $list['dia'];
                $mes = $list['mes'];
                $ano = $list['ano'];
                $dep = $list['sai_departamento'];
                $produto = $list['sai_produto'];
                $obs = $list['sai_observacao'];

                $dados = [$dia, $mes, $ano, $dep, $produto, $obs];
            } while ($list = mysqli_fetch_assoc($result));
        }

        $_SESSION['dados_saida_E'] = $dados;
    }

    //Alterar Dados da Saída
    function alterarSaida(Saida $saida, $id)
    {

        try {

            $connect = new ConnectionDB();

            $dia = mysqli_real_escape_string($connect->connect(), $saida->getDia());
            $mes = mysqli_real_escape_string($connect->connect(), $saida->getMes());
            $ano = mysqli_real_escape_string($connect->connect(), $saida->getAno());
            $departamento = mysqli_real_escape_string($connect->connect(), $saida->getDepartamento());
            $produto = mysqli_real_escape_string($connect->connect(), $saida->getProduto());
            $obs = mysqli_real_escape_string($connect->connect(), $saida->getObservacao());

            $data = $ano . "-" . $mes . "-" . $dia;

            $sql = "update saidas set sai_departamento = '$departamento', sai_data = '$data', sai_produto = '$produto',
            sai_observacao = '$obs' where sai_id = $id";

            if (mysqli_query($connect->connect(), $sql)) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $th) {
            throw new Exception('Valores Inválidos, Insira Novamente!');
        }
    }

    // Deletar Uma Saída
    function deletarSaida($idSaida, $id)
    {

        try {

            $connect = new ConnectionDB();
            $query = "delete from saidas where sai_id = $idSaida and usu_id = $id";

            if (mysqli_query($connect->connect(), $query)) {
                return true;
            } else {
                throw new Exception('Falha ao Excluir Saída!!');
            }
        } catch (mysqli_sql_exception $th) {
            throw new Exception('Falha ao Excluir Saída!!');
        }
    }
}
