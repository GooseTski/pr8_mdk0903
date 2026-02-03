<?
session_start();
include("../settings/connect_datebase.php");
if(isset($_SESSION["code"]) == false) exit;
if(isset($_POST["code"]) == false) exit;

if($_SESSION["code"] == $_POST["code"]) {
    $_SESSION['user'] = $_SESSION['preuser'];

    $token = password_hash($_SESSION['user'], PASSWORD_DEFAULT);
    $_SESSION['token'] = $token;
    $mysqli->query("UPDATE `users` SET `token` = '$token' WHERE `id` = ".$_SESSION['user']);

    unset($_SESSION['code']);
    unset($_SESSION['preuser']);
    echo "Код совпал";
} else {
    unset($_SESSION['code']);
    unset($_SESSION['preuser']);
}
?>