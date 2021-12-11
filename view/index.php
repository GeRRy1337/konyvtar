<div class="bookTable">   
        <?php
        if(!isset($_SESSION['indexPage'])){
            $_SESSION['indexPage']=1;
        }
        if(!isset($_SESSION['search'])){
            $_SESSION['search']='';
        }
        $indexPage=$_SESSION['indexPage'];
        $index=1;
        $searchInd=1;
        echo $indexPage;
        $search=$_SESSION['search'];
        echo 'Search='.$search;
        
        if ($bookIds) {
            foreach($bookIds as $bookId) {
                $BookVar->set_book($bookId,$conn);
                if($search!=''){
                    if((strpos(mb_strtolower($BookVar->get_BookTitle()),mb_strtolower($search))>-1)||(strpos(mb_strtolower($BookVar->get_BookAuthor()),mb_strtolower($search))>-1)){
                        if($index>($indexPage-1)*40&&$index<$indexPage*40){
                            echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src='.$BookVar->get_ImageUrlL().'></a><br>'. $BookVar->get_BookTitle() .'</span>';
                        }
                        $searchInd++;
                    }
                }else{
                    if($index>($indexPage-1)*40&&$index<$indexPage*40){
                        echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src='.$BookVar->get_ImageUrlL().'></a><br>'. $BookVar->get_BookTitle() .'</span>';
                    }
                }
                $index++;
            }
        }
        else {
            echo "0 results";
        }
        $conn->close();

        ?>
</div>