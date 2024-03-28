<?php ?>
<!-- メンバータスク一覧画面のクリックイベントとかを管理します -->

<script>
    const $addTaskBtns = document.querySelectorAll(".open__add__task__btn");

    $addTaskBtns.forEach($btn =>{
        $btn.addEventListener("click",(e) =>{
            e.preventDefault();

        })
    })
</script>
