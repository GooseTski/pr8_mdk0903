<?php
	session_start();
	include("../settings/connect_datebase.php");
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."';");
	
	$id = -1;
	while($user_read = $query_user->fetch_row()) {
		if(password_verify($password, $user_read[2])){
			$id = $user_read[0];
			$_SESSION['mail'] = $user_read[1]; 
        	$_SESSION['preuser'] = $id;
		}
	}
	
	if($id != -1) {
		$_SESSION['mail'] = $login;
		$_SESSION['preuser'] = $id;
	}
	echo md5(md5($id));
?>