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
	$page = "Item Master Record";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$ItemID = $_GET["id"];
?>

	<div id="display">

		<?php


	$sql = "SELECT * FROM `stock_locations` WHERE `ItemID` = '$ItemID'  ";
	$query = mysqli_query($connection, $sql);



	while($row = mysqli_fetch_assoc($query)){

		$location = $row["LocationID"];

		$secondary_query = mysqli_query($connection, "SELECT * FROM `locations` WHERE `LocationID` = '$location' ");
		while($secondary_row = mysqli_fetch_assoc($secondary_query)){
			$location_name = $secondary_row["name"];
		}

		?>

		<div class="DashboardTile">
			<form action="move_stock.php" method="post">


			<div class="DashboardTileTitle">Location : <a href='InventoryManagementLocation.php?id=<?php echo $row["LocationID"];?>'></a><b><?php echo $location_name;?></b></div>
			<div class="DashboardTileFurther"><?php echo $row["Amount"];?> Units<br><br>Move <input min="1" max="<?php echo $row['Amount'];?>" name="Amount" type="number" class="inline" style="border: 0px;border-bottom: 1px solid blue;width: 60px"> Units<Br><br>to<input type="hidden" name="FromLocation" value="<?php echo $row['LocationID'];?>"><input type="hidden" name="StockLocationID" value="<?php echo $row['StockLocationID'];?>"><input type="hidden" name="ItemID" value="<?php echo $row['ItemID'];?>"> 	 	 				<select name="ToLocation">
					<?php
					$ssql = "SELECT * FROM `locations` WHERE `CompanyID` = '$logged_in_company'";
					$qquery = mysqli_query($connection, $ssql);
					while($rrow = mysqli_fetch_assoc($qquery)){
						?>
						<option value="<?php echo $rrow['LocationID']; ?>"><?php echo $rrow['name']; ?></option>
						<?php
					}
					?>
</select><button>Confirm</button></div>
</form>
		</div>


		<?php
	}


	?>

		</div>
		
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
