<?php
    if(!empty($_POST['search'])){
        $_SESSION['indexPage']=1;
        $_SESSION['search']=$_POST['search'];
        header("Location: index.php?page=index");
    }
    if(isset($_POST['switchPage'])){
        $_SESSION['indexPage']=$_POST['switchPage'];
        header("Location: index.php?page=index");
    }elseif(isset($_POST['forward'])){
        if( $_SESSION['indexPage']<$BookVar->getMax($conn)){
            $_SESSION['indexPage']++;
            header("Location: index.php?page=index");
        }
    }elseif(isset($_POST['backward'])){
        if($_SESSION['indexPage']>1){
            $_SESSION['indexPage']--;
            header("Location: index.php?page=index");
        }
    }
    $bookIds=$BookVar->bookList($conn);
    include 'view/index.php';
?>