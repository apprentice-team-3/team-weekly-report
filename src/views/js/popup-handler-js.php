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

  const $registerBtn = $popup.querySelector(".register__btn");
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

      console.log(userId,projectId, parentTaskName, parentTaskProgress, childTasks);


      // ここにサーバーの処理をお願いします

      // fetchする
      const safeParentTaskProgress = isNaN(parentTaskProgress) ? 0 : parentTaskProgress;

      console.log(userId)

      fetch("http://localhost:8080/api/post.php", {
        method: "POST",
        body: JSON.stringify({
          "user_id": +userId,
          "project_id": projectId,
          "parent_task_name": parentTaskName,
          "parent_task_progress" : safeParentTaskProgress
        }),
      })
        .then((res) => {
          console.log(res);
        })
        .catch((e) => {
          console.error(e);
        })


    $popup.classList.remove("popup__open");
    $cover.classList.remove("popup__open");

  });
}
</script>
