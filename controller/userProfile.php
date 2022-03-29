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
    if(isset($_POST['oldPw']) and isset($_POST['email']) and isset($_POST['email2'])){
        if($_POST['email']!=$_POST['email2']) $loginError.="Email címek nem egyeznek!<br>";
        $sql = "SELECT id FROM users WHERE email = ? ";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $pw);
            $pw = $_POST['email'];
            $stmt->execute();
            if(!$result = $stmt->get_result()) echo "SQL Error";
            if ($result->num_rows > 0) {
                $loginError .= $langArr['emailInUse']."<br>";
            }else{
                if($loginError == '') {
                    $sql = "SELECT id,username FROM users WHERE id = ? ";
                    if($stmt = $conn->prepare($sql)){
                        $stmt->bind_param("i", $i);
                        $i = $_SESSION['id'];
                        $stmt->execute();
                        if(!$result = $stmt->get_result()) echo "SQL Error";
                        if ($result->num_rows > 0) {
                            if($row=$result->fetch_assoc()){
                                $sql = "UPDATE users SET users.email=?, email_confirm=0, email_key=? WHERE id=?";
                                if($stmt = $conn->prepare($sql)){
                                    $stmt->bind_param("ssi", $em,$emkey,$id);
                                    $em = $_POST['email'];
                                    $emkey = hash("sha256",$row['username'].":".$_POST['email']);
                                    $id= $_SESSION['id'];
                                    if($stmt->execute()){
                                        $emkey = hash("sha256",$row['username'].":".$_POST['email']);
                                        $to      = $em;
                                        $subject = $langArr["emailSubject"];
                                        $message = $langArr["emailConfrim"].'<a href="'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?page=userControl&emailConf='.$emkey.'">Link</a>';
                                        $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                        $headers .= 'From: noreply@konyvtar.com' . "\r\n" ;
                                        mail($to, $subject, $message, $headers);
                                        header("Location:index.php?page=userControl&action=logout")
                                    }
                                    $stmt->close();
                                }
                            }
                        }else{
                            $loginError=$langArr['emailError'];
                        }
                    }
                }
            }
        }
    }
    include 'view/userProfile.php';
?>