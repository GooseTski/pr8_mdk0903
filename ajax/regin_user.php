php
<?php
session_start();
include("../settings/connect_datebase.php");

$login = $_POST['login'];
$password = $_POST['password'];


$checkPassword = preg_match(
    '/(?=.*[0-9])(?=.*[!@#$%^&*\-_=])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*\-_=]{8,}$/', 
    $password);

if($checkPassword == false) {
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);


$stmt = $mysqli->prepare("SELECT id FROM `users` WHERE `login` = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();

$id = -1;

if($stmt->num_rows > 0) {
    echo $id; 
    $stmt->close();
} else {
    $stmt->close();
    

    $stmt2 = $mysqli->prepare("INSERT INTO `users`(`login`, `password`, `roll`, `token`) VALUES (?, ?, 0, '')");
    $stmt2->bind_param("ss", $login, $password_hash);
    
    if($stmt2->execute()) {
        $id = $mysqli->insert_id;
        $_SESSION['user'] = $id;
        
        
        $token = password_hash($id . time(), PASSWORD_DEFAULT);
        $_SESSION['token'] = $token;
        
        
        $stmt3 = $mysqli->prepare("UPDATE `users` SET `token` = ? WHERE `id` = ?");
        $stmt3->bind_param("si", $token, $id);
        $stmt3->execute();
        $stmt3->close();
    }
    $stmt2->close();
}

echo $id;
?>