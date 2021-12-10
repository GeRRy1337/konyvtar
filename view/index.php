<div class="bookTable">   
        <?php
        if ($bookIds) {
            foreach($bookIds as $bookId) {
                if(! $BookVar){
                    echo '<span class="bookItem">'. $bookId .'</span>';
                }
                else{
                    $BookVar->set_book($bookId,$conn);
                    if($search!=''){
                        if((strpos(mb_strtolower($BookVar->get_BookTitle()),mb_strtolower($search))>-1)||(strpos(mb_strtolower($BookVar->get_BookAuthor()),mb_strtolower($search))>-1))
                            echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src='.$BookVar->get_ImageUrlL().'></a><br>'. $BookVar->get_BookTitle() .'</span>';
                    }else echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src='.$BookVar->get_ImageUrlL().'></a><br>'. $BookVar->get_BookTitle() .'</span>';
                }
                
            }
        }
        else {
            echo "0 results";
        }
        $conn->close();

        ?>
</div>