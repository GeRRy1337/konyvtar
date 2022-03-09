<div class="container">
<?php
    if(isset( $_SESSION['register']) and $_SESSION['register']==true){
        if(isset($_POST['user']) and isset($_POST['pw'])){
            echo $loginError;
        }
        else echo "<h2>".$langArr['register']."</h2>";
        ?>
        <form action="index.php?page=userControl&register=true" id="regForm" method="post">
            <?php echo $langArr['username'];?>:<br><input type="text" name="user" required>
            <br>
            <?php echo $langArr['password'];?>: <br><input type="password" name="pw" id="pw" required>
            <br>
            <?php echo $langArr['password'];?>: <br><input type="password" name="pw2" id="pw2" required>
            <br>
            <?php echo $langArr['email'];?>:<br><input type="email" id="regEmail" name="email" required>
            <br>
            <p id="error"></p>
            <a href="index.php?page=userControl"><?php echo $langArr['loginText'];?></a>
            <br>
        <input type="submit" value="<?php echo $langArr['send'];?>">
        </form>
        <?php
    }elseif(isset( $_SESSION['resendEmail']) and $_SESSION['resendEmail']==true){
        echo $loginError."<br>";
        echo "<h2>Email</h2>";
        ?>
        <form action="index.php?page=userControl&resendEmail=true" id="resendForm" method="post">
            <?php echo $langArr['email'];?>:<br><input type="email" id="regEmail" name="email" required>
            <br>
            <p id="error"></p>
            <a href="index.php?page=userControl"><?php echo $langArr['loginText'];?></a>
            <br>
            <input type="submit" name="resendButton" value="<?php echo $langArr['send'];?>">
        </form>
        <?php
    }else{
        if(empty($_SESSION["id"])){
            if(isset($_POST['user']) and isset($_POST['pw'])){
                echo $loginError;
            }
            else echo "<h2>".$langArr['login']."</h2>";

            ?>
            <form action="index.php?page=userControl" method="post">
                <span class="bi bi-person-fill"></span><?php echo $langArr['username'];?>:<br><input type="text" name="user">
                <br>
                <span class="bi bi-key-fill"><?php echo $langArr['password'];?>:</span><br><input type="password" name="pw">
                <br>
                <a href="index.php?page=userControl&register=true"><?php echo $langArr['regText'];?></a><br>
                <a href="index.php?page=userControl&resendEmail=true"><?php echo $langArr['resendEmail'];?></a>
                <br>
            <input type="submit" value="<?php echo $langArr['send'];?>">
            </form>
            <?php						
        }
    }
?>
</div>
<script>
    document.getElementById('pw2').oninput=document.getElementById('pw').oninput=function (){
        if( document.getElementById('pw').value != document.getElementById('pw2').value ){
            document.getElementById('error').innerHTML="<?php echo $langArr['passwordMatch'];?>";
        }else if(document.getElementById('pw').value.includes("asd") || document.getElementById('pw2').value.includes("asd")){
            document.getElementById('error').innerHTML="<?php echo $langArr['weakPassword'];?>";
        }else{
            document.getElementById('error').innerHTML="";
        }
    };
    document.getElementById('regForm').onsubmit = function() {
        if( document.getElementById('pw').value != document.getElementById('pw2').value ){
            return false;
        }

        return true;
    }
    
</script>