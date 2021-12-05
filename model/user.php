<?php 
    class User{

        private $id;
        private $username;
        private $password;
        private $cardId;

        public function set_user($id, $conn) {
            // adatbázisból lekérdezzük
            $sql = "SELECT *  FROM users";
            $sql .= " WHERE id = $id ";
            $result = $conn->query($sql);
            if ($conn->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $this->id = $row['id'];
                    $this->username = $row['username'];
                    $this->password = $row['password'];
                    $this->cardId = $row['cardId'];
                }
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    
        public function get_id() {
            return $this->id;
        }

        public function get_username(){
            return $this->username;
        }

        public function get_password(){
            return $this->password;
        }

        public function get_cardId(){
            return $this->cardId;
        }

    }//class
?>