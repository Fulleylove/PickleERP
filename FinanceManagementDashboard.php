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
	$page = "Your Financial Dashboard";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$CustomFurther = 0;
	$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `ReferenceType` = 'Custom'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){ $CustomFurther = $CustomFurther + $row["Amount"]; }
	$Customs = mysqli_num_rows($query);

	$PurchaseOrderFurther = 0;
	$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `ReferenceType` = 'purchaseorder'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){ $PurchaseOrderFurther = $PurchaseOrderFurther + $row["Amount"]; }
	$PurchaseOrder = mysqli_num_rows($query);

	$InvoiceFurther = 0;
	$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `ReferenceType` = 'invoice'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){ $InvoiceFurther = $InvoiceFurther + $row["Amount"]; }
	$Invoices = mysqli_num_rows($query);

	$Transactions = 3;

	?>

	<div id="display">
		
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Custom Transactions</div>
			<div class="DashboardTileFigure"><?php echo $Customs ;?></div>
			<div class="DashboardTileFurther">£<?php echo number_format($CustomFurther, 2) ;?></div>

		</div>
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Invoices</div>
			<div class="DashboardTileFigure"><?php echo $Invoices ;?></div>
			<div class="DashboardTileFurther">£<?php echo number_format($InvoiceFurther, 2) ;?></div>

		</div>
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Purhcase Orders</div>
			<div class="DashboardTileFigure"><?php echo $PurchaseOrder ;?></div>
			<div class="DashboardTileFurther">£<?php echo number_format($PurchaseOrderFurther, 2) ;?></div>

		</div>

<?php 

	$primary_sql = "SELECT * FROM `accounts` WHERE `CompanyID` = '$logged_in_company'";
	$primary_query = mysqli_query($connection, $primary_sql);
	while($primary_row = mysqli_fetch_assoc($primary_query)){
		$AccountID = $primary_row["AccountID"];
	?>
		<div class="DashboardTileTwo">
			
			<div class="DashboardGraph">
				<canvas id="<?php echo $AccountID;?>" style="width: 600px"></canvas>
			</div>
		</div>



	<?php


	if(!isset($_GET["offset"])){ $offset = 0;}
	else{ $offset = $_GET["offset"]; }




	$dates = [];
	$values = [];

	$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `AccountID` = '$AccountID' ORDER BY `PaymentID` DESC LIMIT 20 OFFSET $offset";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){
	
		if($row["ReferenceType"] == "invoice"){
			array_push($values, $row["CurrentBankBalance"] + $row["Amount"]);

		}
	
		else if($row["ReferenceType"] == "purchaseorder"){
			array_push($values, $row["CurrentBankBalance"] - $row["Amount"]);
		}

		else if($row["ReferenceType"] == "expense"){
			array_push($values, $row["CurrentBankBalance"] - $row["Amount"]);
		}
	
		else if($row["ReferenceType"] == "Custom"){
			array_push($values, $row["CurrentBankBalance"] + $row["Amount"]);
		}	
		array_push($dates, $row["DateCreated"]);	

	}
	
	?>
	<script>

new Chart(document.getElementById("<?php echo $AccountID ;?>"),

{
"type":"line",
"data":
	{
		"labels":<?php 	echo json_encode($dates); ?>,
		"datasets":[{"label":"<?php echo $primary_row['AccountName'];?>","data":<?php echo json_encode($values); ?>,"fill":false,"borderColor":"#0B0E75","lineTension":0.1}]},"options":{}});

</script>
	<?php








	}

?>





		</div>

	</div>

</body>
</html>


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
	padding: 30px;
	float: left;
	box-shadow: 0px 0px 5px lightgrey;
}


.DashboardTileFigure{

	font-size: 40px;
	line-height: 55px

}

</style>
