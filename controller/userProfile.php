<?php
    if(!isset($_SESSION['id'])) header('Location:index.php?page=index');
    include 'view/userProfile.php';
?>