<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Purchase Orders";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>Purchase Order Manager</h2></div>
			<div style="float: right" class="new_button" id="NewFinanceManagementPurchaseOrder" onclick="location.href='load.php?page=NewFinanceManagementPurchaseOrder.php'">+ Purchase Order</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Description</th>
					<th>Reference</th>
					<th>Price</th>
					<th>Paid</th>
					<th>Due Date</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `purchaseorders` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					?>
					<tr onclick='location.href = "load.php?page=FinanceManagementPurchaseOrder.php?id=<?php echo $row['PurchaseOrderID']; ?> "'>
						<td><?php echo $row["Description"];?></td>
						<td><?php echo $row["Reference"];?></td>
						<td>£<?php echo $row["Total"];?></td>
						<td>£<?php echo $row["Paid"]; ?></td>
						<td><?php echo $row["DueDate"]; ?></td>
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



