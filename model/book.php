<?php

    class Book{
        //Id,ISBN,BookTitle,BookAuthor,YearOfPublication,Publisher,ImageUrlS,ImageUrlM,ImageUrlL
        private $id;
        private $ISBN;
        private $BookTitle;
        private $BookAuthor;
        private $YearOfPublication;
        private $publisher;
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
                    $this->BookAuthor = $conn->query("SELECT name FROM author where id=".$row['AuthorId'])->fetch_assoc()['name'];
                    $this->YearOfPublication = $row['YearOfPublication'];
                    $this->publisher = $row['Publisher'];
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
        
        public function get_ImageUrlL() {
            return $this->ImageUrlL;
        }

        public function inStock($conn){
            $sql = "SELECT count(stockNum) as inStock from stock where bookId=".$this->get_id();
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['inStock'];   
                }
            }
            return 0;
        }

        public function isFav($conn,$userId){
            $sql = "SELECT bId from favourite where bId=".$this->get_id()." and uId=".$userId;
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    return true;
                }
            }
            return false;
        }

        public function setFav($conn,$userId){
            $sql = "INSERT INTO favourite(bId,uId) VALUES( ".$this->get_id()." , ".$userId." ) ";
            if($result = $conn->query($sql)) {
                return true;
            }else {
                echo $conn->error;
                return false;
            }
            
        }

        public function delFav($conn,$userId){
            $sql = "DELETE FROM favourite WHERE bId=".$this->get_id()." and uId=".$userId;
            if($result = $conn->query($sql)) {
                return true;
            }else {
                return false;
            }
        }

        public function favList($conn,$userId) {
            $list = array();
            $sql = "SELECT bId FROM favourite  where uId=".$userId;
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['bId'];
                    }
                }
            }
            return $list;
        }

        public function bookList($conn) {
            if(!isset($_SESSION['indexPage'])) $_SESSION['indexPage']=1;
            if(!isset($_SESSION['search'])) $_SESSION['search']='';
            $search=$_SESSION['search'] or '';
            $list = array();
            $sql = "SELECT books.id FROM books inner join author on AuthorId=author.id where BookTitle like('%".$search."%') or author.name like ('%".$search."%') limit ".(($_SESSION['indexPage']-1)*40).",40";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }
        public function getMax($conn) {
            if(!isset($_SESSION['search'])) $_SESSION['search']='';
            $search=$_SESSION['search'] or '';
            $sql = "SELECT count(books.id) as maxNum FROM books inner join author on AuthorId=author.id where BookTitle like('%".$search."%') or author.name like ('%".$search."%') ";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        return $row['maxNum']/40+1;
                    }
                }
            }
            return false;
        }

        public function borrowedList($conn) {
            $list = array();
            $sql = "SELECT stockNum,date FROM borrow where stockNum in (Select stockNum from stock where bookId=".$this->get_id().") and state=0";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = array($row['stockNum'],$row['date']);
                    }
                }
            }
            return $list;
        }

    }

?>
