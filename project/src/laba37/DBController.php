<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "rootpassword";
    private $database = "jewelry_workshop";
    
    private $conn;
    
    function __construct() {
        $this->conn = $this->connectDB();
    }
    
    function connectDB() {
        return mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }
    
    function runQuery($query) {
        $result = mysqli_query($this->conn, $query);
        $resultset = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        return $resultset;
    }
    
    function __destruct() {
        mysqli_close($this->conn);
    }
}
?>
