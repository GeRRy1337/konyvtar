<?php 
    $browser = get_browser(null, true);
    if ($browser["browser_name_pattern"]!="*java*") header('location:/konyvtar/index.php?page=index&search=false');
    if(isset($_REQUEST['key']) and $_REQUEST['key']=="313303ef7840acb49ba489ddb9247be4969e8a650f28eda39756556868d9c1ea"){
        require (realpath($_SERVER["DOCUMENT_ROOT"]).'/konyvtar/Includes/db.inc.php');
        if($_REQUEST['action']=="Select"){
            $condition="";
            if(isset($_REQUEST["from"])){
                if(isset($_REQUEST["id"])) $condition.="id=".$_REQUEST["id"]." and ";
                if(isset($_REQUEST["stockNum"])) $condition.="stockNum=".$_REQUEST["stockNum"]." and ";
                if(isset($_REQUEST["state"])) $condition.="state=".$_REQUEST["state"]." and ";
                if(isset($_REQUEST["ISBN"])) $condition.="ISBN=".$_REQUEST["ISBN"]." and ";
                if(isset($_REQUEST["name"])) $condition.="name=".$_REQUEST["name"]." and ";
                $condition=substr($condition,0,strlen($condition)-4);
                $sql="Select * from ".$_REQUEST["from"].(strlen($condition)>0?" Where ".$condition : "" );
                $result = $conn->query($sql);
                if ($result->num_rows>0){
                    if($row = $result->fetch_assoc()) {
                        echo "response:True\n";
                        foreach($row as $key =>$param){
                            echo $key.":".$param."\n";
                        }
                    }
                }else{
                    echo 'response:False';
                }
            }else{
                if (isset($_REQUEST['username']) and isset($_REQUEST['password']) ) {
                    $result = $conn->query("Select users.id from users inner join admins on users.id=admins.id where username='".$_REQUEST['username']."' and password='".$_REQUEST['password']."'");
                    if ($result->num_rows>0){
                        if($row = $result->fetch_assoc()) {
                            echo "response:True\n";
                            echo "id:".$row['id'];
                        }
                    }else{
                        echo 'response:False';
                    }
                }
            }
        }elseif($_REQUEST['action']=="Insert"){
            $sql = "INSERT INTO ".$_REQUEST['to']." ".$_REQUEST['values'];
            if($result = $conn->query($sql)) {
                echo "response:True";
            }else{
                echo 'response:False';
            }
        }elseif($_REQUEST['action']=="Update"){
            $condition="";
            if(isset($_REQUEST["stockNum"])) $condition.="stockNum=".$_REQUEST["stockNum"]." and ";
            if(isset($_REQUEST["state"])) $condition.="state=".$_REQUEST["state"]." and ";
            $condition=substr($condition,0,strlen($condition)-4);
            $sql = "Update ".$_REQUEST['to']." Set ".str_replace(":","=",$_REQUEST['set']).(strlen($condition)>0?" Where ".$condition : "" ) ;
            if($result = $conn->query($sql)) {
                echo "response:True";
            }else{
                echo 'response:False';
            }
        }elseif($_REQUEST['action']=="Delete"){

        }else{
            echo 'Error: Unknow action!';
        }
        return;
    }else{
        echo "You don't have privileges to view this page!";
    }

?>