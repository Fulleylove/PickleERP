<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Create Finance Account";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>
	
	<div id="display">
		<div class="Container">
			
			<a href='load.php?page=FinanceManagementAccounts.php'>Go Back</a>
			
			<form action="add.php" method="post">
				<input type="hidden" name="page_relocate" value="load.php?page=HRManagementSkillsMatrix.php">
				<input type="hidden" name="table_name" value="company_skills">
				<div class="label">Skill Name</div>
				<input name="SkillName" type="text" class="standard_input" placeholder="HGV Level 1"><br><br>
				<input type="submit" value="Create">
			</form>
		
		</div>
	</div>
</body>
</html>

