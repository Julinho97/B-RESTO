<?php

	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	//Deleting Item
	if (isset($_GET['orderID'])) {
		
		$del_orderID = $sqlconnection->real_escape_string($_GET['orderID']);

		$deleteItemQuery = "DELETE FROM tbl_orderdetail WHERE orderID = {$del_orderID}";

		if ($sqlconnection->query($deleteItemQuery) === TRUE) {
				echo "deleted.";
				header("Location: menu.php"); 
				exit();
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
		//echo "<script>alert('{$del_orderID} & {$del_itemID}')</script>";
	}
?>