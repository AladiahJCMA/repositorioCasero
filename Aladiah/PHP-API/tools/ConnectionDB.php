<?php
declare(strict_types=1);
require_once('./config.php');
class ConnectionDB {

    /**
     *
     *
     */
    static function connect() {
        $conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_BD);
        if ($conn->connect_errno) {
            die("Connection error: " . $conn->connect_error);
        }
        return $conn;
    }

}