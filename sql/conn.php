<?php

include_once('../config.php');

class db {
    private $conn;
    private $result;

    public function __construct() {
        global $username, $password, $server, $dbname;
        $this->conn = new mysqli($server, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        $this->result = $this->conn->query($sql);
        return $this->result;
    }

    public function fetch() {
        return $this->result->fetch_assoc();
    }

    public function fetchAll() {
        $data = array();
        while ($row = $this->result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function numRows() {
        return $this->result->num_rows;
    }

    public function escape($str) {
        return $this->conn->real_escape_string($str);
    }

    public function insertId() {
        return $this->conn->insert_id;
    }

    public function fetchArray() {
        return $this->result->fetch_array();
    }
    public function __destruct() {
        $this->conn->close();
    }
}


?>