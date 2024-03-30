<?php
require_once __DIR__ . '/../datasource.php';

use db\DataSource;

// jsで送られてきたデータを取得

$data = json_decode(file_get_contents('php://input'), true);

try {
    $db = new DataSource;
    $db->begin();

    $sql = 'INSERT INTO parent_tasks (project_id, user_id, title, progress) VALUES (:project_id, :user_id, :title, :progress)';

    $db->execute($sql, [':project_id' => $data["project_id"] , ':user_id' => $data["user_id"], ':title' => $data["parent_task_name"], ':progress' => $data["parent_task_progress"]]);

    $db->commit();

    echo json_encode([
        "project_id" => $data["project_id"],
        "user_id" => $data["user_id"],
        "parent_task_name" => $data["parent_task_name"],
        "parent_task_progress" => $data["parent_task_progress"]
    ]);


} catch(PDOException $e) {
    $db->rollback();
}

?>
