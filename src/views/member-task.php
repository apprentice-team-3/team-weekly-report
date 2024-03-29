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
    <div>
        <!-- $userをdata-userに渡したい -->
        <button class="btn transition__btn open__add__task__btn" data-user_id="<?php echo $user->name ?>" data-project_id="<?php echo $project->id ?>" >今日のタスクを追加</button>
    </div>
    <ul class="weekly__report__container">
        <?php $j = 0; ?>
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
                                        <div class="today">
                                            <?php echo $weekly_task->getDate() . ' 本日'; ?>
                                        </div>
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
                                <?php for ($i = 0; $i < count($weekly_task->parent_tasks); $i++) : ?>
                                    <?php $progress = $weekly_task->parent_tasks[$i]->progress; $progresses[] = $progress; ?>
                                    <div class="title_progress">
                                        <div class="task_title"><?php echo $weekly_task->parent_tasks[$i]->title; ?></div>
                                        <div class="task_progress"><?php echo $progress; ?>%</div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" id="<?php echo $j; ?>" style="width: <?php echo $progress; ?>%;"></div>
                                    </div>
                                    <?php $j++;?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif ;?>
                <?php endforeach; ?>
            </li>
        <?php endforeach; ?>
        <script>
            /* const $users = document.querySelectorAll('.user__name')

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
            }) */

            <?php for($k = 0; $k < $j; $k++) :?>
            let progressBar<?php echo $k;?> = document.getElementById(<?php echo $k;?>);
            let percent<?php echo $k;?> = <?php echo $progresses[$k]; ?>;

            progressBar<?php echo $k;?>.classList.remove('progress-30', 'progress-60', 'progress-80', 'progress-100');
            if (percent<?php echo $k;?> === 30) {
                progressBar<?php echo $k;?>.classList.add('progress-30');
            } else if (percent<?php echo $k;?> === 60) {
                progressBar<?php echo $k;?>.classList.add('progress-60');
            } else if (percent<?php echo $k;?> === 80) {
                progressBar<?php echo $k;?>.classList.add('progress-80');
            } else {
                progressBar<?php echo $k;?>.classList.add('progress-100');
            }
            <?php endfor;?>
        </script>
    </ul>
</div>
<?php
    include __DIR__ . "/task-add-popup/task-add-popup-template.php";
    include __DIR__ . "/task-add-popup/task-add-popup-content.php";
    include __DIR__ . "/js/popup-handler-js.php";
    include __DIR__ . "/js/member-task-js.php";
?>
