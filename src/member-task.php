<?php
require_once "datasource.php";
require_once "models/project.model.php";
require_once "models/user.model.php";
require_once "models/parent_task.model.php";
require_once "models/weekly_tasks.model.php";

use db\DataSource;
use model\Project;

try {
    $db = new DataSource;
    $db->begin();
    $sql = 'SELECT * FROM projects where id = :id;';

    $project = $db->selectOne($sql,[':id' => 1],DataSource::CLS,Project::class);


    $db->commit();
} catch (PDOException $e){
    echo '時間をおいて再度お試しください。<br>';
    $db->rollback();
}


$title = 'メンバータスク一覧';
$content = __DIR__ . '/views/member-task.php';
include __DIR__ . '/views/layout.php';
