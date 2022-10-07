<?php

class ConnectionDB
{

    function connect()
    {
        $host = '127.0.0.1';
        $user = 'root';
        $pass = 'password';
        $db   = 'controlesaidas';

        if (mysqli_connect($host, $user, $pass, $db)) {
            return mysqli_connect($host, $user, $pass, $db);
        } else {
            return false;
        }
    }
}
