<div class="button__container">
    <button class="btn">ボタン</button>
    <div class="popup">ポップアップ</div>
    <div class="cover"></div>
</div>

<script>
    const $button = document.querySelector('.btn')
    const $cover = document.querySelector('.cover')
    const $popup = document.querySelector('.popup')

    const $doms = [$popup, $cover]

    $button.addEventListener('click', () => {
        $doms.forEach(dom => {
            dom.classList.toggle('popup__open')
        })
    })

    $doms.forEach(dom => {
        dom.addEventListener('click', () => {
            $doms.forEach(dom => {
                dom.classList.remove('popup__open')
            })
        })
    })
</script>
