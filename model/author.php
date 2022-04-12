<?php 
    class Author{
        private $id;
        private $name;
        private $description;
        private $birth;
        
        public function set_author($id, $conn) {
            $sql = "SELECT *  FROM author";
            $sql .= " WHERE id = $id ";
            $result = $conn->query($sql);
            if ($conn->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $this->id = $row['id'];
                    $this->name = $row['name'];
                    $this->birth = $row['birthDate'];
                }
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        public function get_id(){
            return $this->id;
        }

        public function get_name(){
            return $this->name;
        }

        public function get_description(){
            return $this->description;
        }

        public function get_birth(){
            return $this->birth;
        }

        public static function authorList($conn) {
            $list = array();
            $sql = "SELECT id FROM author order by name asc";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }

        public function writtenBooks($conn) {
            $list = array();
            $sql = "SELECT id FROM books where AuthorId=".$this->get_id();
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }

        public function upload_author($conn,$name,$birthDate){
            $sql = "INSERT INTO author(name,birthDate) VALUES('$name','$birthDate') ";
            if($result = $conn->query($sql)) {
                echo 'Sikeres feltöltés';
            }else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

    }
?>