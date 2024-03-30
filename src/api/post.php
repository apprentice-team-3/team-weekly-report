<?php
require_once __DIR__ . '/../datasource.php';

use db\DataSource;

// jsで送られてきたデータを取得
$data = json_decode(file_get_contents('php://input'), true);

try {
    $db = new DataSource;
    $db->begin();

    // 親タスクの登録
    $parentSql = 'INSERT INTO parent_tasks (project_id, user_id, title, progress) VALUES (:project_id, :user_id, :title, :progress)';
    $db->execute($parentSql, [
        ':project_id' => $data["project_id"],
        ':user_id' => $data["user_id"],
        ':title' => $data["parent_task_name"],
        ':progress' => $data["parent_task_progress"]
    ]);


    // 子タスクの登録
    if ($parentTaskId) {
        $childSql = "INSERT INTO child_tasks (parent_task_id, title, content, progress) VALUES (:parent_task_id, :title, :content, :progress)";

        foreach ($data["child_tasks"] as $childTask) {
            $db->execute($childSql, [
                ':parent_task_id' => $parentTaskId,
                ':title' => $childTask["childTaskName"],
                ':content' => $childTask["comment"],
                ':progress' => $childTask["progress"]
            ]);
        }
        $db->commit();
    }

    echo json_encode([
        "project_id" => $data["project_id"],
        "user_id" => $data["user_id"],
        "parent_task_name" => $data["parent_task_name"],
        "parent_task_progress" => $data["parent_task_progress"],
        "child_tasks" => $data["child_tasks"]
    ]);


} catch(PDOException $e) {
    echo json_encode(['message' => '時間をおいて再度お試しください。']);
    $db->rollback();
}
?>
