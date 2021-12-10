<?php 
    if(!empty($_GET['bookId'])){
        $BookVar->set_book($_GET['bookId'],$conn);
        $author->set_author(1,$conn);
        include 'view/bookInfo.php';
    }else{
        header('Location:index.php');
    }
?>