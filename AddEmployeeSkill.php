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
				<input type="hidden" name="table_name" value="skills">
				<div class="label">Skill Name</div>
				<select name="Skill" class="standard_input">
					<?php 

						$sql = "SELECT * FROM `company_skills` WHERE `CompanyID` = '$logged_in_company'";
						$query = mysqli_query($connection, $sql);
						while($row = mysqli_fetch_assoc($query)){
						?>

						<option value="<?php echo $row['CompanySkillID']; ?>"><?php echo $row["SkillName"] ;?></option>

						<?php
						} 

					?>
				</select><br>

				<div class="label">Employee</div>
				<select name="EmployeeID" class="standard_input">
					<?php 

						$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
						$query = mysqli_query($connection, $sql);
						while($row = mysqli_fetch_assoc($query)){
						?>

						<option value="<?php echo $row['EmployeeID']; ?>"><?php echo $row["EmployeeName"] ;?></option>

						<?php
						} 

					?>
				</select><br>
				<div class="label">Expiry</div>
				<input class="standard_input" type="date" name="Expiry"><br><br>
				<input type="submit" value="Create">
			</form>
		
		</div>
	</div>
</body>
</html>

