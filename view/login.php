<?php
    if(!empty($_SESSION["id"])) {
        ?>
        <form action="belepes.php" method="get">
            <input type="submit" name="logout" value="Kilépés">
        </form>
        <?php
    }
    else {
        if(isset($_POST['user'])) {
            echo $loginError;
        }
        else echo "<h2>Belépés</h2>";
        ?>
        <form action="index.php?page=felhasznalo" method="post">
            Felhasználónév:<br><input type="text" name="user">
            <br>
            Jelszó: <br><input type="password" name="pw">
            <br>
        <input type="submit">
        </form>
        <?php						
    }
?>