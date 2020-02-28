<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<script src="Javascript/Chart.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Access Denied";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	


	?>

	<div id="display">
		<div class="Container">
		<h1>Access Denied</h1>	
		<p>Sorry, you dont have permission to access this page.<Br><br>Your manager can change this from the "Users" page.</p>
		</div>


	</div>
</body>
</html>
