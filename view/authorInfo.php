<div class="container bg-light">
    <div class="row">
        <div class="bookContainer">
            <p><?php echo $langArr['wrote'].': '.$author->get_name()?></p>
            <p><?php echo $langArr['birth'].': '.$author->get_birth(); ?></p>
            <hr>
            <p><?php echo $langArr['desc'].': '.$author->get_description(); ?></p>
            <hr>
            <p><?php echo $langArr['authBooks'].': '?></p>
        </div>
    </div>
</div>
<div class="bookTable">
        <?php
        if ($bookList) {
            foreach($bookList as $bookId) {
                $BookVar->set_book($bookId,$conn);
                echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId='.$bookId.'"><img src="'.$BookVar->get_ImageUrlL().'"></a><br>'. $BookVar->get_BookTitle() .' ('.$BookVar->get_YearOfPublication().')' .'</span>';
            }
        }
        else {
            echo "Nincs találat!";
        }

        ?>
</div>