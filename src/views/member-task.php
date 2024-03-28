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
                        ?>
                        <?php if ($weekly_task->parent_tasks[0]->user_id === $user->id) : ?>
                            <?php if ($weekly_task->date === $today) :?>
                                <?php echo $weekly_task->getDate() . ' 本日'; ?>
                            <?php endif ; ?>
                            <?php if ($weekly_task->date !== $today) :?>
                                <?php echo $weekly_task->getDate(); ?>
                            <?php endif ; ?>
                        <?php endif ;?>
                        </div>
                        <?php if($weekly_task->parent_tasks[0]->user_id === $user->id) : ?>
                            <div class="task">
                                <?php echo $weekly_task->parent_tasks[0]->title; ?>
                            </div>
                        <?php endif ; ?>
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
