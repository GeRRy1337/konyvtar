<?php
    $search='';
    $bookIds=$selectedBook->bookList($conn);
    if(!empty($_POST['search'])){
        $search=$_POST['search'];
    }
    include 'view/index.php';
?>