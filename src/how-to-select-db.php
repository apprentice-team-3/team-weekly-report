<?php
require_once "datasource.php";

use db\DataSource;

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


