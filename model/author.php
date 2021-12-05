<?php 
    class Author{
        private $id;
        private $name;
        private $description;
        private $birth;
        
        public function set_author($id, $conn) {
            $sql = "SELECT *  FROM authors";
            $sql .= " WHERE id = $id ";
            $result = $conn->query($sql);
            if ($conn->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $this->id = $row['id'];
                    $this->name = $row['name'];
                    $this->description = $row['description'];
                    $this->releaseDate = $row['releaseDate'];
                    $this->authorId = $row['author_id'];
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

        public function authorList($conn) {
            $list = array();
            $sql = "SELECT id FROM authors order by name asc";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }

        public function writtenBooks($conn,$id) {
            $list = array();
            $sql = "SELECT id FROM books where author_id=".$id;
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }

    }
?>