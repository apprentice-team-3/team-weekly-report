<?php
require_once __DIR__ . '/../datasource.php';
require_once __DIR__ . '/../models/parent_task.model.php';

use db\DataSource;

$data = json_decode(file_get_contents('php://input'), true);

try {
    $db = new DataSource;
    $db->begin();

    $parentSql = 'UPDATE parent_tasks SET title = :title, progress = :progress WHERE id = :parent_task_id';


    $db->execute($parentSql, [
        ':parent_task_id' => $data["parent_task_id"],
        ':title' => $data["parent_task_name"],
        ':progress' => $data["parent_task_progress"]
    ]);

    $parentTaskId = $data["parent_task_id"];
    // 子タスクの登録

    $childTasks = $data["child_tasks"];
    if ($childTasks) {
        $childUpdateSql = "UPDATE child_tasks SET title = :title, content = :content, progress = :progress WHERE id = :child_task_id";

        foreach ($data["child_tasks"] as $childTask) {
            $db->execute($childUpdateSql, [
                ':child_task_id' => $childTask["child_task_id"],
                ':title' => $childTask["child_task_name"],
                ':content' => $childTask["child_task_comment"],
                ':progress' => $childTask["child_task_progress"]
            ]);
        }
    }

    $newChildTasks = $data["new_child_tasks"];

    if($newChildTasks){
        $childInsertSql = "INSERT INTO child_tasks (parent_task_id, title, content, progress) VALUES (:parent_task_id, :title, :content, :progress)";

        foreach ($data["new_child_tasks"] as $newChildTask) {
            $db->execute($childInsertSql, [
                ':parent_task_id' => $parentTaskId,
                ':title' => $newChildTask["child_task_name"],
                ':content' => $newChildTask["child_task_comment"],
                ':progress' => $newChildTask["child_task_progress"]
            ]);
        }
    }

    $db->commit();

    echo json_encode([
        "parent_task_id" => $parentTaskId,
        "parent_task_name" => $data["parent_task_name"],
        "parent_task_progress" => $data["parent_task_progress"],
        "child_tasks" => $childTasks,
        "new_child_tasks" => $newChildTasks
    ]);

} catch(PDOException $e) {
    echo json_encode(['message' => '時間をおいて再度お試しください。']);


    $db->rollback();
}
?>
