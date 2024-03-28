<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/views/css/member-task_style.css">
    <title>TWR -<?php echo $title; ?>-</title>
</head>
<body>
    <header>
        <div class="main-header">
            <svg id="_レイヤー_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255.56 105.04"><g id="_レイヤー_1-2"><path d="M18.36,41.76l-.86.09c-3.63.39-6.36,6.7-6.36,14.05v20.05l-5.6-1.4v-18.85c0-6.91-2.31-12.32-4.97-12.04l-.58.06v-11.78l18.36-4.59v14.4Z" style="fill:#000; stroke-width:0px;"/><path d="M21.94,26.47l6.91-1.73v31.79c0,2.23.93,4.04,2.14,4.13s2.23-1.66,2.23-3.97V23.65l8.54-2.14v35.47c0,2.48,1.16,4.52,2.68,4.62s2.8-1.84,2.8-4.43V20.14s10.83-2.71,10.83-2.71v70.22l-36.12-9.01V26.47Z" style="fill:#000; stroke-width:0px;"/><path d="M117.1,59.65c0,5.98,4.56,11.09,10.68,11.63v33.76l-26.26-6.42v-9.85c0-7.35-5.03-13.76-10.82-14.49s-9.62,3.93-9.62,10.47v8.76l-16.35-4.19V15.77L127.78,0v48.77c-6.12.11-10.68,5.04-10.68,10.88ZM101.52,39.4c0-7.22-5.03-12.41-10.82-11.58-5.52.79-9.62,6.63-9.62,13.05s4.1,11.67,9.62,11.67c5.79,0,10.82-5.78,10.82-13.14Z" style="fill:#000; stroke-width:0px;"/><path d="M237.2,27.36l18.36,4.59v11.78s-.58-.06-.58-.06c-2.66-.29-4.97,5.12-4.97,12.04v18.85s-5.6,1.4-5.6,1.4v-20.05c0-7.35-2.73-13.66-6.36-14.05l-.86-.09v-14.4Z" style="fill:#44c739; stroke-width:0px;"/><path d="M233.62,78.65l-36.12,9.01V17.44s10.83,2.71,10.83,2.71v37.03c0,2.59,1.3,4.54,2.8,4.43s2.68-2.14,2.68-4.62V21.51s8.54,2.14,8.54,2.14v33.03c0,2.31,1.04,4.06,2.23,3.97s2.14-1.9,2.14-4.13v-31.79s6.91,1.73,6.91,1.73v52.18Z" style="fill:#44c739; stroke-width:0px;"/><path d="M127.78,48.77V0s63.04,15.77,63.04,15.77v73.55s-16.35,4.19-16.35,4.19v-8.76c0-6.54-4.1-11.16-9.62-10.47-5.79.72-10.82,7.13-10.82,14.49v9.85s-26.26,6.42-26.26,6.42v-33.76c6.12-.54,10.68-5.65,10.68-11.63s-4.56-10.77-10.68-10.88ZM164.86,52.54c5.52,0,9.62-5.13,9.62-11.67,0-6.42-4.1-12.26-9.62-13.05-5.79-.83-10.82,4.36-10.82,11.58,0,7.35,5.03,13.13,10.82,13.14Z" style="fill:#44c739; stroke-width:0px;"/></g></svg>
            <h1>
                TEAM WEEKLY REPORT
            </h1>
        </div>

        <nav>
            <ul>
                <li><a href="">プロジェクト一覧</a></li>
                <li><a href="/member-task.php">タスク一覧</a></li>
                <li><a href="/evaluation.php">評価一覧</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php include $content; ?>

        <nav class="pagination-nav">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#">
                    <span>&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">先週</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">9</a></li>
                <li class="page-item"><a class="page-link" href="#">来週</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                    <span>&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </main>
</body>
</html>