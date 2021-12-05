<?php
    if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['release']) ){
        $selectedBook->upload_book($conn,$_POST['name'],$_POST['description'],$_POST['release'],$_POST['iro']);
        $lastBook=$selectedBook->get_lastId($conn);
        $target_dir = "bookCovers/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
        $target_file = $target_dir . basename($lastBook.'.png');
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            } else {
            }
        }

    }
    include 'view/upload.php';
?>