<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "FWarehouse Locations";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$location = $_GET["id"];

	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>Stock at location</h2></div>
			<div style="float: right" class="new_button" id="NewFinanceManagementAccount" onclick="location.href='load.php?page=NewInventoryManagementStock.php?location=<?php echo $_GET['id'];?>'">+ Stock</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Item SKU Code</th>
					<th>Item Name</th>
					<th>Location ID</th>
					<th>Amount</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$location = $_GET["id"];

				$secondary_sql = "SELECT * FROM `locations` WHERE `LocationID` = '$location' ";
				$secondary_query = mysqli_query($connection, $secondary_sql);
				while($secondary_row = mysqli_fetch_assoc($secondary_query)){
					$location_name = $secondary_row["name"];
				}


				$sql = "SELECT * FROM `stock_locations` WHERE `LocationID` = '$location' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					$ItemID = $row["ItemID"];

					$secondary_sql = "SELECT * FROM `items` WHERE `ItemID` = '$ItemID' ";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$ItemName = $secondary_row["Name"];
					}
					


					?>
					<tr onclick='location.href = "load.php?page=InventoryManagementStockLocation.php?id=<?php echo $row['WarehouseID']; ?> "'>
						<td><?php echo $row["ItemID"];?></td>
						<td><?php echo $ItemName ;?></td>
						<td><?php echo $location_name;?></td>
						<td><?php echo $row["Amount"];?> Units</td>
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

