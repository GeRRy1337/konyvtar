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
                    $this->cardId = -1;
                    $result = $conn->query("SELECT cardId from usercards where userId=".$row['id']);
                    if ($result){ 
                        if ($result->num_rows > 0){
                            $this->cardId = $result->fetch_assoc()['cardId'];
                        }
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

        public function get_username(){
            return $this->username;
        }

        public function get_password(){
            return $this->password;
        }

        public function get_cardId(){
            return $this->cardId;
        }

        public function userBorrowed($conn) {
            $list = array();
            $sql = "SELECT BookTitle,stock.stockNum,date FROM borrow inner join stock on borrow.stockNum=stock.stockNum inner JOIN books on stock.bookId=books.id where cardNum = ".$this->cardId." and state=0";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = array($row['BookTitle'],$row['stockNum'],$row['date']);
                    }
                }
            }
            return $list;
        }

    }//class
?>