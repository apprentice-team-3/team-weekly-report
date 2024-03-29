<?php ?>

<script>
    const $openAddTaskBtns = document.querySelectorAll('.open__add__task__btn')
    const $taskAddPopup = document.getElementById('task-add-popup')
    const $taskAddPopupContent = document.getElementById('task-add-template')

   popupAddEventListener($taskAddPopup, $taskAddPopupContent)


    $openAddTaskBtns.forEach($openAddTaskBtn => {
        const userId = $openAddTaskBtn.dataset.user_id;
        const projectId = $openAddTaskBtn.dataset.project_id;

        console.log(userId, projectId)

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
    })
</script>
