<?php
if(isset($_POST['user']) and isset($_POST['pw'])) {
	$loginError = '';
	if(isset($_POST['pw2']) and isset($_POST['email'])){
		if($_POST['pw2']!=$_POST['pw']) $loginError.="A jelszók nem egyeznek!<br>";
		$email=$_POST['email'];
		if(!strpos($email,"@") or !strpos($email,".") or strlen(explode(".",explode("@",$email)[1])[0])<1 or strlen(explode(".",explode("@",$email)[1])[1])<1){
			$loginError .= "Hibás email!<br>";
		}
		if($loginError == '') {
			$sql = "SELECT id FROM users WHERE username = ? ";
			if($stmt = $conn->prepare($sql)){
				$stmt->bind_param("s", $us);
				$us = $_POST['user'];
				$stmt->execute();
				if(!$result = $stmt->get_result()) echo "SQL Error";
				
				if ($result->num_rows > 0) {
					$loginError .= "Ez a felhasználónév már foglalt<br>";
				}else{
					$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
			
					if($stmt = $conn->prepare($sql)){
						$stmt->bind_param("sss", $us,$pw,$em);
						$us = $_POST['user'];
						$pw = md5($_POST['pw']);
						$em = $_POST['email'];
						if($stmt->execute()){
							header('Location: index.php?page=userControl');
						} else{
							echo "SQL Error";
						}
						$stmt->close();
					}
				}
			}
		}
	}else{
		if(strlen($_POST['user']) == 0) $loginError .= "Nem írtál be felhasználónevet<br>";
		if(strlen($_POST['pw']) == 0) $loginError .= "Nem írtál be jelszót<br>";
		if($loginError == '') {
			$sql = "SELECT id FROM users WHERE username = '".$_POST['user']."' ";
			if(!$result = $conn->query($sql)) echo $conn->error;

			if ($result->num_rows > 0) {
				
				if($row = $result->fetch_assoc()) {
					$user->set_user($row['id'], $conn);
					if(md5($_POST['pw']) == $user->get_password()) {
						$_SESSION["id"] = $row['id'];
						$_SESSION["username"] = $user->get_username();
						header('Location: index.php?page=index');
						exit();
					}
					else $loginError .= 'Érvénytelen jelszó<br>';
				}
			}
			else $loginError .= 'Érvénytelen felhasználónév<br>';
		}
	}
}

include 'view/login.php';

?>