<?php

    class Book{
        //Id,ISBN,BookTitle,BookAuthor,YearOfPublication,Publisher,ImageUrlS,ImageUrlM,ImageUrlL
        private $id;
        private $ISBN;
        private $BookTitle;
        private $BookAuthor;
        private $AuthorId;
        private $YearOfPublication;
        private $publisher;
        private $ImageUrlL;

        //Könyv beállítása id alapján
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
                    $this->AuthorId = $row['AuthorId'];
                    $this->YearOfPublication = $row['YearOfPublication'];
                    $this->publisher = $row['Publisher'];
                    $this->ImageUrlL = $row['ImageUrlL'];
                }
            }
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        //getterek
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

        public function get_AuthorId() {
            return $this->AuthorId;
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

        //az adott könyv könyvtárban megtalálható példányainak listája
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

        /**
         * A felhasználó kedvencek közé tette e az adott könyvet
         * @param userId felhasználó azonosítója
         * @return boolean kedvencek között van e?
         */
        public function isFav($conn,$userId){
            $sql = "SELECT bId from favourite where bId=".$this->get_id()." and uId=".$userId;
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    return true;
                }
            }
            return false;
        }

        /**
         * A könyv kedvencek közé tétele
         * @param userId felhasználó azonosítója
         * @return boolean sikerült e kedvencek közé tenni a könyvet
         */
        public function setFav($conn,$userId){
            $sql = "INSERT INTO favourite(bId,uId) VALUES( ".$this->get_id()." , ".$userId." ) ";
            if($result = $conn->query($sql)) {
                return true;
            }else {
                return false;
            }
            
        }

        /**
         * A könyv törlése a kedvencek közül
         * @param userId felhasználó azonosítója
         * @return boolean sikerült e törölni a kedvencek közűl a könyvet
         */
        public function delFav($conn,$userId){
            $sql = "DELETE FROM favourite WHERE bId=".$this->get_id()." and uId=".$userId;
            if($result = $conn->query($sql)) {
                return true;
            }else {
                return false;
            }
        }

        /**
         * A könyv törlése a kedvencek közül
         * @param userId felhasználó azonosítója
         * @return int[] kedvencek listája, int tömbben
         */
        public static function favList($conn,$userId) {
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

        /**
         * Könyvek listája
         * - $_SESSION['search'] : keresőmezőbe beírt keresés, könyv cím vagy könyv írója
         * - $_SESSION['categories'] : kategória keresés
         * @return int[] a könyv id-k listája
         */
        public static function bookList($conn) {
            if(!isset($_SESSION['indexPage'])) $_SESSION['indexPage']=1;
            if(!isset($_SESSION['search'])) $_SESSION['search']='';
            // kategória keresés, a keressett kategóriák $_SESSION['categories'] ban, tömbként vannak tárolva
            $categories="";
            if(isset($_SESSION['categories']) and count($_SESSION['categories'])>0){
                $categories="and books.id in(select bookId from categoryconn where categoryId in (";
                foreach($_SESSION['categories'] as $category){
                    $categories.=intval($category).",";
                }
                //az utolsó ',' eltávolítása a stringből
                $categories=substr($categories,0,strlen($categories)-1);

                //csak akkor vállaszuk ki a könyvet ha mindegyik keresett kategóriában megtalálható
                $categories.=" ) GROUP by bookId HAVING COUNT(bookId)> ".(count($_SESSION['categories'])-1).")";
                
            }
            $search=mysqli_real_escape_string($conn, $_SESSION['search']) or '';
            $list = array();
            $sql = "SELECT books.id FROM books inner join author on AuthorId=author.id where (BookTitle like('%".$search."%') or author.name like ('%".$search."%'))".$categories." limit ".(($_SESSION['indexPage']-1)*40).",40";
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $list[] = $row['id'];
                    }
                }
            }
            return $list;
        }
        /**
         * A kategória és keresőmező értékek alpaján meghatárózza az oldalak számát
         * @return int az oldalak száma
         */
        public static function getMax($conn) {
            if(!isset($_SESSION['search'])) $_SESSION['search']='';
            $categories="";
            if(isset($_SESSION['categories']) and count($_SESSION['categories'])>0){
                $categories="and books.id in(select bookId from categoryconn where categoryId in (";
                foreach($_SESSION['categories'] as $category){
                    $categories.=intval($category).",";
                }
                $categories=substr($categories,0,strlen($categories)-1);
                $categories.=" ) GROUP by bookId HAVING COUNT(bookId)> ".(count($_SESSION['categories'])-1).")";
            }

            $search=mysqli_real_escape_string($conn, $_SESSION['search']) or '';
            $sql = $sql = "SELECT count(books.id) as maxNum FROM books inner join author on AuthorId=author.id where (BookTitle like('%".$search."%') or author.name like ('%".$search."%')) ".$categories;
            if($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        return floor($row['maxNum']/40)+1;
                    }
                }
            }
            return false;
        }

        //az adott könyv kikölcsönzött példányainak id-je
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