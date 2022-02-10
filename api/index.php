<?php 
    $browser = get_browser(null, true);
    if ($browser["browser_name_pattern"]!="*java*") header('location:/konyvtar/index.php?page=index&search=false');
    if(isset($_REQUEST['key']) and $_REQUEST['key']=="313303ef7840acb49ba489ddb9247be4969e8a650f28eda39756556868d9c1ea"){
        require (realpath($_SERVER["DOCUMENT_ROOT"]).'/konyvtar/Includes/db.inc.php');
        if($_REQUEST['action']=="Select"){
            if (isset($_REQUEST['username']) and isset($_REQUEST['password']) ) {
                $result = $conn->query("Select users.id from users inner join admins on users.id=admins.id where username='".$_REQUEST['username']."' and password='".$_REQUEST['password']."'");
                if ($result->num_rows>0){
                    if($row = $result->fetch_assoc()) {
                        echo "True\n";
                        echo $row['id'];
                    }
                }else{
                    echo 'False';
                }
            }
        }elseif($_REQUEST['action']=="Update"){

        }elseif($_REQUEST['action']=="Delete"){

        }else{
            echo 'Error: Unknow action!';
        }
        return;
    }

?>