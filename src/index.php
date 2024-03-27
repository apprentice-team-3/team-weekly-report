<?php
require_once "datasource.php";
require_once "models/project.model.php";
require_once "models/user.model.php";
require_once "models/parent_task.model.php";
require_once "models/weekly_tasks.model.php";

// phpinfo();
use db\DataSource;
use model\Project;

try {
    $db = new DataSource;
    $db->begin();
    $sql = 'SELECT * FROM projects where id = :id;';

    $project = $db->selectOne($sql,[':id' => 1],DataSource::CLS,Project::class);

    $db->commit();
} catch (PDOException $e){
    echo 'プロジェクトを取得できませんでした。<br>';
    $db->rollback();
}



$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
if (!$pdo) {
    die("データベース接続エラー: " . $pdo->errorInfo()[2]);
}

try {
    $db = new DataSource;
    $db->begin();
    $sql = 'SELECT * FROM projects';

    $result = $db->select($sql);

    echo "<pre>";
    print_r($result);
    echo "</pre>";

    $db->commit();
} catch (PDOException $e){
    echo '時間をおいて再度お試しください。<br>';
    $db->rollback();
}

class parentTask {
    private $title;
    private $progress;

    public function _construction($title, $progress) {
        $this->title = $title;
        $this->progress = $progress;
    }

    public function save($db) {
        $stmt = $db->prepare("INSERT INTO parent_tasks (title,progress) values(?,?)");
        $stmt->bind_param("si", $this->title, $this->progress);
        $stmt->execute();
    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $progress = $_POST["progress"];

    $parentTask = new parentTask($title, $progress);
    $parentTask->save();
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
    <?php phpinfo(); ?>
    <div class="create-task">
        <form action="" method="post">
            <dl>
                <dt>タスク名</dt>
                <dd>
                    <textarea name="title" id="title" cols="30" rows="10"></textarea>
                </dd>
                <dt>関連する子タスクを登録</dt>
            </dl>
            <input type="submit" value="登録する">
        </form>
    </div>
</body>
</html>
