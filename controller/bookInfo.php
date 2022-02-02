<?php
    if(!empty($_GET['bookId'])){
        $BookVar->set_book($_GET['bookId'],$conn);
        $author->set_author(1,$conn);
        if(isset($_POST['favButtonOn'])){
            $BookVar->delFav($conn,$_SESSION['id']);
            unset($_POST['favButtonOn']);
        }elseif(isset($_POST['favButtonOff'])){
            $BookVar->setFav($conn,$_SESSION['id']);
            unset($_POST['favButtonOff']);
        }
        include 'view/bookInfo.php';
    }else{
        header('Location:index.php?page=index');
    }
?>