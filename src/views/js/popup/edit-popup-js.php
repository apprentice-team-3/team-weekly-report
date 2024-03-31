<script>
const $openEditTaskBtns = document.querySelectorAll(".open__edit__task__btn");
const $taskEditPopup = document.getElementById("task-edit-popup");
const $taskEditPopupContent = document.getElementById("task-edit-template");

// 子タスクの追加ボタンはpop-up-handlerで定義
popupAddEventListener($taskEditPopup, $taskEditPopupContent);

// Todo 進捗表示処理を移植する ちょっと時間かかりそー

function setEditPopupPosition($progressBar){
  const rect = $progressBar.getBoundingClientRect();
    const $pp = document.querySelector("#task-edit-popup");
    // // 30マージン $progressBar
    $userName = document.querySelector(".user__name");

    const windowWidth = 1260

    if(rect.left < $pp.clientWidth + $userName.clientWidth){
      $pp.style.left = `${rect.left + $progressBar.clientWidth + 30 + $pp.clientWidth/2 }px`;
      console.log("おい")
    }else{
      $pp.style.left = `${rect.left - $pp.clientWidth/2 - 20}px`;
    }
}


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
    const newChildTasks = [];

    for ($childTask of $childTasks) {
      const childTaskName =
        $childTask.querySelector(".child__task__php textarea").value;
      const childTaskComment = $childTask.querySelector(
        ".child__task__comment__php textarea"
      ).value;

      childTaskProgress = $childTask.querySelector(".progress__container .progress__character__container .selected label").textContent.slice(0,-1)


      if($childTask.dataset.child_task_id){
        childTasks.push({
          child_task_id: +$childTask.dataset.child_task_id,
          child_task_name: childTaskName,
          child_task_comment: childTaskComment,
          child_task_progress: +childTaskProgress,
        });
      }else{
        newChildTasks.push({
          child_task_name: childTaskName,
          child_task_comment: childTaskComment,
          child_task_progress: +childTaskProgress,
        });
      }

    }

    const parentTaskId = Number($popup.dataset.parent_task_id);

    const data = {
      parent_task_id: parentTaskId,
      parent_task_name: parentTaskName,
      parent_task_progress: parentTaskProgress,
      child_tasks: childTasks,
      new_child_tasks: newChildTasks,
    };

      console.log("送信前")

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
        location.reload();
      })
      .catch((e) => console.error("Error:", e));
  });
}

addSaveBtnEvent($taskEditPopup);
deleteTask($taskEditPopup);

$openEditTaskBtns.forEach(($openEditTaskBtn) => {
  $openEditTaskBtn.addEventListener("click", (e) => {
    e.preventDefault();

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
    // const popupWidth = $popup.offsetWidth;
    // editのポップアップがちっちゃい😭
    const popupWidth = 484;
    const popupHeight = $popup.offsetHeight;

    const windowWidth = 1260
    const windowHeight = 775

    // console.log($progressBar)
    // console.log(rect)
    // const $pp = document.querySelector("#task-edit-popup");
    // // 30マージン
    // const $pb = document.querySelector(".progress-bar")
    // $userName = document.querySelector(".user__name");

    // // 値が更新されてからじゃないとダメ

    // if (rect.left < popupWidth + 40) {
    //   $pp.style.left = `${$pp.clientWidth/2 + $userName.clientWidth + $pb.clientWidth+30 }px`;
    //   console.log($pp.clientWidth)
    //   console.log($userName.clientWidth)
    //   console.log($pb.clientWidth)
    //   console.log($pp.style.left)
    // } else {
    //    $popup.style.left = `${rect.left - rect.width / 2 -20}px`;
    // }


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


    $taskEditPopup.dataset.parent_task_id =
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
        // popup-handlerで定義
        setChildTasks(
          data,
          $taskEditPopup,
          document.getElementById("task-edit-template")
        );
        setEditPopupPosition($progressBar)
      })
      .catch((e) => {
        console.error("Error:", e);
      });
  });
});


</script>
