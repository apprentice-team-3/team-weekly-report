<?php
require_once "datasource.php";
require_once "models/project.model.php";
require_once "models/user.model.php";

$title = 'メンバータスク一覧';
$content = __DIR__ . '/views/member-task.php';
include __DIR__ . '/views/layout.php';
