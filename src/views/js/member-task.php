<?php ?>

<script>
    const $openAddTaskBtns = document.querySelectorAll('.open__add__task__btn')
    const $taskAddPopup = document.getElementById('task-add-popup')
    const $taskAddPopupContent = document.getElementById('task-add-template')

    popupAddEventListener($taskAddPopup, $taskAddPopupContent)

    $openAddTaskBtns.forEach($openAddTaskBtn => {
        const projectId = $openAddTaskBtn.dataset.project_id;
        const parentTaskId = $openAddTaskBtn.dataset.user_id;

        console.log(parentTaskId,projectId)

        $openAddTaskBtn.addEventListener('click', (e) => {
            e.preventDefault()
            $taskAddPopup.classList.toggle('popup__open')
            const $cover = document.querySelector('.cover');
            $cover.classList.toggle('popup__open')
        })
    })
</script>
