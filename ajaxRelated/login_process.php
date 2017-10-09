<?php
require_once '../database_connect.php';

if(isset($_GET["username"]) && isset($_GET["password"])){
	$username = htmlspecialchars($_GET["username"]);
	$password = htmlspecialchars($_GET["password"]);
	
	$result = $conn->query("SELECT * FROM users WHERE username = '" . $username  . "' AND password = '" . $password . "'");
		
	if($result->num_rows > 0){
		$conn->close();
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION["current_page"] = "ongletSemaine";
		
		echo "success";
	}
}

?>