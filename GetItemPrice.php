<?php

	$id = $_POST["id"];
	include("connect.php");
	$sql = "SELECT * FROM `items` WHERE `ItemID` = '$id' ";

	$q = mysqli_query($connection, $sql);

	while ($row = mysqli_fetch_assoc($q)) {
		
		echo $row["UnitPrice"];

	}


?>