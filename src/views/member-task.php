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
    echo 'プロジェクトを取得できませんでした。<br>';
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
        if(!isset($weekly_tasks[$date])){
            $weekly_tasks[$date] = new WeeklyTask();
        }
        $weekly_tasks[$date]->addParentTask($parent_task);
    }

    // echo "<pre>";
    // print_r($weekly_tasks);
    // echo "</pre>";


} catch (PDOException $e) {
    echo '親タスクを取得できませんでした。<br>';
    $db->rollback();

}
?>


<div class="task__container">
    <h2 class="project__container">
        <div class="project__detail">
          　<?php echo $project->title ?>
          <script>
            const progress = Number("<?php echo $project->progress ?>")
            const progressPercent = progress.toFixed(4)
            document.write(progressPercent + "%")
          </script>
          完了
        </div>
    </h2>
    <ul class="weekly__report__container">
        <?php foreach ($users as $user) : ?>
            <li class="weekly__report">
               <div class="user__name">
                   <?php echo $user->name ?>
                </div>

                <?php foreach ($weekly_tasks as $weekly_task) : ?>
                    <div class="weekly__report__task__container">
                        <div class="date">
                            <?php
                            $today = new DateTime();
                            $today = $today->format('Y-m-d');
                            if ($weekly_task->date === $today) {
                                echo $weekly_task->getDate() . ' 本日';
                            } else {
                                echo $weekly_task->getDate();
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </li>
        <?php endforeach; ?>
        <script>
            const $users = document.querySelectorAll('.user__name')

            // 文字の最大値を取得
            const max = Math.max(...Array.from($users).map(user => user.textContent.length))

            const maxValue = Array.from($users).find(user => user.textContent.length === max)
            // 横幅のピクセルを取得
            const width = maxValue.offsetWidth
            const $weeklyReport = document.querySelector('.weekly__report')

            const height = $weeklyReport.offsetHeight

            Array.from($users).forEach(user => {
                user.style.width = `${width}px`
                user.style.height = `${height}px`
            })
        </script>
    </ul>
</div>
