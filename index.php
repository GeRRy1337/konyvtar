<?php 
    session_start();
    require 'Includes/db.inc.php';
    require 'model/user.php';
    $user= new User();

    require 'model/book.php';
    $BookVar= new Book();

    require 'model/author.php';
    $author= new Author();

    $authorList=$author->authorList($conn);

    require 'model/admin.php';
    $admin = new Admin();

    $adminList = $admin->lista($conn);

    $page = 'index';

    if(!empty($_REQUEST['action'])) {
        if($_REQUEST['action'] == 'logout') session_unset();
    }

    if(!empty($_SESSION["id"])) {
        $szoveg = "<span class='bi bi-box-arrow-left'></span> Kilépés: ".$_SESSION["username"];
        $action = "logout";
    }
    else {
            $szoveg = "<span class='bi bi-box-arrow-right'></span> Belépés";
            $action = "belepes";        
    } 

    // router
    if(isset($_REQUEST['page'])) {
        if(file_exists('controller/'.$_REQUEST['page'].'.php')) {
                $page = $_REQUEST['page'];
        }
    }else{
        header("location: index.php?page=index&search=false");
    }

    if(isset($_REQUEST['search'])) {
        $_SESSION['search']='';
        $_SESSION['indexPage']=1;
    }

    if(isset($_REQUEST['register']) and $_REQUEST['register']==true) {
        $_SESSION['register']=true;
    }elseif(!isset($_REQUEST['register']) and isset( $_SESSION['register']) and $_SESSION['register']==true) {
        $_SESSION['register']=false;
    }
    
    $menu = array('index' => "<span class='bi bi-house-fill'></span> Főoldal",
                  'favorites' => "<span class='bi bi-star-fill'></span> Kedvencek",
                  'userProfile' => "<span class='bi bi-person-badge'></span> Felhasználói profil",
                  'userControl' => $szoveg,
                );
    if(in_array($page,$menu)){
        $title = $menu[$page];
    }else $title=$page;

    include 'Includes/header.inc.php';
    ?>
<body>
<?php
        include 'Includes/menu.inc.php';
        include 'controller/'.$page.'.php';
?>
</body>
</html>
<?php 
  $conn->close();
?>