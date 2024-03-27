<link rel="stylesheet" href="/views/css/popup/popup.css">
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
                    <div>
                        <?php echo $user->name ?>
                    </div>
                    <div>
                        <!-- $userをdata-userに渡したい -->
                        <button class="btn transition__btn open__add__task__btn" data-user_id="<?php echo $user->id ?>" data-project_id="<?php echo $project->id ?>" >タスクを追加</button>
                    </div>
                </div>

            <div class="weekly__report__task__container">
                <?php foreach ($weekly_tasks as $weekly_task) : ?>
                    <?php if ($weekly_task->parent_tasks[0]->user_id === $user->id) : ?>
                        <div class="weekly__report__task__container">
                            <?php
                            $today = new DateTime();
                            $today = $today->format('Y-m-d');
                            ?>
                            <?php if ($weekly_task->date === $today) :?>
                                <div class="date">
                                    <div class="inner_date">
                                        <?php echo $weekly_task->getDate() . ' 本日'; ?>
                                    </div>
                                </div>
                            <?php endif ; ?>
                            <?php if ($weekly_task->date !== $today) :?>
                                <div class="date">
                                    <div class="inner_date">
                                        <?php echo $weekly_task->getDate(); ?>
                                    </div>
                                </div>
                            <?php endif ; ?>
                            <div class="task">
                                <?php for ($i = 0; $i < count($weekly_task->parent_tasks); $i++) :?>
                                    <?php $progress = $weekly_task->parent_tasks[$i]->progress; ?>
                                    <div class="title_progress">
                                        <div class="task_title"><?php echo $weekly_task->parent_tasks[$i]->title; ?></div>
                                        <div class="task_progress"><?php echo $progress; ?>%</div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: <?php echo $progress; ?>%;"></div>
                                    </div>
                                <?php endfor ; ?>
                            </div>
                        </div>
                    <?php endif ;?>
                <?php endforeach; ?>
            </div>
        </li>
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
<?php
    include __DIR__ . "/task-add-popup/task-add-popup-template.php";
    include __DIR__ . "/task-add-popup/task-add-popup-content.php";
    include __DIR__ . "/js/popup-handler-js.php";
    include __DIR__ . "/js/member-task-js.php";
?>
