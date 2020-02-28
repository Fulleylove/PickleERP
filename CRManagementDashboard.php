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
	$page = "CRM Dashboard";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$sql = "SELECT * FROM `groups` WHERE `CompanyID` = '$logged_in_company'  ";
	$query = mysqli_query($connection, $sql);
	$groups = mysqli_num_rows($query);

	$sql = "SELECT * FROM `contacts` WHERE `CompanyID` = '$logged_in_company' AND `ContactType` = 'client' ";
	$query = mysqli_query($connection, $sql);
	$employees = mysqli_num_rows($query);

	$sql = "SELECT * FROM `vacancies` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$vacancies = mysqli_num_rows($query);


	if(!isset($_GET["DateStart"])){ $DateStart = date("Y-m-01");}

	$sql = "SELECT * FROM `schedule` WHERE `CompanyID` = '$logged_in_company' AND `Date` >= '$DateStart'";
	$query = mysqli_query($connection, $sql);
	$events = mysqli_num_rows($query);


	$sql = "SELECT * FROM `schedule` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$allevents = mysqli_num_rows($query);


	$sql = "SELECT * FROM `quote` WHERE `CompanyID` = '$logged_in_company' AND `Status` != 'New'";
	$query = mysqli_query($connection, $sql);
	$quotes = mysqli_num_rows($query);

	$sql = "SELECT * FROM `quote` WHERE `CompanyID` = '$logged_in_company' AND `Status` != 'New'";
	$query = mysqli_query($connection, $sql);
	$quotes = mysqli_num_rows($query);
	
	$total = 0;
	while($row = mysqli_fetch_assoc($query)){	
	$total = $total + $row["Amount"];
	}


	?>

	<div id="display">
		
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Clients</div>
			<div class="DashboardTileFigure"><?php echo $employees ;?></div>
			<div class="DashboardTileFurther">Accross <?php echo $groups ;?> Groups</div>

		</div>
	
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Upcoming Events</div>
			<div class="DashboardTileFigure"><?php echo $events ;?></div>
			<div class="DashboardTileFurther">All Events : <?php echo $allevents; ?></div>

		</div>

 		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Vacancies</div>
			<div class="DashboardTileFigure"><?php echo $quotes ;?></div>
			<div class="DashboardTileFurther">£<?php echo number_format($total,2 ); ?></div>

		</div>

		<div class="DashboardTileTwo">
			<div class="DashboardGraph">
				<canvas id="AmountOfValues" style="width: 600px"></canvas>
			</div>
		</div>
		<div class="DashboardTileTwo">
			<div class="DashboardGraph">
				<canvas id="AmountOfTotal" style="width: 600px"></canvas>
			</div>
		</div>

</body>
</html>

<?php

	$array_types = ["New", "Stage 1", "Stage 2", "Stage 3", "Stage 4", "Deal", "No Deal"];
	$array_t = ["New"=>0, "Stage 1"=>0, "Stage 2"=>0, "Stage 3"=>0, "Stage 4"=>0, "Deal"=>0, "No Deal"=>0];
	$array_total = ["New"=>0, "Stage 1"=>0, "Stage 2"=>0, "Stage 3"=>0, "Stage 4"=>0, "Deal"=>0, "No Deal"=>0];
	foreach($array_types as $key=>$type){
		$sql = "SELECT * FROM `quote` WHERE `CompanyID` = '$logged_in_company' AND `Status` = '$type'";
		$q = mysqli_query($connection, $sql);
		while($row = mysqli_fetch_assoc($q)){
			$array_t[$row["Status"]] = $array_t[$row["Status"]] + 1;
			$array_total[$row["Status"]] = $array_total[$row["Status"]] + $row["Amount"];
		}
	}

	$labels = array();
	$values = array();
	$total_values = array();

	foreach($array_t as $key=>$value){
		array_push($values, $value);
	}
	foreach($array_total as $key=>$value){
		array_push($total_values, $value);
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


new Chart(document.getElementById("AmountOfTotal"),

{
"type":"pie",
"data":
	{
		"labels":<?php 	echo json_encode($array_types); ?>,
		"datasets":[
		{
			"label":"Total Quotes",
			"data":<?php echo json_encode($total_values); ?>,
			"fill":false,
			// "borderColor":"#0B0E75",
			"borderWidth" : 0.54,
			"backgroundColor" : ["#2ecc71", "#2980b9", "#8e44ad", "#e74c3c", "#d35400", "#f1c40f", "#1abc9c"],
			"lineTension":0.1
		}]},"options":{title : {
			display : true,
			text : "Value of Deals"
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
