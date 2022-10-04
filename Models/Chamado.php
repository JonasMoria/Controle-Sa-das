<?php

class Chamado {


    private $dia;
    private $mes;
    private $ano;
    private $produto;
    private $observacao;
    private $status = 1; // em aberto

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

    function setProduto($produto) {
        if (!empty($produto) && !is_null($produto)) {
            $this->produto = $produto;
         } else {
             throw new Exception('Campo Produto Não Pode Ser Vazio!');
         } 
    }

    function setObservacao($observacao) {
        if (!empty($observacao) && !is_null($observacao)) {
            $this->observacao = $observacao;
         } else {
             throw new Exception('Campo Observação Não Pode Ser Vazio!');
         } 
    }

    function setStatus($status) {
        if ($status == 0 || $status == 1) {
            $this->status = $status;
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
    function getProduto(){
        return $this->produto;
    }
    function getObservacao(){
        return $this->observacao;
    }
    function getStatus(){
        return $this->observacao;
    }

    function verificaData($dia,$mes,$ano) {
        if(checkdate($mes,$dia,$ano)){
            return true;
        } else {
            return false;
        }
    }

}
