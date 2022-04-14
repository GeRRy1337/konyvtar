<html style="height:100%;">

<body style="height:100%;">
    <div class="row">
        <nav class="nav navbar-light sidebar navbar-fixed-left">
            <ul class="navbar-nav mr-auto ">
                <div>Menü</div>
                <li class="nav-item"><button class="sidebar-item" onclick='setDisplay("Settings")'>Beállítások</button></li>
                <li class="nav-item"><button class="sidebar-item" onclick='setDisplay("Borrow")'>Kölcsönzések</button></li>
            </ul>
        </nav>
        <div class="container">
            <?php
            $user->set_user($_SESSION['id'], $conn);
            ?>
            <div class="col" id="Settings">
                <p>Felhasználónév: <?= $user->get_username() ?></p>
                <p>Email: <?= $user->get_email() ?></p>
                <?php
                if ($user->get_cardId() > 0) {
                    echo "<p>Kártyaszám: " . $user->get_cardId() . "</p>";
                }
                ?>
                <form method="post" id="passForm">
                    <h1>Új jelszó</h1>
                    Jelenlegi jelszó: <input type="password" name="oldPw" required><br>
                    Új jelszó: <input type="password" name="pw" id="pw" required><br>
                    Új jelszó megerősítése: <input type="password" name="pw2" id="pw2" required><br>
                    <input type="submit">
                    <p id="error"></p>
                    <?= $loginError ?>
                </form>
                <form method="post" id="emailForm">
                    <h1>Email váltás</h1>
                    Jelenlegi jelszó: <input type="password" name="oldPw" required><br>
                    Új email: <input type="email" name="email" id="email" required><br>
                    Új email megerősítése: <input type="email" name="email2" id="email2" required><br>
                    <input type="submit">
                    <p id="emError"></p>
                    <?= $emError ?>
                </form>
            </div>
            <div id="Borrow" class="col justify-content-center">
                <?php
                $userBorrowedList = $user->userBorrowed($conn);
                if (sizeof($userBorrowedList) > 0) {
                ?>
                    <h3><?php echo $langArr['borrow']; ?></h3>
                    <table class="table table-dark table-bordered w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th><?php echo $langArr['bookTitle']; ?></th>
                                <th><?php echo $langArr['bookNum']; ?></th>
                                <th><?php echo $langArr['bookDate']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $index = 1;
                            foreach ($userBorrowedList as $book) {
                                echo '<tr>';
                                echo '<td>' . ($index++) . '</td>';
                                foreach ($book as $element) {
                                    echo '<td>' . $element . '</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                <?php
                } else {
                ?>

                    <p><?php echo $langArr['noBorrow']; ?></p>

                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.onload = setDisplay("Settings");

        function setDisplay(disId) {
            displayNone();
            document.getElementById(disId).style.display = "block";
        }

        function displayNone() {
            document.getElementById("Settings").style.display = "none";
            document.getElementById("Borrow").style.display = "none";
        }
        document.getElementById('pw2').oninput = document.getElementById('pw').oninput = function() {
            if (document.getElementById('pw').value != document.getElementById('pw2').value) {
                document.getElementById('error').innerHTML = "<?php echo $langArr['passwordMatch']; ?>";
            } else if (document.getElementById('pw').value.includes("asd") || document.getElementById('pw2').value.includes("asd")) {
                document.getElementById('error').innerHTML = "<?php echo $langArr['weakPassword']; ?>";
            } else {
                document.getElementById('error').innerHTML = "";
            }
        };
        document.getElementById('email').oninput = document.getElementById('email2').oninput = function() {
            if (document.getElementById('email').value != document.getElementById('email2').value) {
                document.getElementById('emError').innerHTML = "<?php echo "Az email címek nem egyeznek"; ?>";
            } else {
                document.getElementById('emError').innerHTML = "";
            }
        };
        document.getElementById('passForm').onsubmit = function() {
            if (document.getElementById('pw').value != document.getElementById('pw2').value) {
                return false;
            }

            return true;
        }
        document.getElementById('emailForm').onsubmit = function() {
            if (document.getElementById('email').value != document.getElementById('email2').value) {
                return false;
            }

            return true;
        }
    </script>