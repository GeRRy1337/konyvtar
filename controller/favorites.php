<?php
    if(!isset($_SESSION['id'])) header('Location:index.php?page=index');
    $favBooks=$BookVar->favList($conn,$_SESSION['id']);
    include 'view/favorites.php';
?>