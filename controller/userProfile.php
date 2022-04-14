<?php
    if(!isset($_SESSION['id'])) header('Location:index.php?page=index');
    $loginError="";
    $emError="";
    //jelszó váltása
    if(isset($_POST['oldPw']) and isset($_POST['pw']) and isset($_POST['pw2'])){
        if(strlen($_POST['oldPw']) == 0) $loginError .= $langArr['emptyPass']."<br>";
        if(strlen($_POST['pw']) == 0) $loginError .= $langArr['emptyPass']."<br>";
		if(strlen($_POST['pw2']) == 0) $loginError .= $langArr['emptyPass']."<br>";
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
    //email cím váltás
    if(isset($_POST['oldPw']) and isset($_POST['email']) and isset($_POST['email2'])){
        if(strlen($_POST['oldPw']) == 0) $emError .= $langArr['emptyPass']."<br>";
        if(strlen($_POST['email']) == 0) $emError .= "Nem adtál meg emailt<br>";
        if(strlen($_POST['email2']) == 0) $emError .= "Nem adtál meg emailt<br>";
        if($_POST['email']!=$_POST['email2']) $emError.="Email címek nem egyeznek!<br>";
        //foglalt e az új eamil amire váltaná?
        $sql = "SELECT id FROM users WHERE email = ? ";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $pw);
            $pw = $_POST['email'];
            $stmt->execute();
            if(!$result = $stmt->get_result()) echo "SQL Error";
            if ($result->num_rows > 0) {
                $emError .= $langArr['emailInUse']."<br>";
            }else{
                if($emError == '') {
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
                                        //megerősítő email küldése az új email címre
                                        $emkey = hash("sha256",$row['username'].":".$_POST['email']);
                                        $to      = $em;
                                        $subject = $langArr["emailSubject"];
                                        $message = $langArr["emailConfrim"].'<a href="'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?page=userControl&emailConf='.$emkey.'">Link</a>';
                                        $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                        $headers .= 'From: noreply@konyvtar.com' . "\r\n" ;
                                        mail($to, $subject, $message, $headers);
                                        header("Location:index.php?page=userControl&action=logout");
                                    }
                                    $stmt->close();
                                }
                            }
                        }else{
                            $emError=$langArr['emailError'];
                        }
                    }
                }
            }
        }
    }
    include 'view/userProfile.php';
?>