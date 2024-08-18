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

    // General query method
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

    // Create (INSERT) method
    public function create($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->query($sql, array_values($data));
    }

    // Read (SELECT) method
    public function read($table, $conditions = [], $columns = '*') {
        $where = '';
        $params = [];
        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = $value;
            }
            $where = ' WHERE ' . implode(' AND ', $whereClauses);
        }
        $sql = "SELECT $columns FROM $table$where";
        return $this->query($sql, $params);
    }

    // Update method
    public function update($table, $data, $conditions) {
        $setClauses = [];
        $params = [];
        foreach ($data as $column => $value) {
            $setClauses[] = "$column = ?";
            $params[] = $value;
        }
        $setClause = implode(', ', $setClauses);

        $whereClauses = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "$column = ?";
            $params[] = $value;
        }
        $whereClause = implode(' AND ', $whereClauses);

        $sql = "UPDATE $table SET $setClause WHERE $whereClause";
        return $this->query($sql, $params);
    }

    // Delete method
    public function delete($table, $conditions) {
        $whereClauses = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "$column = ?";
            $params[] = $value;
        }
        $whereClause = implode(' AND ', $whereClauses);

        $sql = "DELETE FROM $table WHERE $whereClause";
        return $this->query($sql, $params);
    }

    public function __destruct() {
        $this->connection->close();
    }
}


$db = new Database("localhost", "root", "", "form_db");

// TESTING of CRUD Operations

// // Create
// $db->create('users', ['name' => 'John Doe', 'email' => 'john@example.com']);

// // Read
// $result = $db->read('users', ['id' => 1]);
// $user = $result->fetch_assoc();
// echo $user['name'];

// // Update
// $db->update('users', ['name' => 'Jane Doe'], ['id' => 1]);

// // Delete
// $db->delete('users', ['id' => 1]);
?>
