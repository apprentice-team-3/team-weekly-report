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

    $openEditTaskBtns.forEach($openEditTaskBtns => {
        $openEditTaskBtns.addEventListener("click", (e) => {
            e.preventDefault();
            const rect = e.target.getBoundingClientRect();
            const popupWidth = $taskEditPopup.offsetWidth;
            const popupHeight = $taskEditPopup.offsetHeight;

            // 上下は
            $taskEditPopup.style.top = `50vh`;
            if (rect.left < window.innerWidth / 2) {
                $taskEditPopup.style.left = `calc(${rect.left}px + ${popupWidth}px * 2)`;
            } else {
                $taskEditPopup.style.left = `calc(${rect.left}px - ${popupWidth}px * 2)`;
            }



            $taskEditPopup.classList.toggle("popup__open");
            const $cover = document.querySelector(".cover");
            $cover.classList.toggle("popup__open");

        })
    })
</script>
