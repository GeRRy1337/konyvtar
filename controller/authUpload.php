<?php 
    if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['birthDate'])){
        $author->upload_author($conn,$_POST['name'],$_POST['description'],$_POST['birthDate']);
    }
    include 'view/authUpload.php';
?>