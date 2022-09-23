<?php

require_once(__DIR__ . '../../Saida.php');
require_once(__DIR__ . '../../Database/ConnectionDB.php');

class SaidaDB {

 // Cadastro de Saídas
 function cadastrarSaida(Saida $saida, $id) {
    
    $connect = new ConnectionDB();

    $dia = mysqli_real_escape_string($connect->connect(), $saida->getDia());
    $mes = mysqli_real_escape_string($connect->connect(), $saida->getMes());
    $ano = mysqli_real_escape_string($connect->connect(), $saida->getAno());
    $departamento = mysqli_real_escape_string($connect->connect(), $saida->getDepartamento());
    $produto = mysqli_real_escape_string($connect->connect(), $saida->getProduto());
    $observacao = mysqli_real_escape_string($connect->connect(), $saida->getObservacao());

    $data = $ano."-".$mes."-".$dia;
    $query = "insert into saidas(usu_id,sai_data,sai_departamento,sai_produto,sai_observacao) VALUES ($id,'$data','$departamento','$produto','$observacao' )";
    
    if (mysqli_query($connect->connect(), $query)) {
        return true;
    } else {
        throw new Exception('Falha ao Cadastrar Saída!!');
    }
   
 }

 //Selecionar Departamento na Modal
 function listarDepartamentos($id){
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
    
}

?>