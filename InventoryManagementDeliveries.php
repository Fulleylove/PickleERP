<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Deliveries";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>Deliveries</h2></div>
			<div style="float: right; margin-right: 10px;" class="new_button" id="NewInventoryManagementsupplier" onclick="location.href='load.php?page=NewInventoryManagementDeliveryStageOne.php'">+ Delivery</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Delivery ID</th>
					<th>Purchase Order ID</th>
					<th>Estimated Delivery</th>
					<th>Actual Delivery</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `deliveries` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					?>
					<tr onclick='location.href = "load.php?page=InventoryManagementDelivery.php?id=<?php echo $row['DeliveryID']; ?> "'>

						<td><?php echo $row["DeliveryID"];?></td>
						<td><?php echo $row["PurchaseOrderID"];?></td>
						<td><?php echo $row["EstimatedDelivery"];?></td>
						<td><?php echo $row["ActualDelivery"];?></td>


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

