<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Users";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">


		<div class="Container">
			<div style="float: left"><h2>User Manager</h2></div>
			<div style="float: right" class="new_button" id="NewHRManagementEmployee.php" onclick="location.href='load.php?page=NewAdministrationUser.php'">+ User</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>User ID</th>
					<th>Username</th>
					<th>Employee Parent</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `users` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					$EmployeeID = $row["EmployeeID"];

					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$EmployeeID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$employee_name = $secondary_row["EmployeeName"];
					}

					?>
					<tr onclick='location.href = "load.php?page=AdministrationUser.php?id=<?php echo $row['UserID']; ?> "'>
						<td><?php echo $row["UserID"];?></td>
						<td><?php echo $row["Username"];?></td>
						<td><?php echo $employee_name ;?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

