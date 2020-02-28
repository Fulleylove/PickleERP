<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Human Resource Vacancies";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>HR Vacancy Manager</h2></div>
			<div style="float: right" class="new_button" id="NewHRManagementVacancy.php" onclick="location.href='load.php?page=NewHRManagementVacancy.php'">+ Vacancy</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Vacancy ID</th>
					<th>Position</th>
					<th>Manager</th>
					<th>Date Created</th>
					<th>Status</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `vacancies` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					$ManagerID = $row["Manager"];
					$manager = "";
					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$ManagerID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$manager = $secondary_row["EmployeeName"];
					}

					?>
					<tr onclick='location.href = "load.php?page=HRManagementVacancy.php?id=<?php echo $row['EmployeeID']; ?> "'>
						<td><?php echo $row["VacancyID"];?></td>
						<td><?php echo $row["VacancyPosition"];?></td>
						<td><?php echo $manager;?></td>
						<td><?php echo $row["DateCreated"] ;?></td>
						<td><?php echo $row["Status"]; ?></td>
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

