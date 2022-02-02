<?php
    $favBooks=$BookVar->favList($conn,$_SESSION['id']);

    include 'view/userProfile.php';
?>