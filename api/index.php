<?php 
    $browser = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($browser,"Java")==false) header('location:../index.php?page=index&search=false');
    if(isset($_REQUEST['key']) and $_REQUEST['key']=="313303ef7840acb49ba489ddb9247be4969e8a650f28eda39756556868d9c1ea"){
        require (realpath($_SERVER["DOCUMENT_ROOT"]).'/gergo/szakdolgozat/Includes/db.inc.php');
        if(isset($_REQUEST['action'])){
            if($_REQUEST['action']=="Select"){
                $condition="";
                if(isset($_REQUEST["from"])){
                    if(isset($_REQUEST["id"])) $condition.="id=".$_REQUEST["id"]." and ";
                    if(isset($_REQUEST["stockNum"])) $condition.="stockNum=".$_REQUEST["stockNum"]." and ";
                    if(isset($_REQUEST["state"])) $condition.="state=".$_REQUEST["state"]." and ";
                    if(isset($_REQUEST["ISBN"])) $condition.="ISBN=".$_REQUEST["ISBN"]." and ";
                    if(isset($_REQUEST["name"])) $condition.="name='".$_REQUEST["name"]."' and ";
                    if(isset($_REQUEST["userId"])) $condition.="userId=".$_REQUEST["userId"]." and ";
                    if(isset($_REQUEST["username"])) $condition.="username=".$_REQUEST["username"]." and ";
                    $condition=substr($condition,0,strlen($condition)-4);
                    $sql="Select * from ".$_REQUEST["from"].(strlen($condition)>0?" Where ".$condition : "" );
                    echo "sql:".$sql."\n";
                    $result = $conn->query($sql);
                    if ($result->num_rows>0){
                        if($row = $result->fetch_assoc()) {
                            echo "response:True\n";
                            foreach($row as $key =>$param){
                                echo $key.":".$param."\n";
                            }
                        }
                    }else{
                        echo "response:False\n";
                    }
                }else{
                    if (isset($_REQUEST['username']) and isset($_REQUEST['password']) ) {
                        $result = $conn->query("Select users.id, admins.permission from users inner join admins on users.id=admins.id where username='".$_REQUEST['username']."' and password='".$_REQUEST['password']."'");
                        if ($result->num_rows>0){
                            if($row = $result->fetch_assoc()) {
                                echo "response:True\n";
                                echo "id:".$row['id']."\n";
                                echo "permission:".$row['permission']."\n";
                            }
                        }else{
                            $result = $conn->query("Select id from users where username='".$_REQUEST['username']."' and password='".$_REQUEST['password']."'");
                            if ($result->num_rows>0){
                                echo "user:exists\n";
                            }
                            echo "response:False\n";
                        }
                    }
                }
            }elseif($_REQUEST['action']=="Insert"){
                if (isset($_REQUEST['img'])){
                    $path=explode("\\",$_REQUEST['img']);
                    $sql = "INSERT INTO ".$_REQUEST['to']." ".str_replace("blank","'images/covers/".$path[count($path)-1]."'",$_REQUEST['values']);
                    if($result = $conn->query($sql)) {
                        echo "response:True\n";
                    }else{
                        echo "response:False\n";
                    }
                }else{
                    $sql = "INSERT INTO ".$_REQUEST['to']." ".$_REQUEST['values'];
                    if($result = $conn->query($sql)) {
                        echo "response:True\n";
                        if($_REQUEST['to'] == "cards(birth,addres,phoneNumber,name)"){
                            $sql = "Select id From cards Order by id desc limit 1";
                            $result=$conn->query($sql);
                            echo "id:".$result->fetch_assoc()['id']."\n";
                        }
                    }else{
                        echo "response:False\n";
                    }
                }
            }elseif($_REQUEST['action']=="Update"){
                $condition="";
                if(isset($_REQUEST["stockNum"])) $condition.="stockNum=".$_REQUEST["stockNum"]." and ";
                if(isset($_REQUEST["state"])) $condition.="state=".$_REQUEST["state"]." and ";
                if(isset($_REQUEST["userId"])) $condition.="userId=".$_REQUEST["userId"]." and ";
                $condition=substr($condition,0,strlen($condition)-4);
                $sql = "Update ".$_REQUEST['to']." Set ".str_replace(":","=",$_REQUEST['set']).(strlen($condition)>0?" Where ".$condition : "" ) ;
                if($result = $conn->query($sql)) {
                    echo "response:True\n";
                }else{
                    echo "response:False\n";
                }
            }elseif($_REQUEST['action']=="Delete"){
            }else{
                echo 'Error: Unknow action!';
            }
            return;
        }else{
            if(isset($_FILES['uploaded_file'])){
                var_dump($_FILES['uploaded_file']);
                $target_path = "../images/covers/"; 
                $target_path = $target_path . basename( $_FILES['uploaded_file']['name']); 

                if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path)) { 
                    echo "response:True\n";
                } else{ 
                    echo "response:False\n";
                }
            }
            return;
        }
    }else{
        echo "You don't have privileges to view this page!";
    }

?>