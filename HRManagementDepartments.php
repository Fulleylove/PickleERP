<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Human Resource Departments";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>HR Department Manager</h2></div>
			<div style="float: right" class="new_button" id="NewHRManagementDepartment.php" onclick="location.href='load.php?page=NewHRManagementDepartment.php'">+ Department</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Department Name</th>
					<th># Of Employees</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `departments` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					$DepartmentID = $row["DepartmentID"];

					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeDepartment` = '$DepartmentID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					$number = mysqli_num_rows($secondary_query);
					?>
					<tr onclick='location.href = "load.php?page=FinanceManagementAccount.php?id=<?php echo $row['AccountID']; ?> "'>
						<td><?php echo $row["DepartmentName"];?></td>
						<td><?php echo $number;?> Employees</td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

