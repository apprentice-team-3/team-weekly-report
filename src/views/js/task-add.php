<?php ?>

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
      });
    });
  });
}

function popupHandler($button, $popup, $taskTemplate){
  let $cover = document.querySelector(".cover");
  if(!$cover){
    const $main =document.querySelector("main");
    $cover = document.createElement("div");
    $cover.classList.add("cover");
    $main.insertAdjacentElement("afterend", $cover);
  }

  if(!$popup){
    return;
  }

  const $closeBtn = $popup.querySelector(".close__btn");
  const $doms = [$popup, $cover, $closeBtn];

  $button.addEventListener("click", (e) => {
    e.preventDefault();

    $doms.forEach((dom) => {
      dom.classList.toggle("popup__open");
    });

    if(!$cover.classList.contains("popup__open")){
      dom.classList.add("popup__open")
    }

    const parentTaskId = $button.dataset.parent_task_id;

    const parentTaskName = $popup.querySelector(".parent__task");
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

const $childTaskContainer = $popup.querySelector(".child__task__container");

for (let i = 0; i < 1; i++) {
  const $task = $taskTemplate.content.cloneNode(true);
  // $task.querySelector(".child__task").textContent = `子タスク${i + 1}`;
  const $explanationBtn = $task.querySelector(".explanation");
  $childTaskContainer.appendChild($task);
}

//   子タスク分だけ取得
const $childTasks = $popup.querySelectorAll(".child__task__list__container");

addClickProgressEvent($childTasks);

const $addBtn = $popup.querySelector(".icon__add");

$addBtn.addEventListener("click", (e) => {
  e.preventDefault();
  const $childTaskInput = $popup.querySelector(".child__task__input");
  const $childTaskName = $childTaskInput.querySelector("input").value;
  const $task = $taskTemplate.content.cloneNode(true);

  $task.querySelector(".child__task").textContent = $childTaskName;
  addClickProgressEvent([$task]);
  $childTaskContainer.insertBefore($task, $childTaskContainer.firstChild);
});


const $registerBtn = $popup.querySelector(".register__btn");
//   registerBtnが押されたら
$registerBtn.addEventListener("click", (e) => {
  e.preventDefault();
  const $parentTask = $popup.querySelector("#parent-task-php");

  const parentTaskName = $parentTask.value ? $parentTask.value : $parentTask.textContent;

  const $childTasks = $popup.querySelectorAll(
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
}

// const $editTaskBtn = document.querySelector(".open__detail__task__btn");
// const $editPopup = document.querySelector("#task-edit-popup");
// const $taskEditTemplate = document.querySelector("#task-edit-template");

// const $addTaskBtn = document.querySelector(".open__add__task__btn");
// const $addPopup = document.querySelector("#task-add-popup");
// const $taskAddTemplate = document.querySelector("#task-add-template");

// popupHandler($addTaskBtn, $addPopup, $taskAddTemplate);
// popupHandler($editTaskBtn, $editPopup, $taskEditTemplate);

</script>
