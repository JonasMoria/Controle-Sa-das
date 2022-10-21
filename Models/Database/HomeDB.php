<?php

require_once(__DIR__ . '../../Database/ConnectionDB.php');

class HomeDB
{

    function showChamados($id)
    {
        try {
            $connect = new ConnectionDB();
            $query = "select  date_format(cha_data,'%d-%m-%Y') as cha_data, cha_produto, cha_observacao, cha_departamento from chamados where usu_id = $id and cha_status = 1 order by cha_data desc limit 5;";
            $result = mysqli_query($connect->connect(), $query);

            $list = mysqli_fetch_assoc($result);
            $total = mysqli_num_rows($result);

            if ($total > 0) {

                do {

                    $data =  $list['cha_data'];
                    $departamento = $list['cha_departamento'];
                    $produto = $list['cha_produto'];
                    $observacao = $list['cha_observacao'];

                    echo "<tr class='chamados'>
                        <th scope='row' class='td-data'>$data</th>
                        <td class='td-produto'>$produto</td>
                        <td class='td-obs'>$observacao</td>
                        <td class='td-dep'>$departamento</td>
                      </tr>";

                      
                } while ($list = mysqli_fetch_assoc($result));
            }
        } catch (mysqli_sql_exception $th) {
            return 'Erro ao Gerar Tabela';
        }
    }
}
