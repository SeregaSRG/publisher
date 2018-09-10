<?php
class Model_Edit
{
    public function edit()
    {
        global $pdo;

        $group_id = Parameters::Post('group_id');
        $topic_id = Parameters::Post('topic_id');
        $category = Parameters::Post('category');
        $id       = Parameters::Post('id');


        $updateQuery = $pdo->prepare("
              UPDATE 
                `tasks` 
              SET 
                `group_id` = :group_id,
                `topic_id` = :topic_id,
                `category` = :category
              WHERE
                `id` = :id
            ");

        $updateQuery->execute([
            ':group_id' => $group_id,
            ':topic_id' => $topic_id,
            ':category' => $category,
            ':id'       => $id
        ]);

        return $updateQuery;
    }
}