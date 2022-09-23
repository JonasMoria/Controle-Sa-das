<?php

class Saida {

private int $dia;
private int $mes;
private int $ano;
private $produto;
private $departamento;
private $responsavel;
private $observacao;

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
function setProduto($produto) {
    if (!empty($produto) && !is_null($produto)) {
        $this->produto = $produto;
     } else {
         throw new Exception('Campo Produto Não Pode Ser Vazio!');
     } 
}
function setResponsavel($responsavel) {
    if (!empty($responsavel) && !is_null($responsavel)) {
        $this->responsavel = $responsavel;
     } else {
         throw new Exception('Campo Responsável Não Pode Ser Vazio!');
     } 
}
function setObservacao($observacao) {
    if (!empty($observacao) && !is_null($observacao)) {
        $this->observacao = $observacao;
     } else {
         throw new Exception('Campo Observação Não Pode Ser Vazio!');
     } 
}

function getDia(){
    return $this->dia;
}
function getMes(){
    return $this->mes;
}
function getAno(){
    return $this->ano;
}
function getDepartamento(){
    return $this->departamento;
}
function getProduto(){
    return $this->produto;
}
function getResponsavel(){
    return $this->responsavel;
}
function getObservacao(){
    return $this->observacao;
}

function verificaData($dia,$mes,$ano) {
    if(checkdate($dia,$mes,$ano)){
        return true;
    } else {
        throw new Exception('Data Inválida!');
    }
}
    
}

?>