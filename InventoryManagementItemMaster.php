<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "The Item Master";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>Item Master</h2></div>
			<div style="float: right" class="new_button" id="NewInventoryManagementItemGroup" onclick="location.href='load.php?page=NewInventoryManagementItemGroup.php'">+ Item Group</div>
			<div style="float: right; margin-right: 10px;" class="new_button" id="NewInventoryManagementsupplier" onclick="location.href='load.php?page=NewInventoryManagementItem.php'">+ Item</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Item Name</th>
					<th>Item Description</th>
					<th>Item Group</th>
					<th>Supplier</th>
					<th>Unit Price</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `items` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

						$CategoryID = $row["CategoryID"];
						$SupplierID = $row["SupplierID"];

					   	$secondary_sql = "SELECT * FROM `itemgroups` WHERE `ItemGroupID` = '$CategoryID'";
					   	$member_of = mysqli_query($connection, $secondary_sql);
					   	while($member = mysqli_fetch_assoc($member_of)){
					   		$Item = $member["GroupName"];
					   	}
					   	$secondary_sql = "SELECT * FROM `contacts` WHERE `ContactID` = '$SupplierID'";
					   	$member_of = mysqli_query($connection, $secondary_sql);
					   	while($member = mysqli_fetch_assoc($member_of)){
					   		$Supplier = $member["ContactName"];
					   	}


					?>
					<tr onclick='location.href = "load.php?page=InventoryManagementItem.php?id=<?php echo $row['ItemID']; ?> "'>

						<td><?php echo $row["Name"];?></td>
						<td><?php echo $row["Description"];?></td>
						<td><?php echo $Item;?></td>
						<td><?php echo $Supplier;?></td>
						<td>£<?php echo number_format($row["UnitPrice"], 2);?></td>


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

