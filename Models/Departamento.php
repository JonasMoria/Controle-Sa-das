<?php

class Departamento {

    private $nome;
    private $responsavel;
    private $telefone;
    private $email;

    function setNome($nome) {
        if (!empty($nome) && !is_null($nome)) {
            if(mb_strlen($nome) < 256) {
               $this->nome = $nome;
            } else {
               throw new Exception('Campo Nome Suporta Até 255 Caracteres Somente!');
            }
          } else {
             throw new Exception('Campo Nome Não Pode Ser Vazio!');
          }
    }

    function setResponsavel($responsavel) {
        if (!empty($responsavel) && !is_null($responsavel)) {
            if(mb_strlen($responsavel) < 256) {
               $this->responsavel = $responsavel;
            } else {
               throw new Exception('Campo Responsável Suporta Até 255 Caracteres Somente!');
            }
          } else {
             throw new Exception('Campo Responsável Não Pode Ser Vazio!');
          }
    }
    function setTelefone($telefone) {
        if (!empty($telefone) && !is_null($telefone)) {
            if(mb_strlen($telefone) < 16) {
               $this->telefone = $telefone;
            } else {
               throw new Exception('Campo Telefone Suporta Até 15 Caracteres Somente!');
            }
          } else {
             throw new Exception('Campo Telefone Não Pode Ser Vazio!');
          }
    }
    function setEmail($email) {
       if (!empty($email) && !is_null($email)) {
         if(mb_strlen($email) < 256) {
            $this->email = $email;
         } else {
            throw new Exception('Campo Email Suporta Até 255 Caracteres Somente!');
         }
       } else {
          throw new Exception('Campo Email Não Pode Ser Vazio!');
       }
    }

    function getNome() {
        return $this-> nome;
    }
    function getResponsavel() {
        return $this-> responsavel;
    }

    function getTelefone() {
        return $this-> telefone;
    }
    function getEmail() {
        return $this-> email;
    }



}
