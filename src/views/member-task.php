<?php

use db\DataSource;
use model\Project;
use model\User;

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
