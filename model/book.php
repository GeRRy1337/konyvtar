<?php

    class Book{
        private $id;
        private $name;
        private $description;
        private $releaseDate;
        private $authorId;

        public function set_book($id, $conn) {
            $sql = "SELECT *  FROM books";
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

        public function get_id() {
            return $this->id;
        }

        public function get_name(){
            return $this->name;
        }

        public function get_description(){
            return $this->description;
        }

        public function get_releaseDate(){
            return $this->releaseDate;
        }

        public function get_authorId(){
            return $this->authorId;
        }

        public function bookList($conn) {
            $list = array();
            $sql = "SELECT id FROM books";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }

        public function upload_book($conn,$name,$description,$release,$author){
            $sql = "INSERT INTO books(name,description,releaseDate,author_id) VALUES('$name','$description','$release','$author') ";
            if($result = $conn->query($sql)) {
                echo 'Sikeres feltöltés';
            }else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        public function get_lastId($conn){
            $sql = "SELECT id FROM books ORDER BY id DESC limit 1";
            $result = $conn->query($sql);
            if ($conn->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['id'];
                }
            }
        }
    }

?>
