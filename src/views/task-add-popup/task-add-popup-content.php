<form class="popup" id="task-add-popup">
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
        <!-- ulの中でtemplateを量産する -->
        <ul class="child__task__container"></ul>
    </div>
    <button class="btn register__btn">タスクの登録</button>
    <div class="close__btn"></div>
    <input type="hidden" id="input_user_id" value="" />
    <input type="hidden" id="input_project_id" value="" />
    <input type="hidden" id="input_parent_task_id" value="" />

</form>
