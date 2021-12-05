<?php
    require 'model/book.php';
    $selectedBook= new Book();
    $bookIds=$selectedBook->bookList($conn);

    include 'view/index.php';
?>