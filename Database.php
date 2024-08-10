<?php
class Database {
    private $connection;

    public function __construct($host, $user, $password, $dbname) {
        $this->connection = new mysqli($host, $user, $password, $dbname);

        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        if ($stmt->execute()) {
            // Check if the query is a SELECT statement
            if (stripos(trim($sql), 'SELECT') === 0) {
                return $stmt->get_result();
            } else {
                // Return the number of affected rows for non-SELECT queries
                return $stmt->affected_rows;
            }
        } else {
            // Handle errors
            return false;
        }
    }

    public function __destruct() {
        $this->connection->close();
    }
}

$db = new Database("localhost", "root", "", "form_db");
?>
