<?php


	error_reporting(0);
	session_start();

	if(!isset($_SESSION["user_id"])){
		header("location:login.php");
	}

	$logged_in_user= $_SESSION["user_id"];
	$logged_in_company = $_SESSION["company_id"];
	$logged_in_user_username = $_SESSION["username"];

	// $logged_in_company = 1;
	$time = time();
	$date = date("Y-m-d");
	$long_date = date("Y-m-d H:i:s");
	$connection = mysqli_connect("localhost", "root", "", "pickle");

	$current_script =  basename($_SERVER["SCRIPT_FILENAME"]);



	$sql = "SELECT * FROM `pages` WHERE `PageName` = '$current_script'";
	// echo $sql;
	$query = mysqli_query($connection, $sql);

	while($row = mysqli_fetch_assoc($query)){


		$PAGEID = $row["PageID"];

		// echo $PAGEID;

		$secondary_sql = "SELECT * FROM `user_access` WHERE `UserID` = '$logged_in_user' AND `PageID` = '$PAGEID' ";
		// echo $secondary_sql;
		$secondary_query = mysqli_query($connection, $secondary_sql);
		while($secondary_row = mysqli_fetch_assoc($secondary_query)){

			$access_level = $secondary_row["Access"];

			if($access_level == "False"){
				header("location:denied.php?id=$PAGEID");
			}

		}

	}




?>