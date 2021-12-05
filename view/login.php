<?php
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
        <input type="submit">
        </form>
        <?php						
    }
?>