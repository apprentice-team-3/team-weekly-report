<?php
require_once "datasource.php";
require_once "models/project.model.php";
require_once "models/user.model.php";
require_once "models/parent_task.model.php";
require_once "models/child_task.model.php";
require_once "models/weekly_tasks.model.php";
require_once "services/common.php";

$title = 'メンバータスク一覧';
$content = __DIR__ . '/views/member-task.php';
include __DIR__ . '/views/member-task_layout.php';
