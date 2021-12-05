<?php

class userSelect {
    
    private $id;
    protected $table;

    public function set_id($id, $conn) {
        $sql = "SELECT id FROM $this->table WHERE id = $id ";
        $result = $conn->query($sql);
        if ($conn->query($sql)) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
            }
            else {
                $sql = "INSERT INTO $this->table VALUES($id) ";
                if($result = $conn->query($sql)) {
                    $this->id = $id;
                }
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public function get_id() {
        return $this->id;
    }

    public function lista($conn) {
        $lista = array();
        $sql = "SELECT id FROM $this->table";
        if($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
                    $lista[] = $row['id'];
                }
            }
        }
        return $lista;
    }
}

?>