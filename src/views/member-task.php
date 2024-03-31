mode<link rel="stylesheet" href="/views/css/popup/popup.css">
<?php
// 任意のユーザーIDを設定
$_SESSION['user_id'] = 2;
?>

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
                                        <!-- user_idが一致しているかどうかで分離させる -->
                                    <?php $parent_task = $weekly_task->parent_tasks[$i]; ?>
                                        <?php if ($_SESSION["user_id"] == $parent_task->user_id) : ?>
                                        <button class="task_title open__edit__task__btn"
                                            data-parent_task_id="<?php $parent_task = $weekly_task->parent_tasks[$i]; echo $parent_task->id; ?>"
                                            data-parent_task_name="<?php echo $parent_task->title; ?>"
                                            data-parent_task_progress="<?php echo $parent_task->progress; ?>"
                                            data-parent_task_user_id="<?php echo $parent_task->user_id; ?>"
                                    >
                                        <?php echo $parent_task->title; ?>
                                     </button>
                                        <?php else : ?>
                                            <button class="task_title open__detail__task__btn"  data-parent_task_id="<?php $parent_task = $weekly_task->parent_tasks[$i]; echo $parent_task->id; ?>"
                                            data-parent_task_name="<?php echo $parent_task->title; ?>"
                                            data-parent_task_progress="<?php echo $parent_task->progress; ?>"
                                            data-parent_task_user_id="<?php echo $parent_task->user_id; ?>">
                                               <?php echo $parent_task->title; ?>
                                            </button>
                                    <?php endif ; ?>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const openDetailTaskBtns = document.getElementsByClassName("open__detail__task__btn");
    // const loggedInUserId = <?php echo $_SESSION['user_id']; ?>;

      // console.log(loggedInUserId);

            // if (loggedInUserId === parentTaskUserId) {
            //     // ログインユーザーIDと親タスクのユーザーIDが一致する場合の処理
            //     document.querySelector('.register__btn').style.display = "inline-block";
            //     document.querySelector('.btn__danger').style.display = "inline-block";
            //     document.querySelector('.icon__add').style.display = "inline-block";
            // } else {
            //     // ログインユーザーIDと親タスクのユーザーIDが一致しない場合の処理
            //     document.querySelector('.btn__container').style.display = "none";
            //     document.querySelector('.evaluation').style.display = "none";
            //     document.querySelector('.child__task__input').style.display = "none";
            //     document.querySelector('.icon__add').style.display = "none";
            //     document.querySelector('.icon__remove').style.display = "none";
            // }

    const $popup = document.querySelector('#task-detail-popup');

    Array.from(openDetailTaskBtns).forEach(function(openDetailTaskBtn) {
        const handleClick = function(e) {
            e.preventDefault();
            e.stopPropagation();

            const parentTaskUserId = parseInt(openDetailTaskBtn.dataset.parent_task_user_id);
            console.log(parentTaskUserId);

            // $popupを開く
            $popup.classList.add('popup__open');
        };

        openDetailTaskBtn.addEventListener("click", handleClick);
    });
});
</script>
<?php

    include __DIR__ . "/task-add-popup/task-add-popup-template.php";
    include __DIR__ . "/task-add-popup/task-add-popup-content.php";
    include __DIR__ . "/task-edit-popup/task-edit-popup-template.php";
    include __DIR__ . "/task-edit-popup/task-edit-popup-content.php";
    include __DIR__ . "/task-detail-popup/task-detail-popup-content.php";
    include __DIR__ . "/task-detail-popup/task-detail-popup-template.php";

    include __DIR__ . "/js/popup-handler-js.php";
    include __DIR__ . "/js/member-task-js.php";
?>
