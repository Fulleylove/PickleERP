<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Human Resource Employees";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>HR Employee Manager</h2></div>
			<div style="float: right" class="new_button" id="NewHRManagementEmployee.php" onclick="location.href='load.php?page=NewHRManagementEmployee.php'">+ Employee</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Employee ID</th>
					<th>Employee Name</th>
					<th>Position</th>
					<th>Department</th>
					<th>Manager</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					$DepartmentID = $row["EmployeeDepartment"];
					$ManagerID = $row["EmployeeManager"];

					$secondary_sql = "SELECT * FROM `departments` WHERE `DepartmentID` = '$DepartmentID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$department = $secondary_row["DepartmentName"];
					}
					$manager = "";

					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$ManagerID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$manager = $secondary_row["EmployeeName"];
					}

					?>
					<tr onclick='location.href = "load.php?page=HRManagementEmployee.php?id=<?php echo $row['EmployeeID']; ?> "'>
						<td><?php echo $row["EmployeeID"];?></td>
						<td><?php echo $row["EmployeeName"];?></td>
						<td><?php echo $row["EmployeePosition"];?></td>
						<td><?php echo $department ;?></td>
						<td><?php echo $manager ;?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
					<td></td>
					<td></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

