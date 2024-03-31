mode<link rel="stylesheet" href="/views/css/popup/popup.css">
<?php
// 任意のユーザーIDを設定
$_SESSION['user_id'] = 3;
?>

<div class="task__container">
    <h2 class="project__container">
        <div class="project__detail">
        <?php echo $project->title ?>
        <span id="project-progress">
        </span>
        完了
        </div>
    </h2>
    <div>
        <!-- $userをdata-userに渡したい -->
        <button class="btn transition__btn open__add__task__btn" data-user_id="<?php echo $_SESSION['user_id']; ?>" data-project_id="1" >今日のタスクを追加</button>
    </div>
    <ul class="weekly__report__container">
        <?php $j = 0; ?>
        <?php foreach ($users as $user) : ?>
            <li class="weekly__report">
                <div class="user__name">
                    <div>
                        <?php echo $user->name ?>
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
                                    <?php
                                    $parent_task = $weekly_task->parent_tasks[$i];
                                    // 文字が10文字まで表示
                                    if (mb_strlen($parent_task->title) > 8)
                                        $title = mb_substr($parent_task->title, 0, 8) . '...';
                                    ?>
                                        <?php if ($_SESSION["user_id"] == $parent_task->user_id) : ?>
                                        <button class="task_title open__edit__task__btn"
                                            data-parent_task_id="<?php $parent_task = $weekly_task->parent_tasks[$i]; echo $parent_task->id; ?>"
                                            data-parent_task_name="<?php echo $parent_task->title; ?>"
                                            data-parent_task_progress="<?php echo $parent_task->progress; ?>"
                                            data-parent_task_user_id="<?php echo $parent_task->user_id; ?>"
                                    >
                                        <?php echo $title ?>
                                     </button>
                                        <?php else : ?>
                                            <button class="task_title open__detail__task__btn"  data-parent_task_id="<?php $parent_task = $weekly_task->parent_tasks[$i]; echo $parent_task->id; ?>"
                                            data-parent_task_name="<?php echo $parent_task->title; ?>"
                                            data-parent_task_progress="<?php echo $parent_task->progress; ?>"
                                            data-parent_task_user_id="<?php echo $parent_task->user_id; ?>">
                                               <?php echo $title ?>
                                            </button>
                                    <?php endif ; ?>

                                    <div class="task_progress"><?php
                                    // 整数だけ取り出す
                                    echo (int)$progress;
                                    ?>%</div>
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
    include __DIR__ . "/task-detail-popup/task-detail-popup-content.php";
    include __DIR__ . "/task-detail-popup/task-detail-popup-template.php";

    include __DIR__ . "/js/popup-handler-js.php";
    include __DIR__ . "/js/popup/add-popup-js.php";
    include __DIR__ . "/js/popup/edit-popup-js.php";
    include __DIR__ . "/js/popup/detail-popup-js.php";
    include __DIR__ . "/js/member-task-js.php";
?>
