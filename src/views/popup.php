<link rel="stylesheet" href="/views/css/task-add-popup/task-add-popup.css">
<div class="button__container">
    <!-- ボタンにデータを仕込む -->
    <button class="btn open__add__task__btn" data-parent_task_id="1">タスク追加</button>
    <button class="btn open__detail__task__btn" data-create-task-user="YNSTakeru">タスク詳細</button>

    <!-- ポップアップ -->
    <?php
        include __DIR__ . '/task-detail-popup/task-detail-popup-content.php';
        include __DIR__ . '/task-detail-popup/task-detail-popup-template.php';
        include __DIR__ . '/task-add-popup/task-add-popup-template.php';
        include __DIR__ . '/task-add-popup/task-add-popup-content.php';
    ?>
    <div class="cover"></div>
</div>

<?php include __DIR__ . '/js/task-add.php'; ?>
