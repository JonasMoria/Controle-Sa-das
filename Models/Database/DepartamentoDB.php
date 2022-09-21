
<?php

require_once(__DIR__ . '../../Departamento.php');
require_once(__DIR__ . '../../Database/ConnectionDB.php');

class DepartamentoDB {


    // Cadastro de Departamento
    function cadastrarDepartamento(Departamento $departamento, $id) {

        $connect = new ConnectionDB();

        $nome = mysqli_real_escape_string($connect->connect(), $departamento->getNome());
        $responsavel = mysqli_real_escape_string($connect->connect(), $departamento->getResponsavel());
        $telefone = mysqli_real_escape_string($connect->connect(), $departamento->getTelefone());
        $email =  mysqli_real_escape_string($connect->connect(), $departamento->getEmail());

        $query = "select dep_nome from departamentos where dep_nome = '$nome' and usu_id = $id";

        $result = mysqli_query($connect->connect(), $query);
        $row = mysqli_num_rows($result);

        if ($row == 1) {
            throw new Exception('Departamento Já Cadastrado!!');
        } else {
            $sql = "INSERT INTO departamentos(usu_id,dep_nome,dep_responsavel,dep_telefone,dep_email) VALUES($id,'$nome','$responsavel','$telefone','$email')";
            if (mysqli_query($connect->connect(), $sql)) {
                return true;
            } else {
                return false;
            }
        }
    }

    //Alterar Dados Departamento
    function alterarDepartamento(Departamento $departamento,$id) {
        $connect = new ConnectionDB();

        $nome = mysqli_real_escape_string($connect->connect(), $departamento->getNome());
        $responsavel = mysqli_real_escape_string($connect->connect(), $departamento->getResponsavel());
        $telefone = mysqli_real_escape_string($connect->connect(), $departamento->getTelefone());
        $email =  mysqli_real_escape_string($connect->connect(), $departamento->getEmail());

        $sql = "update departamentos set dep_nome = '$nome', dep_responsavel = '$responsavel', dep_telefone='$telefone', dep_email = '$email' where dep_id = $id";
        if (mysqli_query($connect->connect(), $sql)) {
            return true;
        } else {
            return false;
        }
    }

    //Listar Departamentos
    function listarDepartamentos($id) {

        $connect = new ConnectionDB();
        $query = "select dep_id,dep_nome,dep_responsavel,dep_telefone,dep_email from departamentos where usu_id = $id order by dep_nome asc";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {
            do {

                $Id   = $list['dep_id'];
                $nome = $list['dep_nome'];
                $responsavel = $list['dep_responsavel'];
                $telefone = $list['dep_telefone'];
                $email = $list['dep_email'];


            echo "
            <tr>
            <th scope='row'>$Id</th>
            <td>$nome</td>
            <td>$responsavel</td>
            <td>$telefone</td>
            <td>$email</td>
            <td class='col-12 row ocultarImprimir'>
               <a href='../../Controllers/DepartamentoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
               <a href='../../Controllers/DepartamentoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
            </td>
            </tr>
            ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }
    //Carregar Dados Departamento
    function CarregarDadosDepartamento($id) {
        $connect = new ConnectionDB();
        $query = "select dep_nome,dep_responsavel,dep_telefone,dep_email from departamentos where dep_id = $id";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {
            do {
                $nome = $list['dep_nome'];
                $responsavel = $list['dep_responsavel'];
                $telefone = $list['dep_telefone'];
                $email = $list['dep_email'];

                echo "
                <section class='form-group col-12'>
                <label>Nome do setor</label>
                <input type='text' class='form-control' name='departamento_nomeE' value='$nome'>
                </div>
                <div class='form-group col-12'>
                    <label>Responsável pelo setor</label>
                    <input type='text' class='form-control' name='departamento_responsavelE' value='$responsavel'>
                </div>
                <div class='form-group col-12'>
                    <label>Telefone do setor</label>
                    <input type='text' class='form-control' name='departamento_telefoneE' value='$telefone'>
                </div>
                <div class='form-group col-12'>
                    <label>Email do setor</label>
                    <input type='email' class='form-control' name='departamento_emailE' value='$email'>
                </section>
                ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }

    // Deletar Departamento
    function deletarDepartamento($id) {
        $connect = new ConnectionDB();
        $query = "delete from departamentos where dep_id = $id";
        mysqli_query($connect->connect(), $query);
    }
    // Pesquisar
    function pesquisarDepartamentos($id, $palavra) {
        $connect = new ConnectionDB();
        $query = "select dep_id,dep_nome,dep_responsavel,dep_telefone,dep_email from departamentos
        where usu_id = $id and (dep_id like '%$palavra%' or dep_nome like '%$palavra%' or dep_responsavel like '%$palavra%'or dep_telefone like '%$palavra%' or dep_email like '%$palavra%')";
        $result = mysqli_query($connect->connect(), $query);

        $list = mysqli_fetch_assoc($result);
        $total = mysqli_num_rows($result);

        if ($total > 0) {
            do {

                $Id    = $list['dep_id'];
                $nome = $list['dep_nome'];
                $responsavel = $list['dep_responsavel'];
                $telefone = $list['dep_telefone'];
                $email = $list['dep_email'];


                echo "
             <tr>
             <th scope='row'>$Id</th>
             <td>$nome</td>
             <td>$responsavel</td>
             <td>$telefone</td>
             <td>$email</td>
             <td class='col-12 row ocultarImprimir'>
             <a href='../../Controllers/DepartamentoController.php?editar=" . $Id . "' class='btn btnAcao btn-success col-md-4 col-sm-12'><img src='../../Content/icones/editar.svg' alt='editar'></a>
             <a href='../../Controllers/DepartamentoController.php?excluir=" . $Id . "' class='btn btnAcao btn-danger col-md-4'col-sm-12'><img src='../../Content/icones/excluir.svg' alt='deletar'></a>
             </td>
             </tr>
             ";
            } while ($list = mysqli_fetch_assoc($result));
        }
    }
}

?>