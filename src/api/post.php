<?php
require_once __DIR__ . '/../DataSource.php';

use db\DataSource;
use model\ChildTask;

// jsで送られてきたデータを取得

$data = json_decode(file_get_contents('php://input'), true);

try {
    $db = new DataSource;
    $db->begin();

    $sql = 'INSERT INTO parent_tasks (project_id, user_id, title, progress) VALUES (:project_id, :user_id, :title, :progress)';

    $db->execute($sql, [':project_id' => $data["project_id"] , ':user_id' => $data["user_id"], ':title' => $data["parent_task_name"], ':progress' => $data["parent_task_progress"]]);

    $db->commit();

    echo '送信成功！<br>';

} catch(PDOException $e) {
    echo '時間をおいて再度お試しください。<br>';
    $db->rollback();
}

?>
