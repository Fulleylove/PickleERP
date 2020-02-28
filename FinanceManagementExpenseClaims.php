<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Expense Claims";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">
		
		<div class="Container">
			<div style="float: left"><h2>Expense Manager</h2></div>
			<div style="float: right" class="new_button" id="NewFinanceManagementExpenseClaim" onclick="location.href='load.php?page=NewFinanceManagementExpenseClaim.php'">+ Approved Expense</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Expense Description</th>
					<th>Employee Reference</th>
					<th>Approved By</th>
					<th>Approved Date</th>
					<th>Account Name</th>
					<th>Amount</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `expenseclaims` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					$EmployeeID = $row["EmployeeID"];
					$CreatedBy = $row["CreatedBy"];
					$AccountID = $row["AccountID"];

					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$EmployeeID' ";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$Employee = $secondary_row["EmployeeName"];
					}

					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$CreatedBy' ";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$Approver = $secondary_row["EmployeeName"];
					}

					$secondary_sql = "SELECT * FROM `accounts` WHERE `AccountID` = '$AccountID' ";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$AccountName = $secondary_row["AccountName"];
					}
					?>

					<tr onclick='location.href = "load.php?page=FinanceManagementExpenseClaim.php?id=<?php echo $row['ExpenseID']; ?> "'>
						<td><?php echo $row["ExpenseDescription"];?></td>
						<td><?php echo $Employee ;?></td>
						<td><?php echo $Approver ;?></td>
						<td><?php echo $row["DateCreated"];?></td>
						<td><?php echo $AccountName ;?></td>
						<td><?php echo $row["Amount"];?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
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

