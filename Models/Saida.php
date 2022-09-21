<?php

class Saida {

private $dia;
private $mes;
private $ano;
private $departamento;
private $responsavel;

function setDia($dia) {
    if (!empty($dia) && !is_null($dia)) {
       $this->dia = $dia;
    } else {
        throw new Exception('Campo Dia Não Pode Ser Vazio!');
    }
}
function setMes($mes) {
    if (!empty($mes) && !is_null($mes)) {
        if ($mes >= 1 && $mes<=12) {
            $this->mes = $mes;
        } else {
            throw new Exception('Mês Inválido!');
        }
     } else {
         throw new Exception('Campo Mês Não Pode Ser Vazio!');
     }
}
function setAno($ano) {
    if (!empty($ano) && !is_null($ano)) {
        if ($ano >= 2000) {
            $this->ano = $ano;
        } else {
            throw new Exception('Ano Inválido!');
        }
     } else {
         throw new Exception('Campo Ano Não Pode Ser Vazio!');
     }
}
function setDepartamento($departamento) {
    if (!empty($departamento) && !is_null($departamento)) {
        $this->departamento = $departamento;
     } else {
         throw new Exception('Campo Departamento Não Pode Ser Vazio!');
     }
}
function setResponsavel($responsavel) {
    if (!empty($responsavel) && !is_null($responsavel)) {
        $this->responsavel = $responsavel;
     } else {
         throw new Exception('Campo Responsável Não Pode Ser Vazio!');
     } 
}

function verificaData($dia,$mes,$ano) {
    if(checkdate($dia,$mes,$ano)){
        return $ano.'-'.$mes.'-'.$dia;
    } else {
        throw new Exception('Data Inválida!');
    }
}
    
}

?>