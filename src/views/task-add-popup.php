<link rel="stylesheet" href="/views/css/task-add-popup/task-add-popup.css">
<template id="task-template">
    <li class="child__task__list__container">
    <div class="child__task__name__remove">
        <div class="popup__text child__task child__task__php">子タスク</div>
        <div class="icon icon__remove"></div>
    </div>
    <div class="comment__box child__task__comment__php">
        <textarea
        class="comment__textarea"
        placeholder="コメントはこちらに記述してください。(任意)"
        ></textarea>
    </div>
    <div class="progress__container">
        <div class="popup__text progress__explanation__character">
        達成度を選択してください
        </div>
        <ul class="progress__character__container">
        <li
            class="popup__text progress__character child__task__progress__0__php selected"
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
            class="popup__text progress__character green child__task__progress__100__php"
        >
            <label for="">100%</label>
        </li>
        </ul>
    </div>
    </li>
</template>

<div class="button__container">
    <!-- ボタンにデータを仕込む -->
    <button class="btn" data-parent_task_id="1">ボタン</button>
    <form class="popup popup__open">
    <div class="popup__text parent__task">タスク名</div>

    <div class="parent__task__section">
        <div class="parent__task__input">
        <textarea
            id="parent-task-php"
            placeholder="タスクの名前を入力してください"
        ></textarea>
        </div>
    </div>
    <div class="child__task__section">
        <div class="popup__text relation__child__task">
        関連するタスクを登録
        </div>
        <div class="child__task__add">
        <div class="child__task__input">
            <input
            type="text"
            placeholder="関連するタスクの名前を入力してください"
            />
        </div>
        <button class="icon icon__add"></button>
        </div>
        <ul class="child__task__container"></ul>
    </div>
    <button class="btn register__btn">タスクの登録</button>
    <div class="close__btn"></div>
    </form>
    <div class="cover popup__open"></div>
</div>
<?php include __DIR__ . '/js/task-add.php'; ?>
