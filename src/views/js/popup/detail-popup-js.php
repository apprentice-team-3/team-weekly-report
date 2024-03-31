<script>
    const $openDetailTaskBtns = document.getElementsByClassName(
  "open__detail__task__btn"
);

function setPopupPosition($progressBar) {
  const $popup = document.querySelector("#task-detail-popup");
  const rect = $progressBar.getBoundingClientRect();
  const popupWidth = $popup.clientWidth;
  $userName = document.querySelector(".user__name");

  const windowWidth = 1260;

  if (rect.left < popupWidth + $userName.clientWidth) {
    $popup.style.left = `${rect.left + $progressBar.clientWidth + 30 + $popup.clientWidth / 2}px`;
  } else {
    $popup.style.left = `${rect.left - $popup.clientWidth/2 - 20}px`;
  }
}

const $popup = document.querySelector("#task-detail-popup");
const $taskDetailTemplate = document.querySelector("#task-detail-template");

popupAddEventListener($popup, $taskDetailTemplate);

for (const $openDetailTaskBtn of $openDetailTaskBtns) {
  $openDetailTaskBtn.addEventListener("click", (e) => {
    e.preventDefault();

    if ($openDetailTaskBtn.classList.contains("popup__open")) {
      $openPopups = document.querySelectorAll(".popup__open");
      $openPopups.forEach(($openPopup) => {
        $openPopup.classList.remove("popup__open");
      });
      return;
    }

//     // データの受信後にポップアップの位置調整
    const $progressBar = $openDetailTaskBtn.parentElement.nextElementSibling;
    $progressBar.classList.toggle("popup__open");
    $popup.classList.add("popup__open");
    const $cover =document.querySelector('.cover');
    $cover.classList.add('popup__open');

//     const rect = $progressBar.getBoundingClientRect();
//     const popupWidth = $popup.offsetWidth;
//     const popupHeight = $popup.offsetHeight;

//     const windowWidth = 1260
//     const windowHeight = 775


//     if (rect.left < popupWidth + 40) {
//     $popup.style.left = `${rect.left + rect.width*5 - windowWidth*0.15 - 20 }px`;
// } else {
//     $popup.style.left = `${rect.left - rect.width*5 / 2  - 20}px`;
//   }

    $openDetailTaskBtn.classList.toggle("popup__open");

    $openDetailTaskBtn
      .closest(".title_progress")
      .querySelector(".task_progress")
      .classList.toggle("popup__open");
    $openDetailTaskBtn
      .closest(".weekly__report__task__container")
      .querySelector(".date")
      .classList.toggle("popup__open");
    $openDetailTaskBtn
      .closest(".weekly__report")
      .querySelector(".user__name div")
      .classList.toggle("popup__open");
    $openDetailTaskBtn
      .closest(".weekly__report")
      .querySelector(".user__name")
      .classList.toggle("popup__open");

    $popup.querySelector("#parent-task-php").textContent =
      $openDetailTaskBtn.dataset.parent_task_name;



    const parentTaskProgress = Number(
      $openDetailTaskBtn.dataset.parent_task_progress
    );


    const $parentTaskProgress = $popup.querySelector(
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

    const $evaluationBtn = $popup.querySelector(".btn.evaluation");
    if (parentTaskProgress !== 100) {
      $evaluationBtn.disabled = true;
      if (!$evaluationBtn.classList.contains("disabled"))
        $evaluationBtn.classList.add("disabled");
    } else {
      $evaluationBtn.disabled = false;
      if ($evaluationBtn.classList.contains("disabled"))
        $evaluationBtn.classList.remove("disabled");
    }

    $popup.dataset.parent_task_id = $openDetailTaskBtn.dataset.parent_task_id;

    fetch(`http://localhost:8080/api/child-tasks/fetch-all.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        parent_task_id: $openDetailTaskBtn.dataset.parent_task_id,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        console.log("受信成功", data);
        // popup-handlerで定義
        setChildTasks(
          data,
          $popup,
          document.getElementById("task-detail-template")
        );
        setPopupPosition($progressBar);
      })
      .catch((e) => {
        console.error("Error:", e);
      });
  });
}

</script>
