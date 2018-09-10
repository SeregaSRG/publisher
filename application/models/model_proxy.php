<?php
class Model_Proxy
{
    public function getAllProxy()
    {
        global $pdo;

        $getAllDatarQuery = $pdo->prepare(
            "SELECT * FROM `proxy`"
        );
        $getAllDatarQuery->execute();
        $result = $getAllDatarQuery->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function addProxy()
    {
        global $pdo;

        $ip       = Parameters::Post('ip');
        $login    = Parameters::Post('login');
        $password = Parameters::Post('password');

        $addQuery = $pdo->prepare("
          INSERT INTO 
            `proxy` 
            (`ip`, `login`, `password`)
          VALUES 
            (:ip, :login, :password)
        ");

        $addQuery->execute([
            ':ip'        => $ip,
            ':login'    => $login,
            ':password' => $password
        ]);

        return $addQuery;
    }

    public function delete()
    {
        global $pdo;

        $id = Parameters::Get('id');

        $deleteQuery = $pdo->prepare("
          DELETE  
          FROM 
          `proxy`
          WHERE
          `id` = :id
        ");
        $deleteQuery->execute([
            ':id' => $id
        ]);

        return $deleteQuery;
    }
}