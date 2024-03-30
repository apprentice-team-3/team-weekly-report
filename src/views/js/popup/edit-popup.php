<script>
   const $openEditTaskBtns = document.querySelectorAll('.open__edit__task__btn')
    const $taskEditPopup = document.getElementById('task-edit-popup')
    const $taskEditPopupContent = document.getElementById('task-edit-template')

    popupAddEventListener($taskEditPopup, $taskEditPopupContent)

    const userId = $openAddTaskBtn.dataset.user_id;
    const projectId = $openAddTaskBtn.dataset.project_id;

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
            const $progressBar = $openEditTaskBtn.parentElement.nextElementSibling
            $progressBar.classList.toggle("popup__open");

            const rect = $progressBar.getBoundingClientRect();
            const popupWidth = $taskEditPopup.offsetWidth;
            const popupHeight = $taskEditPopup.offsetHeight;

            $taskEditPopup.style.top = `50vh - ${popupHeight}px / 2 - 40px`;
            if (rect.left < window.innerWidth / 2) {
                $taskEditPopup.style.left = `calc(${rect.left}px + ${rect.width}px + ${popupWidth}px * 2)`;
            } else {
                $taskEditPopup.style.left = `calc(${rect.left}px + ${rect.width}px - ${popupWidth}px * 2)`;
            }

            $taskEditPopup.classList.toggle("popup__open");
            const $cover = document.querySelector(".cover");
            $cover.classList.toggle("popup__open");
            $openEditTaskBtn.classList.toggle("popup__open");

            $openEditTaskBtn.closest(".title_progress").querySelector(".task_progress").classList.toggle("popup__open");



            $openEditTaskBtn.closest(".weekly__report__task__container").querySelector(".date").classList.toggle("popup__open");
            $openEditTaskBtn.closest(".weekly__report").querySelector(".user__name div").classList.toggle("popup__open")
            $openEditTaskBtn.closest(".weekly__report").querySelector(".user__name").classList.toggle("popup__open")
            console.log($openEditTaskBtn.closest(".weekly__report").querySelector(".user__name div"))



            console.log($openEditTaskBtn.dataset.parent_task_id)
            console.log($openEditTaskBtn.dataset.parent_task_name)

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
</script>
