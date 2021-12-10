<?php

    class Book{
        //Id,ISBN,BookTitle,BookAuthor,YearOfPublication,Publisher,ImageUrlS,ImageUrlM,ImageUrlL
        private $id;
        private $ISBN;
        private $BookTitle;
        private $BookAuthor;
        private $YearOfPublication;
        private $publisher;
        private $ImageUrlS;
        private $ImageUrlM;
        private $ImageUrlL;

        public function set_book($id, $conn) {
            $sql = "SELECT *  FROM books";
            $sql .= " WHERE id = $id ";
            $result = $conn->query($sql);
            if ($conn->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $this->id = $row['id'];
                    $this->ISBN = $row['ISBN'];
                    $this->BookTitle = $row['BookTitle'];
                    $this->BookAuthor = $row['BookAuthor'];
                    $this->YearOfPublication = $row['YearOfPublication'];
                    $this->publisher = $row['Publisher'];
                    $this->ImageUrlS = $row['ImageUrlS'];
                    $this->ImageUrlM = $row['ImageUrlM'];
                    $this->ImageUrlL = $row['ImageUrlL'];
                }
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        public function get_id() {
            return $this->id;
        }

        public function get_ISBN() {
            return $this->ISBN;
        }

        public function get_BookTitle() {
            return $this->BookTitle;
        }

        public function get_BookAuthor() {
            return $this->BookAuthor;
        }

        public function get_YearOfPublication() {
            return $this->YearOfPublication;
        }

        public function get_publisher() {
            return $this->publisher;
        }
        
        public function get_ImageUrlS() {
            return $this->ImageUrlS;
        }

        public function get_ImageUrlM() {
            return $this->ImageUrlM;
        }
        public function get_ImageUrlL() {
            return $this->ImageUrlL;
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

    }

?>
