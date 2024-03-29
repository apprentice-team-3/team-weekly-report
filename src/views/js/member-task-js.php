<?php ?>

<script>
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

            const rect = e.target.getBoundingClientRect();
            const popupWidth = $taskEditPopup.offsetWidth;
            const popupHeight = $taskEditPopup.offsetHeight;

            // 上下は
            $taskEditPopup.style.top = `50vh - ${popupHeight}px / 2 - 40px`;
            if (rect.left < window.innerWidth / 2) {
                $taskEditPopup.style.left = `calc(${rect.left}px + ${popupWidth}px * 2)`;
            } else {
                $taskEditPopup.style.left = `calc(${rect.left}px - ${popupWidth}px * 2)`;
            }



            $taskEditPopup.classList.toggle("popup__open");
            const $cover = document.querySelector(".cover");
            $cover.classList.toggle("popup__open");
            $openEditTaskBtn.classList.toggle("popup__open");

            $openEditTaskBtn.closest(".title_progress").querySelector(".task_progress").classList.toggle("popup__open");
            // 一番近いprogress-barを取得してしまっている
            $openEditTaskBtn.parentElement.nextElementSibling.classList.toggle("popup__open");

            $openEditTaskBtn.closest(".weekly__report__task__container").querySelector(".date").classList.toggle("popup__open");
            $openEditTaskBtn.closest(".weekly__report").querySelector(".user__name div").classList.toggle("popup__open")
        })
    })
</script>
