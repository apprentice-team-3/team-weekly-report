<?php

use db\DataSource;
use model\Project;

try {
    $db = new DataSource;
    $db->begin();
    $sql = 'SELECT * FROM projects where id = :id;';

    $project = $db->selectOne($sql,[':id' => 1],DataSource::CLS,Project::class);


    $db->commit();
} catch (PDOException $e){
    echo '時間をおいて再度お試しください。<br>';
    $db->rollback();
}

?>


<div class="task__container">
    <h2 class="project__container">
        <div class="project__detail">
          　<?php echo $project->title ?>
          <script>
            const progress = Number("<?php echo $project->progress ?>")
            const progressPercent = progress.toFixed(4)
            document.write(progressPercent + "%")
          </script>
          完了
        </div>
    </h2>
</div>
