<?php
    if(!empty($_GET['authorId'])){
        $author->set_author($_GET['authorId'],$conn);
        $bookList=$author->writtenBooks($conn,$_GET['authorId']);
        include 'view/authorInfo.php';
    }else{
        header('Location:index.php?page=index');
    }
?>