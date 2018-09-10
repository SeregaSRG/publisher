<?php
class Model_Delete
{
    public function delete()
    {
        global $pdo;

        $id = Parameters::Get('id');

        $deleteQuery = $pdo->prepare("
          DELETE  
          FROM 
          `tasks`
          WHERE
          `id` = :id
        ");
        $deleteQuery->execute([
            ':id' => $id
        ]);

        return $deleteQuery;
    }
}