<?php

use db\DataSource;
use model\Project;
use model\User;
use model\ParentTask;
use model\WeeklyTask;

try {
    $db = new DataSource;
    $db->begin();
    $sql = 'SELECT * FROM projects where id = :id;';

    $project = $db->selectOne($sql,[':id' => 1],DataSource::CLS,Project::class);


    $db->commit();
} catch (PDOException $e){
    echo 'プロジェクトが取得できませんでした。再度時間をおいてお試しください。<br>';
    $db->rollback();
}


try {
    $db->begin();
    $sql = 'SELECT * FROM users';

    $users = $db->select($sql,[],DataSource::CLS,User::class);

    $db->commit();
} catch (PDOException $e) {
    echo 'ユーザーを取得できませんでした。<br>';
    $db->rollback();
}

try {
    $db->begin();
    // 全部とってくると重いので仮決めで200件にしている、本来はページネーションを使う
    $sql = 'SELECT * FROM parent_tasks where project_id = :project_id ORDER BY created_at DESC LIMIT 200;';

    $parent_tasks = $db->select($sql,[':project_id' => 1],DataSource::CLS,ParentTask::class);


    $db->commit();
    $weekly_tasks = [];

    foreach($parent_tasks as $parent_task){
        $date = $parent_task->getDate();
        $user_id = $parent_task->user_id;
        $key = $date . $user_id;
        if(!isset($weekly_tasks[$key])){
            $weekly_tasks[$key] = new WeeklyTask();
        }
        $weekly_tasks[$key]->addParentTask($parent_task);
    }

} catch (PDOException $e) {
    echo '親タスクを取得できませんでした。<br>';
    $db->rollback();
}
// echo "<pre>";
//     print_r($weekly_tasks);
//     echo "</pre>";
