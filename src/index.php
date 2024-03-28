<?php
require_once "datasource.php";
require_once "models/project.model.php";
require_once "models/user.model.php";
require_once "models/parent_task.model.php";
require_once "models/weekly_tasks.model.php";

// phpinfo();
use db\DataSource;
use model\Project;

class parentTask {
    private $parentTitle;
    private $parentProgress;
    
    public function __construct($parentTitle, $parentProgress) {
    $this->title = $parentTitle;
    $this->progress = $parentProgress;
    }
        
    public function save($db, $projectId, $userId) {
        $sql = "INSERT INTO parent_tasks (project_id, user_id, title, progress) VALUES (?, ?, ?, ?)";
        $params = [$projectId, $userId, $this->title, $this->progress];
        $db->execute($sql, $params);
        return $db->getLastInsertId();
    }
}

class childTask {
    private $childTitle;
    private $childContent;
    private $childProgress;

    public function __construct($childTitle, $childProgress) {
        $this->childTitle = $childTitle;
        $this->childProgress = $childProgress;
    }

    public function save($db, $parentTaskId) {
        $sql = "INSERT INTO child_tasks (parent_task_id, title, progress) VALUES (?, ?, ?)";
        $params = [$parentTaskId, $this->childTitle, $this->childProgress];
        $db->execute($sql, $params);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parentTitle = $_POST["parent-title"];
    $childTitle = $_POST["child-title"];
    $childProgress = intval($_POST["child-progress"]);
    $projectId = 2;
    $userId = 1;
    
    $db = new DataSource();
    
    $parentTask = new parentTask($parentTitle, 0);
    $parentTaskId = $parentTask->save($db, $projectId, $userId);
    
    if ($parentTaskId) {
        $childTask = new childTask($childTitle, $childProgress);
        $childTask->save($db, $parentTaskId);
    } else {
        // 親タスクの登録に失敗した場合のエラーハンドリング
        echo "親タスクの登録に失敗しました。";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>親タスク作成</title>
</head>
<body>
    <div class="create-task">
        <form action="index.php" method="post">
            <label for="title">タスク名</label>
            <input type="text" name="parent-title" id="title">
            <label for="title">子タスク名</label>
            <input type="text" name="child-title" id="title">
            <label for="quantity">進捗度:</label>
        <select id="progress" name="child-progress">
        <option value="1">0~20</option>
        <option value="2">21~40</option>
        <option value="3">41~60</option>
        <option value="4">61~80</option>
        <option value="5">100</option>
        </select>

        <input type="submit" value="送信">
        </form>
    </div>
</body>
</html>
