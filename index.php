<?php 
    session_name('konyvtar');
    session_start();
    require 'Includes/db.inc.php';
    require 'model/user.php';
    $user= new User();

    require 'model/book.php';
    $BookVar= new Book();

    require 'model/author.php';
    $author= new Author();

    $authorList=$author->authorList($conn);

    $langArr=array();
    if(!isset($_COOKIE['lang'])){
        setcookie( 'lang', "hu", time() + 60*60*24*30 );
    }

    if($_COOKIE['lang']=="hu"){
        $file=file_get_contents("localization/hu.json");
        $langArr=json_decode($file,true);
    }else{
        $file=file_get_contents("localization/en.json");
        $langArr=json_decode($file,true);
    }
    

    $page = 'index';

    if(!empty($_REQUEST['action'])) {
        if($_REQUEST['action'] == 'logout') session_unset();
    }

    if(!empty($_SESSION["id"])) {
        $szoveg = "<span class='bi bi-box-arrow-left'></span> ".$langArr['logout'].": ".$_SESSION["username"];
        $action = "logout";
    }
    else {
            $szoveg = "<span class='bi bi-box-arrow-right'></span> ".$langArr['login'];
            $action = "belepes";        
    } 

    // router
    if(isset($_REQUEST['page'])) {
        if(file_exists('controller/'.$_REQUEST['page'].'.php')) {
                $page = $_REQUEST['page'];
        }
    }else{
        if(isset($_REQUEST['category'])){
            if(isset($_SESSION["categories"])){
                $_SESSION["categories"][]=$_REQUEST['category'];
            }else{
                $_SESSION["categories"]=array();
                $_SESSION["categories"][]=$_REQUEST['category'];
            }
            header("location: index.php?page=index");
        }elseif(isset($_REQUEST['removeCat'])){
            if(isset($_SESSION["categories"])){
              foreach($_SESSION["categories"] as $index => $category)
                  if ($_SESSION["categories"][$index]==$_REQUEST['removeCat'])
                    unset($_SESSION["categories"][$index]);
            }
            header("location: index.php?page=index");
        }else{
            header("location: index.php?page=index&search=false");
        }
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
    if(isset($_REQUEST['resendEmail']) and $_REQUEST['resendEmail']==true) {
        $_SESSION['resendEmail']=true;
    }elseif(!isset($_REQUEST['resendEmail']) and isset( $_SESSION['resendEmail']) and $_SESSION['resendEmail']==true) {
        $_SESSION['resendEmail']=false;
    }
    $menu = array('index' => "<span class='bi bi-house-fill'></span> ".$langArr['home'],
                  'favorites' => "<span class='bi bi-star-fill'></span> ".$langArr['favorite'],
                  'userProfile' => "<span class='bi bi-person-badge'></span> ".$langArr['profile'],
                  'userControl' => $szoveg,
                );
    if(in_array($page,$menu)){
        $title = $menu[$page];
    }else $title=$page;

    include 'Includes/header.inc.php';
    ?>
<body>
<?php
        include 'controller/'.$page.'.php';
		include 'Includes/menu.inc.php';
?>

</body>
</html>
<?php 
  $conn->close();
?>
