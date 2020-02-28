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
			
			<!-- <a href='load.php?page=FinanceManagementAccounts.php'>Go Back</a> -->
			
			<form action="add.php" method="post">
				<?php
				if($_GET["ReferenceType"] == 'employee'){
				?>
					<input type="hidden" name="page_relocate" value="load.php?page=HRManagementEmployee.php?id=<?php echo $_GET['ReferenceID']; ?>">
				<?php
				}
				?>
				<input type="hidden" name="table_name" value="phones">
				<input type="hidden" name="ReferenceType" value="<?php echo $_GET['ReferenceType'];?>">
				<input type="hidden" name="ReferenceID" value="<?php echo $_GET['ReferenceID'];?>">

				<div class="label">Email Address</div>
				<input name="EmailAddress" type="text" class="standard_input" placeholder="###########"><br><br>

				<input type="submit" value="Create">
			</form>
		
		</div>
	</div>
</body>
</html>

