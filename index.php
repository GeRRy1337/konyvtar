<?php 
    session_start();
    require 'includes/db.inc.php';

    $page = 'index';

    if(!empty($_SESSION["id"])) {
        $szoveg = $_SESSION["nev"].": Kilépés";
        $action = "kilepes";
    }
    else {
            $szoveg = "Belépés";
            $action = "belepes";        
    } 

    // router
    if(isset($_REQUEST['page'])) {
        if(file_exists('controller/'.$_REQUEST['page'].'.php')) {
                $page = $_REQUEST['page']; 
        }
    }

    $menu = array('index' => "Főoldal", 
                        'felhasznalo' => $szoveg
                        );

    $title = $menu[$page];
    include 'includes/header.inc.php';
?>

<body>
<?php
    include 'includes/menu.inc.php';
    include 'controller/'.$page.'.php';
?>
</body>
</html>