<?php ?>

<div class="popup" id="task-edit-popup">
  <div class="parent__task__section">
    <div class="parent__task__input">
      <textarea
        id="parent-task-php"
        placeholder="タスクの名前を入力してください"
      ></textarea>
    </div>
    <div class="relative__progress__container">
      <div class="popup__text parent__progress green" id="parent-task-progress-php">
        100%
      </div>
      <button class="btn evaluation">評価申請</button>
    </div>
  </div>
  <div class="child__task__section">
    <div class="popup__text relation__child__task">関連するタスクを追加</div>
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
  <div class="btn__container">
    <button class="btn btn__danger">タスクを削除</button>
    <button class="btn save__btn">変更を保存</button>
  </div>
  <div class="close__btn"></div>
</div>
