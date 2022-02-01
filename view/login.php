<div class="container">
<?php
    if(isset( $_SESSION['register']) and $_SESSION['register']==true){
        if(isset($_POST['user']) and isset($_POST['pw'])){
            echo $loginError;
        }
        else echo "<h2>Regisztrácio</h2>";

        ?>
        <form action="index.php?page=userControl&register=true" id="regForm" method="post">
            Felhasználónév:<br><input type="text" name="user" required>
            <br>
            Jelszó: <br><input type="password" name="pw" id="pw" required>
            <br>
            Jelszó: <br><input type="password" name="pw2" id="pw2" required>
            <br>
            Email:<br><input type="text" id="regEmail" name="email" required>
            <br>
            <p id="error"></p>
            <a href="index.php?page=userControl">Bejelentkezés</a>
            <br>
        <input type="submit" >
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
<script>
    document.getElementById('pw2').oninput=function(){
        if( document.getElementById('pw').value != document.getElementById('pw2').value ){
            document.getElementById('error').innerHTML="A jelszók nem egyeznek!";
        }else{
            document.getElementById('error').innerHTML="";
        }
    }
    document.getElementById('pw').oninput=function(){
        if( document.getElementById('pw').value != document.getElementById('pw2').value ){
            document.getElementById('error').innerHTML="A jelszók nem egyeznek!";
        }else{
            document.getElementById('error').innerHTML="";
        }
    }
    document.getElementById('regEmail').oninput=function(){
        if( document.getElementById('regEmail').value.includes("@") ){
            if(document.getElementById('regEmail').value.split("@")[1].split(".")[0].length>0){
                if(document.getElementById('regEmail').value.split("@")[1].includes(".")){
                    if(document.getElementById('regEmail').value.split("@")[1].split(".")[1].length>0){
                        document.getElementById('error').innerHTML="";
                    }else{
                        document.getElementById('error').innerHTML="Hibás email!";
                    }
                }else{
                    document.getElementById('error').innerHTML="Hibás email!";
                }
            }else{
                document.getElementById('error').innerHTML="Hibás email!";
            }
        }else{
            document.getElementById('error').innerHTML="Hibás email!";
        }
    }
    document.getElementById('regForm').onsubmit = function() {
        if( document.getElementById('pw').value != document.getElementById('pw2').value ){
            return false;
        }
        if( document.getElementById('regEmail').value.includes("@") ){
            if(document.getElementById('regEmail').value.split("@")[1].split(".")[0].length>0){
                if(document.getElementById('regEmail').value.split("@")[1].includes(".")){
                    if(document.getElementById('regEmail').value.split("@")[1].split(".")[1].length<1){
                        return false;
                    }
                }else{
                    return false;
                }
            } else {
                return false;
            }
        }else{
            return false;
        }

        return true;
    }
    
</script>