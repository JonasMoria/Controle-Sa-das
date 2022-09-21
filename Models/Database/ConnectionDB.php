<?php

class ConnectionDB{

    function connect() {
        $host = '127.0.0.1';
        $user = 'root';
        $pass = 'password';
        $db   = 'controlesaidas';

        return mysqli_connect($host,$user,$pass,$db);
    }
}
