<?php 
    if(!empty($_GET['bookId'])){
        $selectedBook->set_book($_GET['bookId'],$conn);
        include 'view/bookInfo.php';
    }else{
        header('Location:index.php');
    }
?>