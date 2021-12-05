<?php 
    session_start();
    require 'includes/db.inc.php';
    require 'model/user.php';
    $user= new User();

    require 'model/book.php';
    $selectedBook= new Book();

    require 'model/author.php';
    $author= new Author();

    require 'model/Admin.php';
    $admin = new Admin();

    $adminList = $admin->lista($conn);

    $page = 'index';

    if(!empty($_REQUEST['action'])) {
        if($_REQUEST['action'] == 'Kilépés') session_unset();
    }

    if(!empty($_SESSION["id"])) {
        $szoveg = $_SESSION["username"].": Kilépés";
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
                  'upload' => "Könyv kezelés",
                  'userControl' => $szoveg,
                );
    if(in_array($page,$menu)){
        $title = $menu[$page];
    }else $title=$page;
    include 'includes/header.inc.php';
?>

<body>
<?php
    include 'includes/menu.inc.php';
    include 'controller/'.$page.'.php';
?>
</body>
</html>