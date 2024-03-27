<div class="button__container">
      <!-- ボタンにデータを仕込む -->
      <button class="btn" data-parent_task_id="1">ボタン</button>
      <div class="popup popup__open">
        <div class="parent__task__section">
          <div class="parent__task popup__text">親タスク</div>
          <div class="popup__text parent__progress green">100%</div>
        </div>
        <div class="child__task__section">
          <div class="popup__text relation__child__task">
            関連するタスクを登録
          </div>
          <ul class="child__task__container">
            <li class="child__task__list__container">
              <div class="popup__text child__task">子タスク</div>
              <div class="btn__container">
                <button class="btn">説明を表示</button
                ><button class="btn">評価</button>
              </div>
              <div class="progress__container">
                <ul class="progress__character__container">
                  <li class="popup__text progress__character">0%</li>
                  <li class="popup__text progress__character red">30%</li>
                  <li class="popup__text progress__character yellow">60%</li>
                  <li class="popup__text progress__character blue">80%</li>
                  <li class="popup__text progress__character green">100%</li>
                </ul>
              </div>
            </li>
            <li class="child__task__list__container">
              <div class="popup__text child__task">子タスク</div>
              <div class="btn__container">
                <button class="btn">説明を表示</button
                ><button class="btn">評価</button>
              </div>
              <div class="progress__container">
                <ul class="progress__character__container">
                  <li class="popup__text progress__character">0%</li>
                  <li class="popup__text progress__character red">30%</li>
                  <li class="popup__text progress__character yellow">60%</li>
                  <li class="popup__text progress__character blue">80%</li>
                  <li class="popup__text progress__character green">100%</li>
                </ul>
              </div>
            </li>
          </ul>
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
</script>
