<?php
$browser = $_SERVER['HTTP_USER_AGENT'];
if (strpos($browser, "Java") == false) header('location:../index.php?page=index&search=false');
if (isset($_REQUEST['key']) and $_REQUEST['key'] == "313303ef7840acb49ba489ddb9247be4969e8a650f28eda39756556868d9c1ea") {
    require(realpath($_SERVER["DOCUMENT_ROOT"]) . '/gergo/szakdolgozat/Includes/db.inc.php');
    if (isset($_REQUEST['action'])) {
        if ($_REQUEST['action'] == "Select") {
            $condition = "";
            if (isset($_REQUEST["from"])) {
                if (isset($_REQUEST["id"])) $condition .= "id=" . $_REQUEST["id"] . " and ";
                if (isset($_REQUEST["stockNum"])) $condition .= "stockNum=" . $_REQUEST["stockNum"] . " and ";
                if (isset($_REQUEST["state"])) $condition .= "state=" . $_REQUEST["state"] . " and ";
                if (isset($_REQUEST["ISBN"])) $condition .= "ISBN=" . $_REQUEST["ISBN"] . " and ";
                if (isset($_REQUEST["name"])) $condition .= "name='" . $_REQUEST["name"] . "' and ";
                if (isset($_REQUEST["userId"])) $condition .= "userId=" . $_REQUEST["userId"] . " and ";
                if (isset($_REQUEST["username"])) $condition .= "username=" . $_REQUEST["username"] . " and ";
                if (isset($_REQUEST["category_name"])) $condition .= "category_name='" . $_REQUEST["category_name"] . "' and ";
                $condition = substr($condition, 0, strlen($condition) - 4);
                $sql = "Select * from " . $_REQUEST["from"] . (strlen($condition) > 0 ? " Where " . $condition : "");
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    if ($row = $result->fetch_assoc()) {
                        echo "response:True\n";
                        foreach ($row as $key => $param) {
                            echo $key . ":" . $param . "\n";
                        }
                    }
                } else {
                    echo "response:False\n";
                }
            } else {
                if (isset($_REQUEST['username']) and isset($_REQUEST['password'])) {
                    $result = $conn->query("Select users.id, admins.permission from users inner join admins on users.id=admins.id where username='" . $_REQUEST['username'] . "' and password='" . $_REQUEST['password'] . "'");
                    if ($result->num_rows > 0) {
                        if ($row = $result->fetch_assoc()) {
                            echo "response:True\n";
                            echo "id:" . $row['id'] . "\n";
                            echo "permission:" . $row['permission'] . "\n";
                        }
                    } else {
                        $result = $conn->query("Select id from users where username='" . $_REQUEST['username'] . "' and password='" . $_REQUEST['password'] . "'");
                        if ($result->num_rows > 0) {
                            echo "user:exists\n";
                        }
                        echo "response:False\n";
                    }
                }
            }
        } elseif ($_REQUEST['action'] == "Insert") {
            if (isset($_REQUEST['img'])) {
                $path = explode("\\", $_REQUEST['img']);
                $sql = "INSERT INTO " . $_REQUEST['to'] . " " . str_replace("blank", "'images/covers/" . $path[count($path) - 1] . "'", $_REQUEST['values']);
                if ($result = $conn->query($sql)) {
                    echo "response:True\n";
                } else {
                    echo "response:False\n";
                }
            } else {
                $sql = "INSERT INTO " . $_REQUEST['to'] . " " . $_REQUEST['values'];
                if ($result = $conn->query($sql)) {
                    echo "response:True\n";
                    if ($_REQUEST['to'] == "cards(birth,addres,phoneNumber,name,valid)") {
                        $sql = "Select id From cards Order by id desc limit 1";
                        $result = $conn->query($sql);
                        echo "id:" . $result->fetch_assoc()['id'] . "\n";
                    }
                } else {
                    echo "response:False\n";
                }
            }
        } elseif ($_REQUEST['action'] == "Update") {
            $condition = "";
            if (isset($_REQUEST["stockNum"])) $condition .= "stockNum=" . $_REQUEST["stockNum"] . " and ";
            if (isset($_REQUEST["state"])) $condition .= "state=" . $_REQUEST["state"] . " and ";
            if (isset($_REQUEST["userId"])) $condition .= "userId=" . $_REQUEST["userId"] . " and ";
            if (isset($_REQUEST["id"])) $condition .= "id=" . $_REQUEST["id"] . " and ";
            if (isset($_REQUEST["ISBN"])) $condition .= "ISBN=" . $_REQUEST["ISBN"] . " and ";
            $condition = substr($condition, 0, strlen($condition) - 4);
            $sql = "Update " . $_REQUEST['to'] . " Set " . str_replace(":", "=", $_REQUEST['set']) . (strlen($condition) > 0 ? " Where " . $condition : "");
            if ($result = $conn->query($sql)) {
                echo "response:True\n";
                echo 'sql:' . $sql . "\n";
            } else {
                echo "response:False\n";
            }
        } elseif ($_REQUEST['action'] == "Delete") {
            $condition = "";
            if (isset($_REQUEST["id"])) $condition .= "id=" . $_REQUEST["id"] . " and ";
            if (isset($_REQUEST["stockNum"])) $condition .= "stockNum=" . $_REQUEST["stockNum"] . " and ";
            if (isset($_REQUEST["bookId"])) $condition .= "bookId=" . $_REQUEST["bookId"] . " and ";
            $condition = substr($condition, 0, strlen($condition) - 4);
            $sql = "Delete from " . $_REQUEST["from"] . (strlen($condition) > 0 ? " Where " . $condition : "");
            if ($conn->query($sql) === TRUE) {
                echo "response:True\n";
            } else {
                echo "response:False\n";
            }
        } elseif ($_REQUEST['action'] == "userList") {
            $sql = "Select * from users where id not in (select id from admins)";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "response:True\n";
                $users = array();
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['username'];
                }
                echo "users:" . json_encode($users, JSON_UNESCAPED_UNICODE) . "\n";
            } else {
                echo "response:False\n";
            }
        } elseif ($_REQUEST['action'] == "adminList") {
            $sql = "Select * from users where id in (select id from admins)";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "response:True\n";
                $users = array();
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row['username'];
                }
                echo "users:" . json_encode($users, JSON_UNESCAPED_UNICODE) . "\n";
            } else {
                echo "response:False\n";
            }
        } elseif ($_REQUEST['action'] == "getPermission") {
            $sql = "Select permission from admins inner join users on admins.id=users.id where username='" . $_REQUEST['username'] . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {
                    echo "response:True\n";
                    echo "permission:" . $row['permission'] . "\n";
                }
            } else {
                echo "response:False\n";
            }
        } elseif ($_REQUEST['action'] == "cardList") {
            $sql = "Select cards.*, users.username from cards left join usercards on cards.id=usercards.cardId left join users on usercards.userId=users.id order by cards.name";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "response:True\n";
                $cards = array();
                while ($row = $result->fetch_assoc()) {
                    $cards[] = $row['id'] . ";" . $row['valid'] . ";" . $row['name'] . ";" . $row['username'] . ";" . $row['addres'] . ";" . $row['birth'] . ";" . $row['phoneNumber'];
                }
                echo "cards:" . json_encode($cards, JSON_UNESCAPED_UNICODE) . "\n";
            } else {
                echo "response:False\n";
            }
        } elseif ($_REQUEST['action'] == "getCategories") {
            if (isset($_REQUEST['bId'])) {
                $sql = "Select category_name from categories INNER JOIN categoryconn on categories.category_id=categoryconn.categoryId where bookId=" . $_REQUEST['bId'];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "response:True\n";
                    $categories = array();
                    while ($row = $result->fetch_assoc()) {
                        $categories[] = $row['category_name'];
                    }
                    echo "categories:" . json_encode($categories, JSON_UNESCAPED_UNICODE) . "\n";
                } else {
                    echo "response:False\n";
                }
            } else {
                $sql = "Select category_name from categories ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "response:True\n";
                    $categories = array();
                    while ($row = $result->fetch_assoc()) {
                        $categories[] = $row['category_name'];
                    }
                    echo "categories:" . json_encode($categories, JSON_UNESCAPED_UNICODE) . "\n";
                } else {
                    echo "response:False\n";
                }
            }
        } elseif ($_REQUEST['action'] == "borrowList") {
            $sql = "SELECT borrow.cardNum,cards.name,books.BookTitle,borrow.stockNum,borrow.date  FROM `borrow` inner JOIN cards on cards.id=borrow.cardNum inner JOIN stock on stock.stockNum=borrow.stockNum INNER JOIN books on books.id = stock.bookId WHERE state = 0 order by date ASC;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "response:True\n";
                $borrows = array();
                while ($row = $result->fetch_assoc()) {
                    $borrows[] = $row['cardNum'] . ";" . $row['name'] . ";" . $row['BookTitle'] . ";" . $row['stockNum'] . ";" . $row['date'];
                }
                echo "borrows:" . json_encode($borrows, JSON_UNESCAPED_UNICODE) . "\n";
            } else {
                echo "response:False\n";
            }
        } else {
            echo 'Error: Unknow action!';
        }
        return;
    } else {
        if (isset($_FILES['uploaded_file'])) {
            var_dump($_FILES['uploaded_file']);
            $target_path = "../images/covers/";
            $target_path = $target_path . basename($_FILES['uploaded_file']['name']);

            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path)) {
                echo "response:True\n";
            } else {
                echo "response:False\n";
            }
        }
        return;
    }
} else {
    echo "You don't have privileges to view this page!";
}
?>