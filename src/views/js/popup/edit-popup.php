<script>
const $openEditTaskBtns = document.querySelectorAll(".open__edit__task__btn");
const $taskEditPopup = document.getElementById("task-edit-popup");
const $taskEditPopupContent = document.getElementById("task-edit-template");

popupAddEventListener($taskEditPopup, $taskEditPopupContent);

function addSaveBtnEvent($popup) {
  const $saveBtn = $popup.querySelector(".save__btn");

  if ($saveBtn === null) return;
  console.log($saveBtn);

  $saveBtn.addEventListener("click", (e) => {
    e.preventDefault();

    const parentTaskName = $popup.querySelector("#parent-task-php").value;

    const parentTaskProgress = Number(
      $popup.querySelector("#parent-task-progress-php").textContent.slice(0, -1)
    );

    // 子タスクを取得
    const $childTasksContainer = $popup.querySelector(
      ".child__task__container"
    );
    const $childTasks = $childTasksContainer.querySelectorAll(
      ".child__task__list__container"
    );
    const childTasks = [];

    for ($childTask of $childTasks) {
      const childTaskName =
        $childTask.querySelector(".child__task__php").textContent;
      const childTaskComment = $childTask.querySelector(
        ".child__task__comment__php textarea"
      ).value;

      const childTaskProgress = Number(
        $childTask
          .querySelector(
            ".progress__container .progress__character__container .selected label"
          )
          .textContent.slice(0, -1)
      );

      childTasks.push({
        child_task_id: +$childTask.querySelector(".hidden").textContent,
        child_task_name: childTaskName,
        child_task_comment: childTaskComment,
        child_task_progress: +childTaskProgress,
      });
    }

    const parentTaskId = Number($popup.querySelector(".hidden").textContent);

    const data = {
      parent_task_id: parentTaskId,
      parent_task_name: parentTaskName,
      parent_task_progress: parentTaskProgress,
      child_tasks: childTasks,
    };

    console.log(data);

    fetch("http://localhost:8080/api/update.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((data) => {
        console.log("受信成功", data);
      })
      .catch((e) => console.error("Error:", e));
  });
}

addSaveBtnEvent($taskEditPopup);

$openEditTaskBtns.forEach(($openEditTaskBtn) => {
  $openEditTaskBtn.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("click");

    if ($openEditTaskBtn.classList.contains("popup__open")) {
      $openPopups = document.querySelectorAll(".popup__open");
      $openPopups.forEach(($openPopup) => {
        $openPopup.classList.remove("popup__open");
      });
      return;
    }
    const $progressBar = $openEditTaskBtn.parentElement.nextElementSibling;
    $progressBar.classList.toggle("popup__open");

    const rect = $progressBar.getBoundingClientRect();
    const popupWidth = $taskEditPopup.offsetWidth;
    const popupHeight = $taskEditPopup.offsetHeight;

    $taskEditPopup.style.top = `50vh - ${popupHeight}px / 2 - 40px`;
    if (rect.left < window.innerWidth / 2) {
      $taskEditPopup.style.left = `calc(${rect.left}px + ${rect.width}px + ${popupWidth}px * 2)`;
    } else {
      $taskEditPopup.style.left = `calc(${rect.left}px - ${rect.width}px - ${popupWidth}px)`;
      console.log(rect.left);
    }

    $taskEditPopup.classList.toggle("popup__open");
    const $cover = document.querySelector(".cover");
    $cover.classList.toggle("popup__open");
    $openEditTaskBtn.classList.toggle("popup__open");

    $openEditTaskBtn
      .closest(".title_progress")
      .querySelector(".task_progress")
      .classList.toggle("popup__open");
    $openEditTaskBtn
      .closest(".weekly__report__task__container")
      .querySelector(".date")
      .classList.toggle("popup__open");
    $openEditTaskBtn
      .closest(".weekly__report")
      .querySelector(".user__name div")
      .classList.toggle("popup__open");
    $openEditTaskBtn
      .closest(".weekly__report")
      .querySelector(".user__name")
      .classList.toggle("popup__open");
    console.log(
      $openEditTaskBtn
        .closest(".weekly__report")
        .querySelector(".user__name div")
    );
    $taskEditPopup.querySelector("#parent-task-php").textContent =
      $openEditTaskBtn.dataset.parent_task_name;
    const parentTaskProgress = Number(
      $openEditTaskBtn.dataset.parent_task_progress
    );
    const $parentTaskProgress = $taskEditPopup.querySelector(
      "#parent-task-progress-php"
    );
    $parentTaskProgress.textContent = parentTaskProgress + "%";

    if (parentTaskProgress === 0) {
      $parentTaskProgress.style.color = "white";
    } else if (parentTaskProgress > 80) {
      $parentTaskProgress.style.color = "green";
    } else if (parentTaskProgress > 60) {
      $parentTaskProgress.style.color = "blue";
    } else if (parentTaskProgress > 30) {
      $parentTaskProgress.style.color = "yellow";
    } else {
      $parentTaskProgress.style.color = "red";
    }

    const $evaluationBtn = $taskEditPopup.querySelector(".btn.evaluation");
    if (parentTaskProgress !== 100) {
      $evaluationBtn.disabled = true;
      if (!$evaluationBtn.classList.contains("disabled"))
        $evaluationBtn.classList.add("disabled");
    } else {
      $evaluationBtn.disabled = false;
      if ($evaluationBtn.classList.contains("disabled"))
        $evaluationBtn.classList.remove("disabled");
    }

    // hiddenの子タスクを取得

    // hiddenを取得する
    $taskEditPopup.querySelector(".hidden").textContent =
      $openEditTaskBtn.dataset.parent_task_id;

    fetch(`http://localhost:8080/api/child-tasks/fetch-all.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        parent_task_id: $openEditTaskBtn.dataset.parent_task_id,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        console.log("受信成功", data);
        // popup-handler
        setChildTasks(
          data,
          $taskEditPopup,
          document.getElementById("task-edit-template")
        );
      })
      .catch((e) => {
        console.error("Error:", e);
      });
  });
});


</script>
