<?php 
class Database {
    private $db_host = "localhost:3306";
    private $db_username = 'admin';
    private $db_password = 'password';
    private $db_database = 'tonado';
    private $connection;

    public function connect() {
        $this->connection = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_database);
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return true;
    }
    public function prepare($data) {
        $prepare = mysqli_prepare($this->connection,$data);
        return $prepare;
    }

    public function query($sql) {
        if ($this->connection) {
            $result = mysqli_query($this->connection, $sql);
            return $result;
        } else {
            return false;
        }
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }
}


?>