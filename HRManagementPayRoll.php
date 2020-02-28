<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Human Resource Pay Roll";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>Pay Roll Manager</h2></div>
			<div style="float: right" class="new_button" id="NewHRManagementEmployee.php" onclick="location.href='load.php?page=NewHRManagementEmployee.php'">+ Employee</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Employee ID</th>
					<th>Employee Name</th>
					<th>Position</th>
					<th>Yearly Wage</th>
					<th>Monthly Wage</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$running_total = 0;
				$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company' ";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					?>
					<tr onclick='location.href = "load.php?page=HRManagementEmployee.php?id=<?php echo $row['EmployeeID']; ?> "'>
						<td><?php echo $row["EmployeeID"];?></td>
						<td><?php echo $row["EmployeeName"];?></td>
						<td><?php echo $row["EmployeePosition"];?></td>
						<td><?php echo $row["EmployeeWage"] ;?></td>
						<td>£<?php echo round(($row["EmployeeWage"] / 12), 2) ;?></td>
					</tr>
					<?php
					$running_total = $running_total + round(($row["EmployeeWage"]  / 12), 2);
				}
			?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Monthly Total : </b></td>
					<td><b>£<?php echo $running_total ;?></b></td>
				</tr>

				<tr>			
			<form action="add.php" method="post">
				<input type="hidden" name="page_relocate" value="load.php?page=FinanceManagementPurchaseOrders.php">
				<input type="hidden" name="table_name" value="purchaseorders">
				<input type="hidden" name="CreatedBy" value="<?php echo $logged_in_user; ?>">
				<input type="hidden" name="DateCreated" value="<?php echo $date ; ?>">
				<input type="hidden" name="InvoiceNumber" value="0">				

				<input type="hidden" class="standard_input" name="ContactReference" id="">

				<!-- <div class="label">PurchaseOrder Description</div> -->
				<input name="Description" type="hidden" placeholder="Purchase order for paper" value="PAYROLL <?php echo date('M Y'); ?>">
				<input name="DueDate" type="hidden" value="<?php echo date('Y-m-d'); ?>">
				<input name="Reference" type="hidden" value="PAYROLL <?php echo date('M Y') ;?>" class="standard_input">
				<input type="hidden" name="Total" value="<?php echo $running_total ;?>">
				<input type="hidden" name="vAT" value="0">
				<input type="hidden" name="Paid" value="0">

					<td></td>
					<td></td>
					<td></td>
					<td>Monthly Payroll PO</td>
					<td><input type="submit" value="Create"></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

