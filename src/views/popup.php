<link rel="stylesheet" href="/views/css/task-add-popup/task-add-popup.css">

<!-- 親タスクは/task-detail-popup/task-detail-popup-contentで設定しています -->
<!-- <template id="task-template">
    <li class="child__task__list__container">
    <div class="child__task__name__remove">
        <div class="popup__text child__task child__task__php">子タスク</div>
        <div class="icon icon__remove"></div>
    </div>
    <div class="comment__box child__task__comment__php">
        <textarea
        class="comment__textarea comment__php"
        placeholder="サーバーからコメントを取得する"
        ></textarea>
    </div>
        <div class="comment__box hidden child__task__comment__php">子タスクについての説明</div>
    <div class="progress__container">
        <div class="popup__text progress__explanation__character">
        達成度を選択してください
        </div>
        <ul class="progress__character__container">
        <li
            class="popup__text progress__character child__task__progress__0__php"
        >
            <label for="">0%</label>
        </li>
        <li
            class="popup__text progress__character red child__task__progress__30__php"
        >
            <label for="">30%</label>
        </li>
        <li
            class="popup__text progress__character yellow child__task__progress__60__php"
        >
            <label class="" for="">60%</label>
        </li>
        <li
            class="popup__text progress__character blue child__task__progress__80__php"
        >
            <label for="">80%</label>
        </li>
        <li
            class="popup__text progress__character green child__task__progress__100__php selected"
        >
            <label for="">100%</label>
        </li>
        </ul>
    </div>
    </li>
</template> -->


<div class="button__container">
    <!-- ボタンにデータを仕込む -->
    <button class="btn open__add__task__btn" data-parent_task_id="1">タスク追加</button>
    <button class="btn open__detail__task__btn" data-create-task-user="YNSTakeru">タスク詳細</button>

    <!-- ポップアップ -->
    <?php
        // include __DIR__ . '/task-detail-popup/task-detail-popup-content.php';

        include __DIR__ . '/task-add-popup/task-add-popup-template.php';
        include __DIR__ . '/task-add-popup/task-add-popup-content.php';
    ?>
    <div class="cover"></div>
</div>

<?php include __DIR__ . '/js/task-add.php'; ?>
