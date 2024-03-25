<?php

$user = "root";
$pwd = "root";
// ymlのサービス名を指定
$host = "mysql";
$dbName = "team_weekly_report";

$dsn = "mysql:host={$host};port=3036;dbname={$dbName};port=3306;";


$conn = new PDO("mysql:host={$host};dbname={$dbName};", $user, $pwd);

// 連想配列で取得するように設定
$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pst = $conn->query('select * from projects');
$result = $pst->fetchAll();

echo "<pre>";
print_r($result);
echo "</pre>";

$conn = null;
