<?php
    if(!isset($_SESSION['id'])) header('Location:index.php?page=index');
    $loginError="";
    if(isset($_POST['oldPw']) and isset($_POST['pw']) and isset($_POST['pw2'])){
        if($_POST['pw2']!=$_POST['pw']) $loginError.=$langArr["passwordMatch"]."<br>";
        $sql = "SELECT id FROM users WHERE password = ? ";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $pw);
            $pw = md5($_POST['pw']);
            $stmt->execute();
            if(!$result = $stmt->get_result()) echo "SQL Error";
            if ($result->num_rows > 0) {
                $loginError .= $langArr['passError']."<br>";
            }else{
                if($loginError == '') {
                    $sql = "UPDATE users SET users.password=? WHERE id=?";
                    if($stmt = $conn->prepare($sql)){
                        $stmt->bind_param("si", $pw,$id);
                        $pw = md5($_POST['pw']);
                        $id= $_SESSION['id'];
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        }
    }
    include 'view/userProfile.php';
?>