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
        $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);



        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data =  $list['sai_data'];
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
                            <td>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
                $data =  $list['sai_data'];
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
                            <td>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
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
        $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_data asc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);



        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data =  $list['sai_data'];
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
                            <td>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Ordenar Em Ordem Crescente
    function ordenaDecrescente($id)
    {

        $connect = new ConnectionDB();
        $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_data desc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);



        if ($total > 0) {

            do {

                $Id   =  $list['sai_id'];
                $data =  $list['sai_data'];
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
                            <td>$observacao</td>
                            <td class='col-12 row ocultarImprimir'>
                                <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                            </td>
                            </tr>";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

        // Ordenar Em Ordem Crescente
        function ordenaAlfabetico($id)
        {
    
            $connect = new ConnectionDB();
            $query = "select sai_id,date_format(sai_data,'%d-%m-%Y') as sai_data,sai_departamento,sai_produto,sai_observacao from saidas where usu_id = $id order by sai_departamento asc";
            $result = mysqli_query($connect->connect(), $query);
    
            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);
    
    
    
            if ($total > 0) {
    
                do {
    
                    $Id   =  $list['sai_id'];
                    $data =  $list['sai_data'];
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
                                <td>$observacao</td>
                                <td class='col-12 row ocultarImprimir'>
                                    <a href='../../Controllers/SaidaController.php?editar=" . $Id . "' class='btn btnAcao btn-success'><img src='../../Content/icones/editar.svg' alt='editar'></a>
                                    <a href='../../Controllers/SaidaController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
                                </td>
                                </tr>";
                } while ($list = mysqli_fetch_assoc($result));
            }
        }
}
