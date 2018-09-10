<?php
class Model_Add
{
    public function addTask()
    {
        global $pdo;

        $group_id = Parameters::Post('group_id');
        $topic_id = Parameters::Post('topic_id');
        $token    = Parameters::Post('token');
        $category = Parameters::Post('category');

        $addQuery = $pdo->prepare("
              INSERT INTO 
                `tasks` 
                (`group_id`, `token`, `category`, `topic_id`)
              VALUES 
                (:group_id, :token, :category, :topic_id)
            ");

        $addQuery->execute([
            ':group_id' => $group_id,
            ':token'    => $token,
            ':category' => $category,
            ':topic_id' => $topic_id
        ]);

        return $addQuery;
    }
}