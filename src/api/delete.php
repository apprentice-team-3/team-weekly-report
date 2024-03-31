<?php
require_once __DIR__ . '/../datasource.php';
require_once __DIR__ . '/../models/parent_task.model.php';
use db\DataSource;

$data = json_decode(file_get_contents('php://input'), true);

try {
    $db = new DataSource;
    $db->begin();

    // 親タスクに関連する子タスクを削除
    $childSql = 'DELETE FROM child_tasks WHERE parent_task_id = :parent_task_id';
    $db->execute($childSql, [
        ':parent_task_id' => $data["parent_task_id"],
    ]);

    // 親タスクを削除
    $parentSql = 'DELETE FROM parent_tasks WHERE id = :parent_task_id';
    $db->execute($parentSql, [
        ':parent_task_id' => $data["parent_task_id"],
    ]);

    $db->commit();

    echo json_encode(['message' => '親タスクが正常に削除されました。']);
} catch(PDOException $e) {
    echo json_encode(['message' => '時間をおいて再度お試しください。']);
    $db->rollback();
}
?>