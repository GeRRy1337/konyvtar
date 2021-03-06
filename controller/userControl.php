<?php
$loginError = '';
if (isset($_POST['user']) and isset($_POST['pw'])) {
	if (isset($_POST['pw2']) and isset($_POST['email'])) {
		//regisztráció
		//üres mezők ellenőrzése
		if ($_POST['pw2'] != $_POST['pw']) $loginError .= $langArr["passwordMatch"] . "<br>";
		if (strlen($_POST['user']) == 0) $loginError .= $langArr['emptyUser'] . "<br>";
		if (strlen($_POST['pw']) == 0) $loginError .= $langArr['emptyPass'] . "<br>";
		if (strlen($_POST['pw2']) == 0) $loginError .= $langArr['emptyPass'] . "<br>";
		$email = $_POST['email'];
		if (!strpos($email, "@") or !strpos($email, ".") or strlen(explode(".", explode("@", $email)[1])[0]) < 1 or strlen(explode(".", explode("@", $email)[1])[1]) < 1) {
			$loginError .= $langArr["emailError"] . "<br>";
		}
		if ($loginError == '') {
			// létezik e már ilyen felhasználónév
			$sql = "SELECT id FROM users WHERE username = ? ";
			if ($stmt = $conn->prepare($sql)) {
				$stmt->bind_param("s", $us);
				$us = $_POST['user'];
				$stmt->execute();
				if (!$result = $stmt->get_result()) echo "SQL Error";

				if ($result->num_rows > 0) {
					//létezik
					$loginError .= $langArr['userInUse'] . "<br>";
				} else {
					/*nem léteziki ilyen felhasználónév
						létezik e ilyen email?
					*/
					$sql = "SELECT id FROM users WHERE email = ? ";
					if ($stmt = $conn->prepare($sql)) {
						$stmt->bind_param("s", $em);
						$em = $_POST['email'];
						$stmt->execute();
						if (!$result = $stmt->get_result()) echo "SQL Error";
						if ($result->num_rows > 0) {
							// létezik ez az email
							$loginError .= $langArr['emailInUse'] . "<br>";
						} else {
							//nem létezik az email
							$sql = "INSERT INTO users (username, password, email,email_key) VALUES (?, ?, ?, ?)";
							if ($stmt = $conn->prepare($sql)) {
								$stmt->bind_param("ssss", $us, $pw, $em, $emkey);
								$us = $_POST['user'];
								$pw = md5($_POST['pw']);
								$em = $_POST['email'];
								$emkey = hash("sha256", $us . ":" . $em);
								if ($stmt->execute()) {
									//megerősítő email küldése
									$to      = $em;
									$subject = $langArr["emailSubject"];
									$message = $langArr["emailConfrim"] . '<a href="' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?page=userControl&emailConf=' . $emkey . '">Link</a>';
									$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= 'From: noreply@konyvtar.com' . "\r\n";
									mail($to, $subject, $message, $headers);
									header('Location: index.php?page=userControl');
								} else {
									echo "SQL Error";
								}
								$stmt->close();
							}
						}
					}
				}
			}
		}
	} else {
		//bejelentkezés
		if (strlen($_POST['user']) == 0) $loginError .= $langArr['emptyUser'] . "<br>";
		if (strlen($_POST['pw']) == 0) $loginError .= $langArr['emptyPass'] . "<br>";
		if ($loginError == '') {
			//felhasználó megkereséses
			$sql = "SELECT id,email_confirm FROM users WHERE username = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("s", $us);
			$us = $_POST['user'];
			if ($stmt->execute()) {
				if (!$result = $stmt->get_result()) echo "SQL Error";
				if ($result->num_rows > 0) {
					if ($row = $result->fetch_assoc()) {
						//megerősítette e az email címét?
						if ($row['email_confirm'] == 1) {
							$user->set_user($row['id'], $conn);
							if (md5($_POST['pw']) == $user->get_password()) {
								$_SESSION["id"] = $row['id'];
								$_SESSION["username"] = $user->get_username();
								header('Location: index.php?page=index');
								exit();
							} else $loginError .= $langArr['passError'] . '<br>';
						} else $loginError .= $langArr['emailConfirmError'] . '<br>';
					}
				} else $loginError .= $langArr['userError'] . '<br>';
			}
		}
	}
}

if (isset($_POST['resendButton']) and isset($_POST['email'])) {
	//megerősítő email újraküldése
	$email = $_POST['email'];
	if (!strpos($email, "@") or !strpos($email, ".") or strlen(explode(".", explode("@", $email)[1])[0]) < 1 or strlen(explode(".", explode("@", $email)[1])[1]) < 1) {
		$loginError .= $langArr["emailError"] . "<br>";
	}
	if ($loginError == '') {
		$sql = "SELECT id,username FROM users WHERE email = ? ";
		if ($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("s", $em);
			$em = $_POST['email'];
			$stmt->execute();
			if (!$result = $stmt->get_result()) echo "SQL Error";
			if ($result->num_rows > 0) {
				if ($row = $result->fetch_assoc()) {
					$emkey = hash("sha256", $row['username'] . ":" . $_POST['email']);
					$to      = $em;
					$subject = $langArr["emailSubject"];
					$message = $langArr["emailConfrim"] . '<a href="' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?page=userControl&emailConf=' . $emkey . '">Link</a>';
					$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: noreply@konyvtar.com' . "\r\n";
					mail($to, $subject, $message, $headers);
					header('Location: index.php?page=userControl');
				}
			} else {
				$loginError = $langArr['emailError'];
			}
		}
	}
}

if (isset($_REQUEST['emailConf'])) {
	//email megerősítése
	$sql = "SELECT id FROM users WHERE email_key = ? ";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("s", $em);
		$em = $_REQUEST['emailConf'];
		$stmt->execute();
		if (!$result = $stmt->get_result()) echo "SQL Error";
		if ($result->num_rows > 0) {
			$sql = "UPDATE users SET email_confirm=1 where email_key=?";
			if ($stmt = $conn->prepare($sql)) {
				$stmt->bind_param("s", $emkey);
				$emkey = $_REQUEST['emailConf'];
				if ($stmt->execute()) {
					header('Location: index.php?page=userControl');
				} else {
					echo "SQL Error";
				}
				$stmt->close();
			}
		}
	}
}

//regisztráció
if (isset($_REQUEST['register']) and $_REQUEST['register'] == true) {
	$_SESSION['register'] = true;
} elseif (!isset($_REQUEST['register']) and isset($_SESSION['register']) and $_SESSION['register'] == true) {
	$_SESSION['register'] = false;
}
// email újraküldés
if (isset($_REQUEST['resendEmail']) and $_REQUEST['resendEmail'] == true) {
	$_SESSION['resendEmail'] = true;
} elseif (!isset($_REQUEST['resendEmail']) and isset($_SESSION['resendEmail']) and $_SESSION['resendEmail'] == true) {
	$_SESSION['resendEmail'] = false;
}

include 'view/login.php';
?>