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

<script>
function addClickProgressEvent($childTasks) {
    $childTasks.forEach(($childTask) => {
        const $progressCharacters = $childTask
        .querySelector(".progress__character__container")
        .querySelectorAll(".progress__character");

        $progressCharacters.forEach(($progressCharacter) => {
        $progressCharacter.addEventListener("click", (e) => {
            e.preventDefault();
            $progressCharacters.forEach(($progressCharacter) => {
            if ($progressCharacter.classList.contains("selected")) {
                $progressCharacter.classList.remove("selected");
            }
            });
            e.target.parentNode.classList.toggle("selected");
            console.log(e.target.parentNode);
        });
        });
    });
    }

    const $button = document.querySelector(".btn");
    const $cover = document.querySelector(".cover");
    const $popup = document.querySelector(".popup");
    const $closeBtn = document.querySelector(".close__btn");

    const $doms = [$popup, $cover, $closeBtn];

    $button.addEventListener("click", (e) => {
    e.preventDefault();
    $doms.forEach((dom) => {
        dom.classList.toggle("popup__open");
    });
    const parentTaskId = $button.dataset.parent_task_id;

    const parentTaskName = document.querySelector(".parent__task");
    });

    $doms.forEach((dom) => {
    if (dom === $popup) return;
    dom.addEventListener("click", (e) => {
        e.preventDefault();
        $doms.forEach((dom) => {
        dom.classList.remove("popup__open");
        });
    });
    });
    //   templateを使って1件の子タスクを作成
    const $taskTemplate = document.querySelector("#task-template");
    const $childTaskContainer = document.querySelector(".child__task__container");
    for (let i = 0; i < 1; i++) {
    const $task = $taskTemplate.content.cloneNode(true);
    // $task.querySelector(".child__task").textContent = `子タスク${i + 1}`;
    const $explanationBtn = $task.querySelector(".explanation");
    $childTaskContainer.appendChild($task);
    }

    //   子タスク分だけ取得
    const $childTasks = document.querySelectorAll(".child__task__list__container");

    addClickProgressEvent($childTasks);

    const $addBtn = document.querySelector(".icon__add");

    $addBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const $childTaskInput = document.querySelector(".child__task__input");
    const $childTaskName = $childTaskInput.querySelector("input").value;

    const $task = $taskTemplate.content.cloneNode(true);
    $task.querySelector(".child__task").textContent = $childTaskName;

    addClickProgressEvent([$task]);

    $childTaskContainer.insertBefore($task, $childTaskContainer.firstChild);
    });

    const $registerBtn = document.querySelector(".register__btn");
    //   registerBtnが押されたら
    $registerBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const $parentTask = document.querySelector("#parent-task-php");
    const parentTaskName = $parentTask.value;
    const $childTasks = document.querySelectorAll(
        ".child__task__list__container"
    );

    const childTasks = Array.from($childTasks).map(($childTask) => {
        const childTaskName = $childTask.querySelector(".child__task").textContent;

        const progress = Number(
        $childTask.querySelector(".selected label").textContent.slice(0, -1)
        );

        const comment = $childTask.querySelector(".comment__textarea").value;

        return {
        childTaskName,
        progress,
        comment,
        };
    });

    // 子タスクを集計して親タスクの進捗を算出
    const parentTaskProgress =
        childTasks.reduce((acc, childTask) => {
        return acc + childTask.progress;
        }, 0) / childTasks.length;

    console.log(parentTaskName, parentTaskProgress, childTasks);

    $doms.forEach((dom) => {
        if (dom.classList.contains("popup__open")) {
        dom.classList.remove("popup__open");
        }
    });
});
</script>
