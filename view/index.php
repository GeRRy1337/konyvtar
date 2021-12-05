<div class="bookTable">   
        <?php
        if ($bookIds) {
            foreach($bookIds as $bookId) {
                if(! $selectedBook){
                    echo '<span class="bookItem">'. $bookId .'</span>';
                }
                else{
                    $selectedBook->set_book($bookId,$conn);
                    if($search!=''){
                        if(strpos(mb_strtolower($selectedBook->get_name()),mb_strtolower($search))>-1)
                            echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src=bookCovers/'.$bookId.'.png></a><br>'. $selectedBook->get_name() .'</span>';
                    }else echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src=bookCovers/'.$bookId.'.png></a><br>'. $selectedBook->get_name() .'</span>';
                }
                
            }
        }
        else {
            echo "0 results";
        }
        $conn->close();

        ?>
</div>