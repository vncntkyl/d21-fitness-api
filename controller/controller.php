<?php
require_once __DIR__ . "/../config/db.php"; // Ensure this file contains the PDO connection

class Controller
{
    public $connection;
    public $statement;
    public $isConnectionSuccess;
    public $connectionError;
    public function __construct()
    {
        $config = getDbConfig();
        try {
            $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['database'];

            $this->connection = new PDO($dsn, $config['username'], $config['password']);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->isConnectionSuccess = true;
        } catch (PDOException $e) {
            $this->connectionError = "<script defer> console.log('" . $e->getMessage() . "')</script>";
        }
    }

    public function setStatement($query)
    {
        if ($this->isConnectionSuccess) {
            $this->statement = $this->connection->prepare($query);
        } else {
            $this->send(["error" => "Database connection failed"], 500);
        }
    }

    public function send($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function execute($query, $params = [], $method = 'GET')
    {
        $this->setStatement($query);
        if ($this->statement->execute($params)) {

            return match ($method) {
                "GET" => $this->statement->fetchAll(),
                "POST" => $this->connection->lastInsertId(),
                default => $this->statement->rowCount() > 0,
            };
        }
        return false;
    }

    public function getRecords($table, $conditions = [], $conditionParams = [], $fetchType = "many", $columns = "*", $order = null)
    {
        // Convert columns to comma-separated string
        $cols = $columns !== "*" ? implode(", ", (array) $columns) : "*";

        // Start query
        $query = "SELECT {$cols} FROM {$table}";

        // Add WHERE clause if conditions exist
        if (!empty($conditions)) {
            // Automatically add ? placeholders for each condition
            $whereParts = array_map(fn($col) => "{$col} = ?", $conditions);
            $query .= " WHERE status <> 0 AND " . implode(" AND ", $whereParts);
        }else{
            $query .= " WHERE status <> 0 ";
        }

        if ($order !== null) {
            $query .= " {$order}";
        }

        // Prepare and execute the query
        $results = $this->execute($query, $conditionParams);
        return $fetchType === "one" ? $results[0] : $results;
    }

    public function addRecords($table, $columns = [], $values = [])
    {
        $cols = "(" . implode(",", $columns) . ")";
        $placeholders = "(" . implode(",", array_fill(0, count($columns), "?")) . ")";
        $query = "INSERT INTO {$table} {$cols} VALUES {$placeholders}";

        return $this->execute($query, $values, 'POST');
    }

    public function editRecords($table, $columns = [], $values = [], $conditions = [], $conditionParams = [])
    {
        // Basic validation
        if (empty($table) || empty($columns) || empty($values) || count($columns) !== count($values)) {
            throw new InvalidArgumentException("Invalid arguments provided for update operation.");
        }

        // Build SET clause
        $setClause = implode(", ", array_map(fn($col) => "{$col} = ?", $columns));

        // Build WHERE clause
        $whereClause = "";
        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(" AND ", array_map(fn($col) => "{$col} = ?", $conditions));
        }

        // Final query
        $query = "UPDATE {$table} SET {$setClause}{$whereClause}";

        // Execute with combined values
        return $this->execute($query, array_merge($values, $conditionParams), "PUT");
    }

    public function deleteRecords($table, $conditions = [], $conditionParams = [])
    {
        // Basic validation
        if (empty($table) || empty($conditions) || empty($conditionParams) || count($conditions) !== count($conditionParams)) {
            throw new InvalidArgumentException("Invalid arguments provided for delete operation.");
        }

        // Build WHERE clause
        $whereClause = implode(" AND ", array_map(fn($col) => "{$col} = ?", $conditions));

        // Final query
        $query = "DELETE FROM {$table} WHERE {$whereClause}";

        // Execute with condition params
        return $this->execute($query, $conditionParams, "DELETE");
    }
}