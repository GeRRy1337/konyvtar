<div class="bookTable">   
        <?php
        if(!isset($_SESSION['indexPage'])){
            $_SESSION['indexPage']=1;
        }
        if ($bookIds) {
            foreach($bookIds as $bookId) {
                $BookVar->set_book($bookId,$conn);
                echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src='.$BookVar->get_ImageUrlL().'></a><br>'. $BookVar->get_BookTitle() .'</span>';
            }
        }
        else {
            echo "0 results";
        }
        $conn->close();

        ?>
</div>