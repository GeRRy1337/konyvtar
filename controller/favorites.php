<?php
    //ha nincs bejelentkezve nem lehetnek kedvencei ezért redirect
    if(!isset($_SESSION['id'])) header('Location:index.php?page=index');
    //kedvencek listája
    $favBooks=Book::favList($conn,$_SESSION['id']);
    include 'view/favorites.php';
?>