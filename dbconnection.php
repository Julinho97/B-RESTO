<?php
	
	//default database configuration
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "b_resto";

	// Create connection
	$sqlconnection = new mysqli($servername, $username, $password,$dbname);

	// Check connection
	if ($sqlconnection->connect_error) {
    	die("Connection failed: " . $sqlconnection->connect_error);
	}
	
?> 