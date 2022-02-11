<?php
    if(!empty($_POST['search'])){
        $_SESSION['indexPage']=1;
        $_SESSION['search']=$_POST['search'];
    }
    if(isset($_POST['switchPage'])){
        $_SESSION['indexPage']=$_POST['switchPage'];
    }elseif(isset($_POST['forward'])){
        if( $_SESSION['indexPage']<$BookVar->getMax($conn)){
            $_SESSION['indexPage']++;
        }
    }elseif(isset($_POST['backward'])){
        if($_SESSION['indexPage']>1){
            $_SESSION['indexPage']--;
        }
    }
    $bookIds=$BookVar->bookList($conn);
    include 'view/index.php';
?>