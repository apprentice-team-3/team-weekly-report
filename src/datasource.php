<?php

namespace db;

use PDO;

class DataSource
{

    private $conn;
    private $sqlResult;

    public function __construct($host = "mysql", $dbName = "team_weekly_report", $username = "root", $password = "root")
    {

        $dsn = "mysql:host={$host};dbname={$dbName};port=3306;";
        $this->conn = new PDO($dsn, $username, $password);

        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function select($sql = "", $params = [])
    {
        $stmt = $this->executeSql($sql, $params);
        return $stmt->fetchAll();
    }

    public function execute($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
        return $this->sqlResult;
    }

    public function selectOne($sql = "", $params = [])
    {
        $result = $this->select($sql, $params);
        return count($result) > 0 ? $result[0] : false;
    }

    public function begin()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }

    private function executeSql($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $this->sqlResult = $stmt->execute($params);
        return $stmt;
    }
}
