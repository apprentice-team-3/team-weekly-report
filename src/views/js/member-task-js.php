<?php ?>

<script>
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

            $task.querySelectorAll(".progress__character").forEach($progressCharacter => {
                if($progressCharacter.classList.contains(`child__task__progress__${childTask.progress}__php`)){
                    $progressCharacter.classList.add("selected")
                }
            })
            $childTasksContainer.appendChild($task)
        })

    }

    const $openAddTaskBtn = document.querySelector('.open__add__task__btn')
    const $taskAddPopup = document.getElementById('task-add-popup')
    const $taskAddPopupContent = document.getElementById('task-add-template')

    const $openEditTaskBtns = document.querySelectorAll('.open__edit__task__btn')
    const $taskEditPopup = document.getElementById('task-edit-popup')
    const $taskEditPopupContent = document.getElementById('task-edit-template')

   popupAddEventListener($taskAddPopup, $taskAddPopupContent)
   popupAddEventListener($taskEditPopup, $taskEditPopupContent)

    const userId = $openAddTaskBtn.dataset.user_id;
    const projectId = $openAddTaskBtn.dataset.project_id;


    $openAddTaskBtn.addEventListener('click', (e) => {
        e.preventDefault()
        // popupの位置をボタンの近くで表示するようにする
        const rect = e.target.getBoundingClientRect()
        // popupの横の長さを取得
        const popupWidth = $taskAddPopup.offsetWidth
        // popupの高さを取得
        const popupHeight = $taskAddPopup.offsetHeight

        $taskAddPopup.style.top = `calc(${rect.top}px + ${popupHeight}px / 2)`
        $taskAddPopup.style.left = `calc(${rect.left}px + ${popupWidth}px * 2)`

        $taskAddPopup.classList.toggle('popup__open')
        const $cover = document.querySelector('.cover');
        $cover.classList.toggle('popup__open')

        $taskAddPopup.querySelector("#input_user_id").value = userId;
        $taskAddPopup.querySelector("#input_project_id").value = projectId;
    })

    $openEditTaskBtns.forEach($openEditTaskBtn => {
        $openEditTaskBtn.addEventListener("click", (e) => {
            e.preventDefault();
            if($openEditTaskBtn.classList.contains("popup__open")){
                $openPopups = document.querySelectorAll(".popup__open");
                $openPopups.forEach($openPopup => {
                    $openPopup.classList.remove("popup__open");
                });
                return;
            }

           const $progressBar =  $openEditTaskBtn.parentElement.nextElementSibling;

            const rect = $progressBar.getBoundingClientRect();
            console.log(rect)
            const popupWidth = $taskEditPopup.offsetWidth;
            const popupHeight = $taskEditPopup.offsetHeight;
            console.log(popupWidth);

            $taskEditPopup.style.top = `50vh - ${popupHeight}px / 2 - 40px`;
            if (rect.left < window.innerWidth / 2) {
                $taskEditPopup.style.left = `calc(${rect.left}px + ${rect.width}px + ${popupWidth}px * 2)`;
            } else {
                $taskEditPopup.style.left = `calc(${rect.left}px - ${popupWidth}px * 2)`;
            }

            $taskEditPopup.classList.toggle("popup__open");
            const $cover = document.querySelector(".cover");
            $cover.classList.toggle("popup__open");
            $openEditTaskBtn.classList.toggle("popup__open");

            $openEditTaskBtn.closest(".title_progress").querySelector(".task_progress").classList.toggle("popup__open");
            $progressBar.classList.toggle("popup__open");
            $openEditTaskBtn.closest(".weekly__report__task__container").querySelector(".date").classList.toggle("popup__open");
            $openEditTaskBtn.closest(".weekly__report").querySelector(".user__name div").classList.toggle("popup__open")
            $openEditTaskBtn.closest(".weekly__report").querySelector(".user__name").classList.toggle("popup__open")

            $taskEditPopup.querySelector("#parent-task-php").textContent = $openEditTaskBtn.dataset.parent_task_name
            const parentTaskProgress = Number($openEditTaskBtn.dataset.parent_task_progress)
            const $parentTaskProgress = $taskEditPopup.querySelector("#parent-task-progress-php")
            $parentTaskProgress.textContent = parentTaskProgress + "%"

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

            const $evaluationBtn = $taskEditPopup.querySelector(".btn.evaluation")
            if(parentTaskProgress !== 100){
                $evaluationBtn.disabled = true
                if(!$evaluationBtn.classList.contains("disabled"))
                    $evaluationBtn.classList.add("disabled")
            }else{
                $evaluationBtn.disabled = false
                if($evaluationBtn.classList.contains("disabled"))
                    $evaluationBtn.classList.remove("disabled")
            }
            console.log("parent_task_id")
            console.log($openEditTaskBtn.dataset.parent_task_id)

            fetch(`http://localhost:8080/api/child-tasks/fetch-all.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    "parent_task_id": $openEditTaskBtn.dataset.parent_task_id
                })
            }).then((res) => res.json()).then(data =>
            {
                console.log("受信成功",data)
                setChildTasks(data, $taskEditPopup, document.getElementById("task-edit-template"))

            }
            ).catch((e) => console.error("Error:", e))
        })
    })

    //　進捗度バーを着色
    <?php for($k = 0; $k < $j; $k++) :?>
        let progressBar<?php echo $k;?> = document.getElementById(<?php echo $k;?>);
        let percent<?php echo $k;?> = <?php echo $progresses[$k]; ?>;

        progressBar<?php echo $k;?>.classList.remove('progress-30', 'progress-60', 'progress-80', 'progress-100');
        if (percent<?php echo $k;?> === 30) {
            progressBar<?php echo $k;?>.classList.add('progress-30');
        } else if (percent<?php echo $k;?> === 60) {
            progressBar<?php echo $k;?>.classList.add('progress-60');
        } else if (percent<?php echo $k;?> === 80) {
            progressBar<?php echo $k;?>.classList.add('progress-80');
        } else {
            progressBar<?php echo $k;?>.classList.add('progress-100');
        }
    <?php endfor;?>
</script>
