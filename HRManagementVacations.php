<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Human Resource Vacations";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>HR Vacation Manager</h2></div>
			<div style="float: right" class="new_button" id="NewHRManagementVacation.php" onclick="location.href='load.php?page=NewHRManagementVacation.php'">+ Approved Vacation</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Vacation ID</th>
					<th>Employee</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `vacation` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					$EmployeeID = $row["EmployeeID"];
					$employee_name = "";
					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$EmployeeID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$employee_name = $secondary_row["EmployeeName"];
					}

					?>
					<tr >
						<td><?php echo $row["VacationID"];?></td>
						<td><?php echo $employee_name;?></td>
						<td><?php echo $row["StartDate"] ;?></td>
						<td><?php echo $row["EndDate"]; ?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
					<td></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

