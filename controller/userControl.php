<?php

if(isset($_POST['user']) and isset($_POST['password'])) {
	$loginError = '';
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

include 'view/login.php';

?>