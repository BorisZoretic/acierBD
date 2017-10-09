<?php

	$servername = "localhost";
	$username = "bdfastech";
	$password = "G3!stF4st";
	$dbname = "acier_fastech"; 
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	//remember to $conn->close() after finishing with query
?>