<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <!-- 親タスク追加画面 -->
    <!-- templateの作成 -->
    <template id="task-template">
      <li class="child__task__list__container">
        <div class="child__task__name__remove">
          <div class="popup__text child__task child__task__php">子タスク</div>
          <div class="remove__icon"></div>
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
              class="popup__text progress__character child__task__progress__0__php"
            >
              0%
            </li>
            <li
              class="popup__text progress__character red child__task__progress__30__php"
            >
              <label for=""> 30%</label>
            </li>
            <li
              class="popup__text progress__character yellow child__task__progress__60__php"
            >
              <label class="" for=""> 60% </label>
            </li>
            <li
              class="popup__text progress__character blue child__task__progress__80__php"
            >
              <label for=""> 80%</label>
            </li>
            <li
              class="popup__text progress__character green child__task__progress__100__php"
            >
              <label for=""> 100%</label>
            </li>
          </ul>
        </div>
        <div class="child__task__input__container">
          <div class="child__task__input">
            <input
              type="text"
              placeholder="関連するタスクの名前を入力してください"
            />
          </div>
          <button class="add__icon"></button>
        </div>
      </li>
    </template>

    <div class="button__container">
      <!-- ボタンにデータを仕込む -->
      <button class="btn" data-parent_task_id="1">ボタン</button>
      <div class="popup popup__open">
        <div>タスク名</div>
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
          <ul class="child__task__container"></ul>
        </div>
        <button class="btn register__btn">タスクの登録</button>
        <div class="close__btn"></div>
      </div>
      <div class="cover popup__open"></div>
    </div>
    <script>
      const $button = document.querySelector(".btn");
      const $cover = document.querySelector(".cover");
      const $popup = document.querySelector(".popup");
      const $closeBtn = document.querySelector(".close__btn");

      const $doms = [$popup, $cover, $closeBtn];

      $button.addEventListener("click", () => {
        $doms.forEach((dom) => {
          dom.classList.toggle("popup__open");
        });
        // dataの取得
        const parentTaskId = $button.dataset.parent_task_id;

        const parentTaskName = document.querySelector(".parent__task");
      });

      $doms.forEach((dom) => {
        if (dom === $popup) return;
        dom.addEventListener("click", () => {
          $doms.forEach((dom) => {
            dom.classList.remove("popup__open");
          });
        });
      });
      //   templateを使って5件の子タスクを作成
      const $taskTemplate = document.querySelector("#task-template");
      const $childTaskContainer = document.querySelector(
        ".child__task__container"
      );
      for (let i = 0; i < 1; i++) {
        const $task = $taskTemplate.content.cloneNode(true);
        // $task.querySelector(".child__task").textContent = `子タスク${i + 1}`;
        const $explanationBtn = $task.querySelector(".explanation");
        $childTaskContainer.appendChild($task);
      }

      //   子タスク分だけ取得
      const $childTasks = document.querySelectorAll(
        ".child__task__list__container"
      );

      $childTasks.forEach(($childTask) => {
        const $progressCharacters = $childTask
          .querySelector(".progress__character__container")
          .querySelectorAll(".progress__character");

        $progressCharacters.forEach(($progressCharacter) => {
          $progressCharacter.addEventListener("click", (e) => {
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
    </script>
  </body>
</html>
