<?php
require_once __DIR__ . '/../DataSource.php';

use db\DataSource;
use model\ChildTask;

// jsで送られてきたデータを取得
$parent_task_id = 1;
$child_task_name = "送信した子タスク";
$child_task_comment = "子タスクコメント";
$child_task_progress = 30;

try {
    $db = new DataSource;
    $db->begin();

    $sql = 'INSERT INTO child_tasks (parent_task_id, title, content, progress) VALUES (:parent_task_id, :title, :content, :progress)';

    $db->execute($sql, [':parent_task_id' => $parent_task_id, ':title' => $child_task_name, ':content' => $child_task_comment, ':progress' => $child_task_progress]);

    $db->commit();

    echo '送信成功！<br>';

} catch(PDOException $e) {
    echo '時間をおいて再度お試しください。<br>';
    $db->rollback();
}

?>
