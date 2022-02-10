<?php 
    $browser = get_browser(null, true);
    if ($browser["browser_name_pattern"]!="*java*") header('location:/konyvtar/index.php?page=index&search=false');
    if(isset($_REQUEST['key']) and $_REQUEST['key']=="313303ef7840acb49ba489ddb9247be4969e8a650f28eda39756556868d9c1ea"){
        if($_REQUEST['action']=="Select"){

        }elseif($_REQUEST['action']=="Update"){

        }elseif($_REQUEST['action']=="Delete"){

        }else{
            echo 'Error: Unknow action!'
        }
        return;
    }

?>