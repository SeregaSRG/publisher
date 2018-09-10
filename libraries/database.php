<?php
class Database{
    static function connect() {
        $dsn = "mysql:host=".MYSQL_HOSTNAME.";dbname=".MYSQL_DBNAME.";charset=utf8";
        $opt = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        return $pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, $opt);
    }
}