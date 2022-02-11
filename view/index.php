<div class="bookTable">   
        <?php
        if(!isset($_SESSION['indexPage'])){
            $_SESSION['indexPage']=1;
        }
        echo $BookVar->getMax($conn);
        if ($bookIds) {
            foreach($bookIds as $bookId) {
                $BookVar->set_book($bookId,$conn);
                echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src='.$BookVar->get_ImageUrlL().'></a><br>'. $BookVar->get_BookTitle() .' ('.$BookVar->get_YearOfPublication().')' .'</span>';
            }
        }
        else {
            echo "Nincs találat!";
        }

        ?>
</div>