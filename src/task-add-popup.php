<!-- member-task.phpと後ほど合体させます -->

<?php
require_once "datasource.php";
require_once "models/project.model.php";
require_once "models/user.model.php";
require_once "models/parent_task.model.php";
require_once "models/weekly_tasks.model.php";
require_once "services/common.php";

$title = 'メンバータスク一覧、タスク詳細ポップアップ';
$content = __DIR__ . '/views/task-add-popup.php';
include __DIR__ . '/views/layout.php';
