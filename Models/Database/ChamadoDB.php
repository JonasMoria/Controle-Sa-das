<?php

require_once(__DIR__ . '../../Chamado.php');
require_once(__DIR__ . '../../Database/ConnectionDB.php');

class ChamadoDB
{

    function lancarChamado(Chamado $chamado, $id)
    {

        $connect = new ConnectionDB();

        $dia = mysqli_real_escape_string($connect->connect(), $chamado->getDia());
        $mes = mysqli_real_escape_string($connect->connect(), $chamado->getMes());
        $ano = mysqli_real_escape_string($connect->connect(), $chamado->getAno());
        $departamento = mysqli_real_escape_string($connect->connect(), $chamado->getDepartamento());
        $produto = mysqli_real_escape_string($connect->connect(), $chamado->getProduto());
        $observacao = mysqli_real_escape_string($connect->connect(), $chamado->getObservacao());

        $data = $ano . "-" . $mes . "-" . $dia;
        $query = "insert into chamados(usu_id,cha_data,cha_produto,cha_observacao,cha_status,cha_departamento) 
        VALUES ($id, '$data', '$produto', '$observacao', 1, '$departamento')";

        if (mysqli_query($connect->connect(), $query)) {
            return true;
        } else {
            throw new Exception('Falha ao Cadastrar Chamado!!');
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

    //Listando Chamados
    function listarChamados($id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id order by cha_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {
            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }


                echo "
                    <tr>
                    <th scope='row'>$Id</th>
                    <td>$data</td>
                    <td>$produto</td>
                    <td>$obs</td>
                    <td>$dept</td>
                    <td class='td-status fw-bold text-uppercase'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm  btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btn-sm btnAcao  btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                    </td>
                    </tr>
                    ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    //Pesquisa Por ID
    function pesquisaID($id, $idChamado)
    {
        try {
            $connect = new ConnectionDB();
            $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_id = $idChamado";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   = $list['cha_id'];
                    $data = date('d/m/Y',  strtotime($list['cha_data']));
                    $produto = $list['cha_produto'];
                    $obs = $list['cha_observacao'];
                    $dept = $list['cha_departamento'];
                    if ($list['cha_status'] == 1) {
                        $status = 'em aberto';
                    } else {
                        $status = 'fechado';
                    }


                    echo "
                        <tr>
                        <th scope='row'>$Id</th>
                        <td>$data</td>
                        <td>$produto</td>
                        <td>$obs</td>
                        <td>$dept</td>
                        <td class='td-status fw-bold text-uppercase'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                        </td>
                        </tr>
                        ";
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
    function pesquisaData($id, $dataChamado)
    {
        try {

            $connect = new ConnectionDB();
            $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_data = '$dataChamado'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   = $list['cha_id'];
                    $data = date('d/m/Y',  strtotime($list['cha_data']));
                    $produto = $list['cha_produto'];
                    $obs = $list['cha_observacao'];
                    $dept = $list['cha_departamento'];
                    if ($list['cha_status'] == 1) {
                        $status = 'em aberto';
                    } else {
                        $status = 'fechado';
                    }


                    echo "
                        <tr>
                        <th scope='row'>$Id</th>
                        <td>$data</td>
                        <td>$produto</td>
                        <td>$obs</td>
                        <td>$dept</td>
                        <td class='td-status fw-bold text-uppercase'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                        </td>
                        </tr>
                        ";
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
            $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_departamento like '%$departamento%'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   = $list['cha_id'];
                    $data = date('d/m/Y',  strtotime($list['cha_data']));
                    $produto = $list['cha_produto'];
                    $obs = $list['cha_observacao'];
                    $dept = $list['cha_departamento'];
                    if ($list['cha_status'] == 1) {
                        $status = 'em aberto';
                    } else {
                        $status = 'fechado';
                    }


                    echo "
                        <tr>
                        <th scope='row'>$Id</th>
                        <td>$data</td>
                        <td>$produto</td>
                        <td>$obs</td>
                        <td>$dept</td>
                        <td class='td-status fw-bold text-uppercase'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                        </td>
                        </tr>
                        ";
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
            $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_produto like '%$produto%'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   = $list['cha_id'];
                    $data = date('d/m/Y',  strtotime($list['cha_data']));
                    $produto = $list['cha_produto'];
                    $obs = $list['cha_observacao'];
                    $dept = $list['cha_departamento'];
                    if ($list['cha_status'] == 1) {
                        $status = 'em aberto';
                    } else {
                        $status = 'fechado';
                    }


                    echo "
                        <tr>
                        <th scope='row'>$Id</th>
                        <td>$data</td>
                        <td>$produto</td>
                        <td>$obs</td>
                        <td>$dept</td>
                        <td class='td-status fw-bold text-uppercase'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                        </td>
                        </tr>
                        ";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Produto Informado Incorretamente</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
    }

    //Pesquisa Por Observação
    function pesquisaObservacao($id, $observacao)
    {
        try {
            $connect = new ConnectionDB();
            $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_observacao like '%$observacao%'";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $Id   = $list['cha_id'];
                    $data = date('d/m/Y',  strtotime($list['cha_data']));
                    $produto = $list['cha_produto'];
                    $obs = $list['cha_observacao'];
                    $dept = $list['cha_departamento'];
                    if ($list['cha_status'] == 1) {
                        $status = 'em aberto';
                    } else {
                        $status = 'fechado';
                    }

                    echo "
                        <tr>
                        <th scope='row'>$Id</th>
                        <td>$data</td>
                        <td>$produto</td>
                        <td>$obs</td>
                        <td>$dept</td>
                        <td class='td-status fw-bold text-uppercase'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                        </td>
                        </tr>
                        ";
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception) {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                            <strong>Obs Informada Incorretamente</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
        }
    }

    function filtrarDatas($data1, $data2, $id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where cha_data BETWEEN '$data1' AND '$data2' and usu_id = $id";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }

                echo "
                    <tr>
                    <th scope='row'>$Id</th>
                    <td>$data</td>
                    <td>$produto</td>
                    <td>$obs</td>
                    <td>$dept</td>
                    <td class='td-status fw-bold text-uppercase'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                    </td>
                    </tr>
                    ";
            } while ($list = mysqli_fetch_assoc($result));
        } else {
            echo   "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Datas Informadas Incorretamente</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
        }
    }

    // Ordenar Em Ordem Crescente
    function ordenaCrescente($id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id order by cha_data asc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }

                echo "
                    <tr>
                    <th scope='row'>$Id</th>
                    <td>$data</td>
                    <td>$produto</td>
                    <td>$obs</td>
                    <td>$dept</td>
                    <td class='td-status fw-bold text-uppercase'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                    </td>
                    </tr>
                    ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar Em Ordem Decrescente
    function ordenaDecrescente($id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id order by cha_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }

                echo "
                    <tr>
                    <th scope='row'>$Id</th>
                    <td>$data</td>
                    <td>$produto</td>
                    <td>$obs</td>
                    <td>$dept</td>
                    <td class='td-status fw-bold text-uppercase'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                    </td>
                    </tr>
                    ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar Em Ordem Decrescente
    function ordenaAlfabetico($id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id order by cha_departamento";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }

                echo "
                    <tr>
                    <th scope='row'>$Id</th>
                    <td>$data</td>
                    <td>$produto</td>
                    <td>$obs</td>
                    <td>$dept</td>
                    <td class='td-status fw-bold text-uppercase'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                    </td>
                    </tr>
                    ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar por Abertos
    function ordenaAbertos($id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_status = 1 order by cha_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }

                echo "
                    <tr>
                    <th scope='row'>$Id</th>
                    <td>$data</td>
                    <td>$produto</td>
                    <td>$obs</td>
                    <td>$dept</td>
                    <td class='td-status fw-bold text-uppercase'>$status</td>
                    <td class='col-10 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                    </td>
                    </tr>
                    ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar por Abertos
    function ordenaFechados($id)
    {

        $connect = new ConnectionDB();
        $query = "select cha_id,cha_data,cha_produto,cha_observacao,cha_departamento,cha_status from chamados where usu_id = $id and cha_status = 0 order by cha_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {

            do {

                $Id   = $list['cha_id'];
                $data = date('d/m/Y',  strtotime($list['cha_data']));
                $produto = $list['cha_produto'];
                $obs = $list['cha_observacao'];
                $dept = $list['cha_departamento'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }

                echo "
                               <tr>
                               <th scope='row'>$Id</th>
                               <td>$data</td>
                               <td>$produto</td>
                               <td>$obs</td>
                               <td>$dept</td>
                               <td class='td-status fw-bold text-uppercase'>$status</td>
                               <td class='col-12 row ocultarImprimir'>
                               <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btn-sm btnAcao  btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                               <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btn-sm btnAcao  btn-danger'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                               </td>
                               </tr>
                               ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Deletar Um Chamado
    function deletarChamado($idChamado, $id)
    {

        try {

            $connect = new ConnectionDB();
            $query = "delete from chamados where cha_id = $idChamado and usu_id = $id";

            if (mysqli_query($connect->connect(), $query)) {
                return true;
            } else {
                throw new Exception('Falha ao Excluir Chamado!!');
            }
        } catch (mysqli_sql_exception $th) {
            throw new Exception('Falha ao Excluir Chamado!!');
        }
    }

    //Carregar Dados Chamado
    function CarregarDadosChamado($id)
    {
        $connect = new ConnectionDB();
        $query = "select day(cha_data) as dia, month(cha_data) as mes, year(cha_data) as ano,cha_departamento,cha_produto,cha_observacao, cha_status from chamados where cha_id = $id";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        $dados = [];

        if ($total > 0) {
            do {

                $dia = $list['dia'];
                $mes = $list['mes'];
                $ano = $list['ano'];
                $dep = $list['cha_departamento'];
                $produto = $list['cha_produto'];
                if ($list['cha_status'] == 1) {
                    $status = 'em aberto';
                } else {
                    $status = 'fechado';
                }
                $obs = $list['cha_observacao'];

                $dados = [$dia, $mes, $ano, $dep, $produto, $obs, $status];
            } while ($list = mysqli_fetch_assoc($result));
        }

        $_SESSION['dados_chamado_E'] = $dados;
    }

    //Alterar Dados da Saída
    function alterarChamado(Chamado $chamado, $id)
    {

        try {

            $connect = new ConnectionDB();

            $dia = mysqli_real_escape_string($connect->connect(), $chamado->getDia());
            $mes = mysqli_real_escape_string($connect->connect(), $chamado->getMes());
            $ano = mysqli_real_escape_string($connect->connect(), $chamado->getAno());
            $departamento = mysqli_real_escape_string($connect->connect(), $chamado->getDepartamento());
            $produto = mysqli_real_escape_string($connect->connect(), $chamado->getProduto());
            $observacao = mysqli_real_escape_string($connect->connect(), $chamado->getObservacao());

            $data = $ano . "-" . $mes . "-" . $dia;

            $sql = "update chamados set cha_data = '$data', cha_departamento = '$departamento', cha_produto = '$produto', cha_observacao = '$observacao' where cha_id = $id";

            if (mysqli_query($connect->connect(), $sql)) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $th) {
            throw new Exception('Valores Inválidos, Insira Novamente!');
        }
    }

    //Alterar Status do Chamado
    function alterarStatusChamado($idChamado)
    {

        try {

            $connect = new ConnectionDB();

            $sql = "update chamados set cha_status = 0 where cha_id = $idChamado";

            if (mysqli_query($connect->connect(), $sql)) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $th) {
            throw new Exception('Falha ao realizar operação, Tente Novamente!');
        }
    }
}
