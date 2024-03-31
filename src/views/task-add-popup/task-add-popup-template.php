<!-- views/popup.phpで呼ばれます -->
<template id="task-add-template">
    <div class="child__task__list__container">
    <div class="popup__text child__task child__task__php">
        <textarea></textarea>
    </div>
    <div class="comment__box child__task__comment__php">
        <textarea
        class="comment__textarea"
        placeholder="コメントはこちらに記述してください。(任意)"
        ></textarea>
    </div>
    <div class="comment__box hidden child__task__comment__php">子タスクについての説明</div>
    <div class="progress__container">
        <ul class="progress__character__container">
        <li class="popup__text progress__character child__task__progress__0__php selected">
            <label for="">0%</label>
        </li>
        <li class="popup__text progress__character red child__task__progress__30__php">
            <label for="">30%</label>
        </li>
        <li class="popup__text progress__character yellow child__task__progress__60__php">
            <label for="">60%</label>
        </li>
        <li class="popup__text progress__character blue child__task__progress__80__php">
            <label for="">80%</label>
        </li>
        <li class="popup__text progress__character green child__task__progress__100__php">
            <label for="">100%</label>
        </li>
        </ul>
    </div>
    </div>
</template>
