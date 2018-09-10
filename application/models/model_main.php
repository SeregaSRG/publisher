<?php
class Model_Main
{
    public function getAllTasks()
    {
        global $pdo;

        $getAllDatarQuery = $pdo->prepare(
            "SELECT * FROM `tasks`"
        );
        $getAllDatarQuery->execute();
        $result = $getAllDatarQuery->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}