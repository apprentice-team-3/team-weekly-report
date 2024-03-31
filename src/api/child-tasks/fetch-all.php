<?php
require_once __DIR__ . '/../../datasource.php';
require_once __DIR__ . '/../../models/child_task.model.php';

use db\DataSource;
use model\ChildTask;

$data = json_decode(file_get_contents('php://input'), true);


function fetchChildTasks($parent_task_id){
    try {
        $db = new DataSource;
        $db->begin();
        // 日付が新しい順に取得
        $sql = 'SELECT * FROM child_tasks WHERE parent_task_id = :parent_task_id ORDER BY created_at DESC';

        $child_tasks = $db->select($sql,[':parent_task_id' => $parent_task_id],DataSource::CLS,ChildTask::class);

        $db->commit();
        return $child_tasks;
    } catch (PDOException $e) {
        echo '子タスクを取得できませんでした。<br>';
        $db->rollback();
    }
}

echo json_encode(fetchChildTasks($data["parent_task_id"]));
