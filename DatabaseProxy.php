<?php
// DatabaseProxy.php
class DatabaseProxy {
    private $host;
    private $dbUsername;
    private $dbPassword;
    private $dbname;
    private $connection;

    public function __construct($host, $dbUsername, $dbPassword, $dbname) {
        $this->host = $host;
        $this->dbUsername = $dbUsername;
        $this->dbPassword = $dbPassword;
        $this->dbname = $dbname;
    }

    public function getConnection() {
        if (!$this->connection) {
            $this->connection = new mysqli($this->host, $this->dbUsername, $this->dbPassword, $this->dbname);
            if ($this->connection->connect_error) {
                die("Failed to connect: " . $this->connection->connect_error);
            }
        }
        return $this->connection;
    }

    public function executeQuery($query, $params = []) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function executeUpdate($query, $params = []) {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        $lastInsertId = $stmt->insert_id; // Get the last inserted ID
        $stmt->close();
        return $lastInsertId;
    }

    public function getLastInsertId() {
        $conn = $this->getConnection();
        return $conn->insert_id;
    }
}
?>