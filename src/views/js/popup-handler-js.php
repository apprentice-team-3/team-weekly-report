<script>
function changeProgressColor(parentTaskProgress, $parentTaskProgress){
  if(parentTaskProgress === 0){
      $parentTaskProgress.style.color = "white"
  } else if(parentTaskProgress > 80){
      $parentTaskProgress.style.color = "green"
  } else if(parentTaskProgress > 60){
      $parentTaskProgress.style.color = "blue"
  } else if(parentTaskProgress > 30){
      $parentTaskProgress.style.color = "yellow"
    } else {
      $parentTaskProgress.style.color = "red"
  }
}

function displayParentTaskProgress($childTasks){
      const progress = []
    for($childTask of $childTasks){
      progress.push(Number($childTask.querySelector(".selected label").textContent.slice(0, -1)))
    }

    console.log("計算",progress)

    const parentTaskProgress = progress.reduce((acc, progress) => {
        return acc + progress;
    }, 0) / progress.length;

    const $popup =document.getElementById("task-edit-popup");
    $popup.querySelector("#parent-task-progress-php").textContent = parentTaskProgress + "%";

    changeProgressColor(parentTaskProgress, $popup.querySelector("#parent-task-progress-php"))
  }

function addClickProgressEvent($childTasks) {
  $childTasks.forEach(($childTask) => {
    const $progressCharacters = $childTask
      .querySelector(".progress__character__container")
      .querySelectorAll(".progress__character");

    $progressCharacters.forEach(($progressCharacter) => {

      $progressCharacter.addEventListener("click", (e) => {
        e.preventDefault();



        if(e.target.tagName !== "LABEL")
          return;

        e.target.parentNode.parentNode.querySelectorAll("li").forEach(($li) => {
          if($li.classList.contains("selected")){
            $li.classList.remove("selected");
          }
        });

        if(!e.target.parentNode.classList.contains("selected")){
          e.target.parentNode.classList.add("selected");
        }

        displayParentTaskProgress($childTasks);
      });
    });
  });
}


function setChildTasks(childTasks, $popup, $taskTemplate){
        $childTasksContainer = $popup.querySelector(".child__task__container")
        // 既存の子タスクを削除
        while($childTasksContainer.firstChild){
            $childTasksContainer.removeChild($childTasksContainer.firstChild)
        }
        // 子タスクを追加
        childTasks.forEach(childTask => {
            console.log(childTask)
            const $task = $taskTemplate.content.cloneNode(true)
            $task.querySelector(".child__task").textContent = childTask.title
            $task.querySelector(".comment__textarea").value = childTask.content

            $task.querySelector(`.child__task__progress__${childTask.progress}__php`).classList.add("selected")

            $childTasksContainer.appendChild($task)
        })
        const $childTasks = $childTasksContainer.querySelectorAll(".child__task__list__container")
        addClickProgressEvent($childTasks)
        displayParentTaskProgress($childTasks)


    }

function addRegisterBtnEvent ($popup) {
  const $registerBtn = $popup.querySelector(".register__btn");
  if($registerBtn === null) return;

  $registerBtn.addEventListener("click", (e) => {
    e.preventDefault();

    const $parentTask = $popup.querySelector("#parent-task-php");

    const parentTaskName = $parentTask.value
      ? $parentTask.value
      : $parentTask.textContent;

    const $childTasks = $popup.querySelectorAll(
      ".child__task__list__container"
    );
    const childTasks = Array.from($childTasks).map(($childTask) => {
      const childTaskName =
        $childTask.querySelector(".child__task").textContent;
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

    const parentTaskProgress =
      childTasks.reduce((acc, childTask) => {
        return acc + childTask.progress;
      }, 0) / childTasks.length;


      const userId =$popup.querySelector("#input_user_id").value;
      const projectId =$popup.querySelector("#input_project_id").value;


      // ここにサーバーの処理をお願いします

      // fetchする
      const safeParentTaskProgress = isNaN(parentTaskProgress) ? 0 : parentTaskProgress;

      if(childTasks.length === 0){
        alert("関連するタスクを入力してください");
        return;}

      fetch("http://localhost:8080/api/post.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          "user_id": +userId,
          "project_id": +projectId,
          "parent_task_name": parentTaskName,
          "parent_task_progress": safeParentTaskProgress,
          "child_tasks": childTasks
        })
      })
        .then((res) => {
          return res.json();
        }).then((json) => {
          console.log("送ったデータ")
          console.log(json);
          // fetch通信後に再リロード
          location.reload();
        })
        // エラーハンドリングが出るのでfetchでデータが送れてない（なんぜ）
        .catch((e) => {
          console.error("Error:", e);
        })

        $openPopup = document.querySelectorAll(".popup__open");
        $openPopup.forEach((dom) => {
          dom.classList.remove("popup__open");
        });
  });
}

function addSaveBtnEvent($popup){
  const $saveBtn = $popup.querySelector(".save__btn");
  if($saveBtn === null) return;

  $saveBtn.addEventListener("click", (e) => {
    e.preventDefault();

    const $parentTask = $popup.querySelector("#parent-task-php").value;


  })
}


function popupAddEventListener($popup, $taskTemplate) {
  if (!$popup) return;

  let $cover = document.querySelector(".cover");

  if (!$cover) {
    const $main = document.querySelector("main");
    $cover = document.createElement("div");
    $cover.classList.add("cover");
    $main.insertAdjacentElement("afterend", $cover);
  }
  const $closeBtn = $popup.querySelector(".close__btn");

  const $doms = [$cover,$closeBtn];


  $doms.forEach(($dom) => {

    $dom.addEventListener("click", (e) => {
      e.preventDefault();
        $popup.classList.remove("popup__open");
        $doms.forEach((dom) => {
          dom.classList.remove("popup__open");
        });

        $openDom = document.querySelectorAll(".popup__open");
        $openDom.forEach((dom) => {
          dom.classList.remove("popup__open");
        });
    });
  });

  const $addBtn = $popup.querySelector(".icon__add");
  const $childTaskContainer = $popup.querySelector(".child__task__container");

  $addBtn.addEventListener("click", (e) => {
    e.preventDefault();
    const $childTaskInput = $popup.querySelector(".child__task__input");
    const $childTaskName = $childTaskInput.querySelector("input").value;
    const $task = $taskTemplate.content.cloneNode(true);
    $task.querySelector(".child__task").textContent = $childTaskName;
    addClickProgressEvent([$task]);
    $childTaskContainer.insertBefore($task, $childTaskContainer.firstChild);
    $childTaskInput.querySelector("input").value = "";
    $childTaskInput.querySelector("input").focus();
  });

  addRegisterBtnEvent($popup);
  addSaveBtnEvent($popup);
}
</script>
