<link rel="stylesheet" href="/views/css/popup/popup.css">
<div class="task__container">
    <h2 class="project__container">
        <div class="project__detail">
        <?php echo $project->title ?>
        <script>
            const progress = Number("<?php echo floor($project->progress) ?>")
            const progressPercent = progress
            document.write(progressPercent + "%")
        </script>
        完了
        </div>
    </h2>
    <div>
        <!-- $userをdata-userに渡したい -->
        <button class="btn transition__btn open__add__task__btn" data-user_id="3" data-project_id="1" >今日のタスクを追加</button>
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
                        <!-- <button class="btn transition__btn open__add__task__btn" data-user_id="<?php echo $user->id ?>" data-project_id="<?php echo $project->id ?>" >タスクを追加</button> -->
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
                                        <button class="task_title open__edit__task__btn" data-parent_task_id="<?php
                                        $parent_task = $weekly_task->parent_tasks[$i];
                                        echo $parent_task->id;
                                        ?>"
                                        data-parent_task_name="<?php echo $parent_task->title; ?>"
                                        data-parent_task_progress="<?php echo $parent_task->progress; ?>"
                                        ><?php echo $parent_task->title; ?></button>
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
    </ul>
</div>
<?php
    include __DIR__ . "/task-add-popup/task-add-popup-template.php";
    include __DIR__ . "/task-add-popup/task-add-popup-content.php";
    include __DIR__ . "/task-edit-popup/task-edit-popup-template.php";
    include __DIR__ . "/task-edit-popup/task-edit-popup-content.php";

    include __DIR__ . "/js/popup-handler-js.php";
    include __DIR__ . "/js/member-task-js.php";
?>
