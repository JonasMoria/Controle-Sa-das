<?php

require('ConnectionDB.php');

class UsuarioDB {

    function cadastro(Usuario $usuario) {
        $connect = new ConnectionDB();
        $searchEmail = $usuario->getEmail();
        $query = "select usu_email from USUARIOS where usu_email = '$searchEmail'";
        
        $result = mysqli_query($connect->connect(), $query);
        $row = mysqli_num_rows($result);

        if ($row == 1) {
            throw new Exception('Usuário Já Cadastrado!!');
        } else {
            $user_email = mysqli_real_escape_string($connect->connect(), $usuario->getEmail());
            $user_name  = mysqli_real_escape_string($connect->connect(), $usuario->getNome());
            $user_pass  = mysqli_real_escape_string($connect->connect(), hash('sha512',$usuario->getSenha()));

            $sql = "insert into usuarios(usu_nome,usu_email,usu_senha) values('$user_name','$user_email','$user_pass')";

            if(mysqli_query($connect->connect(),$sql)) {
                return true;
            } else {
                return false;
            }

        }
    }

    function login($email,$pass) {   

        $connect = new ConnectionDB();

        $email = mysqli_real_escape_string($connect->connect(), $email);
        $pass  = mysqli_real_escape_string($connect->connect(), hash('sha512',$pass));

        $query = "select usu_id, usu_email from usuarios where usu_email = '$email' and usu_senha = '$pass'";  
        $result = mysqli_query($connect->connect(), $query);
        $row = mysqli_num_rows($result);

        if ($row == 1) {
            return true;
        } else {
            return false;
        }
    }

    function getUser($email) {
        $connect = new ConnectionDB();
 
        $query = "select usu_nome, usu_id from usuarios where usu_email = '$email'";
        $result = mysqli_query($connect->connect(), $query);
        $data = mysqli_fetch_array($result);
 
        return $data;
    }

}
