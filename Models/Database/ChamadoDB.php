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
                $data = $list['cha_data'];
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
                    <td>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                    $data = $list['cha_data'];
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
                        <td class='td-status'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                    $data = $list['cha_data'];
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
                        <td class='td-status'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                    $data = $list['cha_data'];
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
                        <td class='td-status'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                    $data = $list['cha_data'];
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
                        <td class='td-status'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                    $data = $list['cha_data'];
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
                        <td class='td-status'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data = $list['cha_data'];
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
                    <td class='td-status'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data = $list['cha_data'];
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
                    <td class='td-status'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data = $list['cha_data'];
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
                    <td class='td-status'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data = $list['cha_data'];
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
                    <td class='td-status'>$status</td>
                    <td class='col-12 row ocultarImprimir'>
                    <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                    <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data = $list['cha_data'];
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
                        <td class='td-status'>$status</td>
                        <td class='col-12 row ocultarImprimir'>
                        <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                        <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data = $list['cha_data'];
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
                               <td class='td-status'>$status</td>
                               <td class='col-12 row ocultarImprimir'>
                               <a href='../../Controllers/ChamadoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                               <a href='../../Controllers/ChamadoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                               </td>
                               </tr>
                               ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }
}
