<?php
    //keresés
    if(!empty($_POST['search'])){
        $_SESSION['indexPage']=1;
        $_SESSION['search']=$_POST['search'];
        header("Location: index.php?page=index");
        exit();
    }
    //oldalváltás nyilakkal és számokkal
    if(isset($_POST['switchPage'])){
        $_SESSION['indexPage']=$_POST['switchPage'];
        header("Location: index.php?page=index");
        exit();
    }elseif(isset($_POST['forward'])){
        if( $_SESSION['indexPage']<Book::getMax($conn)){
            $_SESSION['indexPage']++;
            header("Location: index.php?page=index");
            exit();
        }
    }elseif(isset($_POST['backward'])){
        if($_SESSION['indexPage']>1){
            $_SESSION['indexPage']--;
            header("Location: index.php?page=index");
            exit();
        }
    }
    $bookIds=Book::bookList($conn);
    include 'view/index.php';
?>