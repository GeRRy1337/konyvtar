<?php 
    session_start();
    require 'Includes/db.inc.php';

    $page = 'index';

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
    include 'Includes/header.inc.php';
?>

<body>
<?php
    include 'Includes/menu.inc.php';
    include 'controller/'.$page.'.php';
?>
</body>
</html>