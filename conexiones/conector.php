<?php
class Conexion
{
    public $server = "localhost";
    public $user = "root";
    public $password = "";
    public $db = "DB_retina";
    // Create connection
    public function conectar()
    {
        $conn = mysqli_connect($this->server, $this->user, $this->password, $this->db);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } 
        return $conn;
    }
}

?>