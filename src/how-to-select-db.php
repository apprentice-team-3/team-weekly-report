<?php
require_once "datasource.php";
require_once "models/project.model.php";

use db\DataSource;
use model\Project;

try {
    $db = new DataSource;
    $db->begin();
    $sql = 'SELECT * FROM projects';

    $result = $db->select($sql,[],DataSource::CLS,Project::class);

    echo "<pre>";
    print_r($result);
    echo "</pre>";

    $db->commit();
} catch (PDOException $e){
    echo '時間をおいて再度お試しください。<br>';
    $db->rollback();
}


