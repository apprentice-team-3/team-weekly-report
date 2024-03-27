<template id="task-template">
      <div class="child__task__list__container">
        <div class="popup__text child__task child__task__php">子タスク</div>
        <div class="btn__container">
          <button class="btn explanation">説明を表示</button>
        </div>
        <div class="comment__box hidden child__task__comment__php">子タスクについての説明</div>
        <div class="progress__container">
          <ul class="progress__character__container">
            <li class="popup__text progress__character child__task__progress__0__php">0%</li>
            <li class="popup__text progress__character red child__task__progress__30__php">30%</li>
            <li class="popup__text progress__character yellow child__task__progress__60__php">60%</li>
            <li class="popup__text progress__character blue child__task__progress__80__php">80%</li>
            <li class="popup__text progress__character green child__task__progress__100__php">100%</li>
          </ul>
        </div>
      </div>
    </template>

    <div class="button__container">
      <!-- ボタンにデータを仕込む -->
      <button class="btn" data-parent_task_id="1">ボタン</button>
      <div class="popup popup__open">
        <div class="parent__task__section">
          <div class="parent__task popup__text" id="parent-task">親タスク</div>
          <div class="relative__progress__container">
            <div class="popup__text parent__progress green" id="parent-task-progress">100%</div>
            <button class="btn evaluation">評価する</button>
          </div>
        </div>
        <div class="child__task__section">
          <div class="popup__text relation__child__task">
            関連するタスクを登録
          </div>
          <ul class="child__task__container"></ul>
        </div>
        <div class="close__btn"></div>
      </div>
      <div class="cover popup__open"></div>
    </div>

<script>
    const $button = document.querySelector('.btn')
    const $cover = document.querySelector('.cover')
    const $popup = document.querySelector('.popup')
    const $close = document.querySelector('.close__btn')

    const $doms = [$popup, $cover, $close]


    $button.addEventListener('click', () => {
        $doms.forEach(dom => {
            dom.classList.toggle('popup__open')
        })
        // dataの取得
        const parentTaskId = $button.dataset.parent_task_id

        const parentTaskName = document.querySelector('.parent__task')
        <?php
            $parentTaskId = '<script>document.write(parentTaskId)</script>';

            $parent_tasks = array_values(array_filter($parent_tasks, function($parent_task) {
                return $parent_task->id === 1;
            }));
         ?>
        parentTaskName.textContent = JSON.parse('<?php echo json_encode($parent_tasks[0]->title);?>')
    })

    $doms.forEach(dom => {
        if(dom === $popup) return
        dom.addEventListener('click', () => {
            $doms.forEach(dom => {
                dom.classList.remove('popup__open')
            })
        })
    })

    const $taskTemplate = document.querySelector("#task-template");
      const $childTaskContainer = document.querySelector(
        ".child__task__container"
      );
      for (let i = 0; i < 10; i++) {
        const $task = $taskTemplate.content.cloneNode(true);
        $task.querySelector(".child__task").textContent = `子タスク${i + 1}`;
        const $explanationBtn = $task.querySelector(".explanation");
        $childTaskContainer.appendChild($task);
      }

      //   子タスク分だけ取得
      const $childTasks = document.querySelectorAll(".child__task");

      $childTasks.forEach(($childTask) => {
        const $explanationBtn =
          $childTask.nextElementSibling.querySelector(".explanation");
        const $commentBox = $childTask.nextElementSibling.nextElementSibling;
        $explanationBtn.addEventListener("click", () => {
          $commentBox.classList.toggle("hidden");
        });
      });
</script>
