<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
		<script src="Javascript/Chart.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Dashboard";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$sql = "SELECT * FROM `warehouses` WHERE `CompanyID` = '$logged_in_company'  ";
	$query = mysqli_query($connection, $sql);
	$warehouses = mysqli_num_rows($query);

	$sql = "SELECT * FROM `contacts` WHERE `CompanyID` = '$logged_in_company' AND `ContactType` = 'supplier' ";
	$query = mysqli_query($connection, $sql);
	$suppliers = mysqli_num_rows($query);

	$sql = "SELECT * FROM `locations` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$locations = mysqli_num_rows($query);

	$sql = "SELECT * FROM `items` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$SKUs = mysqli_num_rows($query);

	$sql = "SELECT * FROM `deliveries` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$deliveries = mysqli_num_rows($query);

	$sql = "SELECT * FROM `purchaseorderlines` WHERE `CompanyID` = '$logged_in_company' AND `Delivered` = 'True' ";
	$query = mysqli_query($connection, $sql);
	$delivered = mysqli_num_rows($query);
	?>

	<div id="display">
		
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Locations</div>
			<div class="DashboardTileFigure"><?php echo $locations ;?></div>
			<div class="DashboardTileFurther">Accross <?php echo $warehouses ;?> Warehouses</div>

		</div>
	
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total SKUs</div>
			<div class="DashboardTileFigure"><?php echo $SKUs ;?></div>
			<div class="DashboardTileFurther">From <?php echo $suppliers; ?> Suppliers</div>

		</div>

 		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Deliveries</div>
			<div class="DashboardTileFigure"><?php echo $deliveries ;?></div>
			<div class="DashboardTileFurther"><?php echo $delivered; ?> Lines Delivered</div>

		</div>

		<div class="DashboardTileTwo">
			<div class="DashboardGraph">
				<canvas id="AmountOfValues" style="width: 600px"></canvas>
			</div>
		</div>
		<div class="Container">
			<table>
				<tr>
					<th>Item Name</th>
					<th>Item Description</th>
					<th>Re-Order Level</th>
					<th>Current Level</th>
					<th>Value</th>
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

					   	$orangeLevel = $row["ReOrderLevel"] + ($row["ReOrderLevel"] * 0.1);
					   	$redLevel = $row["ReOrderLevel"];

					?>
					<tr onclick='location.href = "load.php?page=InventoryManagementItem.php?id=<?php echo $row['ItemID']; ?> "'>

						<td><?php echo $row["Name"];?></td>
						<td><?php echo $row["Description"];?></td>
						<td><?php echo $row["ReOrderLevel"];?></td>

						<?php
						if($row["CurrentLevel"] <= $redLevel){
							?>
							<td style="background-color: red"><?php echo $row["CurrentLevel"];?></td>
							<?php
						}
						elseif ($row["CurrentLevel"] <= $orangeLevel) {							?>
							<td style="background-color: orange"><?php echo $row["CurrentLevel"];?></td>
							<?php
						}
						else{
							?>
							<td style="background-color: green"><?php echo $row["CurrentLevel"];?></td>
							<?php
						}

						?>

						
						<td>£<?php echo number_format(($row["UnitPrice"] * $row["CurrentLevel"]), 2);?></td>


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



</body>
</html>

<?php

	$array_types = ["Delivered On Time", "Delivered Late"];
	$array_t = ["Delivered On Time"=>0, "Delivered Late"=>0];
	// echo $logged_in_company;
	$sql = "SELECT * FROM `deliveries` WHERE `CompanyID` = '$logged_in_company' AND `ActualDelivery` <= `EstimatedDelivery`";
	$q = mysqli_query($connection, $sql);
	$array_t["Delivered On Time"] = mysqli_num_rows($q);
	$sql = "SELECT * FROM `deliveries` WHERE `CompanyID` = '$logged_in_company' AND `ActualDelivery` > `EstimatedDelivery`";
	$q = mysqli_query($connection, $sql);
	$array_t["Delivered Late"] = mysqli_num_rows($q);
	$labels = array();
	$values = array();
	$total_values = array();

	foreach($array_t as $key=>$value){
		array_push($values, $value);
	}
	


?>


	<script>




new Chart(document.getElementById("AmountOfValues"),

{
"type":"pie",
"data":
	{
		"labels":<?php 	echo json_encode($array_types); ?>,
		"datasets":[
		{
			"label":"Total Quotes",
			"data":<?php echo json_encode($values); ?>,
			"fill":false,
			// "borderColor":"#0B0E75",
			"borderWidth" : 0.54,
			"backgroundColor" : ["#2ecc71", "#2980b9", "#8e44ad", "#e74c3c", "#d35400", "#f1c40f", "#1abc9c"],
			"lineTension":0.1
		}]},"options":{title : {
			display : true,
			text : "Amount of Deals"
		}}});

</script>
<style>


.DashboardTile{
	width: calc((100% / 3) - 100px);
	margin: 20px;
	background-color: white;
	padding: 30px;
	float: left;
	box-shadow: 0px 0px 5px lightgrey;
}

.DashboardTileTwo{
	width: calc((100% / 2) - 100px);
	margin: 20px;
	background-color: white;

	float: left;

	padding: 30px;
	box-shadow: 0px 0px 5px lightgrey;
}


.DashboardTileFigure{

	font-size: 40px;
	line-height: 55px

}

</style>
