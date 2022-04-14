<div class="row justify-content-center">
    <?php
    if ($favBooks) {
        foreach ($favBooks as $bookId) {
            $BookVar->set_book($bookId, $conn);
            echo ' <span class="bookItem"><a href="index.php?page=bookInfo&bookId=' . $bookId . '"><img src=' . $BookVar->get_ImageUrlL() . ' alt="'.$BookVar->get_BookTitle().'"></a><br>' . $BookVar->get_BookTitle() . ' (' . $BookVar->get_YearOfPublication() . ')' . '</span>';
        }
    } else {
        echo "Nincsenek kedvenc könyveid!";
    }
    ?>
</div>