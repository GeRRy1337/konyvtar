<div class="container">
<?php
    if(isset( $_SESSION['register']) and $_SESSION['register']==true){
        if(isset($_POST['user']) and isset($_POST['pw'])){
            echo $loginError;
        }
        else echo "<h2>Regisztrácio</h2>";

        ?>
        <form action="index.php?page=userControl" method="post">
            Felhasználónév:<br><input type="text" name="user">
            <br>
            Jelszó: <br><input type="password" name="pw">
            <br>
            Jelszó: <br><input type="password" name="pw2">
            <br>
            Email:<br><input type="text" name="email">
            <br>
            <a href="index.php?page=userControl">Bejelentkezés</a>
            <br>
        <input type="submit">
        </form>
        <?php	
    }else{
        if(!empty($_SESSION["id"])) {
            ?>
            <form action="index.php?page=index" method="get">
                <input type="submit" name="action" value="Kilépés">
            </form>
            <?php
        }
        else {
            if(isset($_POST['user']) and isset($_POST['pw'])){
                echo $loginError;
            }
            else echo "<h2>Belépés</h2>";

            ?>
            <form action="index.php?page=userControl" method="post">
                Felhasználónév:<br><input type="text" name="user">
                <br>
                Jelszó: <br><input type="password" name="pw">
                <br>
                <a href="index.php?page=userControl&register=true">Nincs felhasználód? Regisztrálj!</a>
                <br>
            <input type="submit">
            </form>
            <?php						
        }
    }
?>
</div>