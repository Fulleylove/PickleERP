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


	?>

	<div id="display">

		<div class="Container" style="height: 30px"><h2>Welcome to your Dashboard !</h2></div>


<?php	
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
			<div class="DashboardTileFurther">-</div>

		</div>


<?php
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
	<?php

	$sql = "SELECT * FROM `departments` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$departments = mysqli_num_rows($query);

	$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$employees = mysqli_num_rows($query);

	$sql = "SELECT * FROM `vacancies` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$vacancies = mysqli_num_rows($query);

	$monthly_total = 0;
	$yearly_total = 0;
	$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){
		$yearly_total = $yearly_total + $row["EmployeeWage"];
	}



	$yearly_total = round($yearly_total);
	// $yearly_total = round($yearly_total, 2);
	$monthly_total = number_format(($yearly_total / 12), 2); 


	$Transactions = 3;

	?>
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Employees</div>
			<div class="DashboardTileFigure"><?php echo $employees ;?></div>
			<div class="DashboardTileFurther"><?php echo ($departments) ;?> Departments</div>

		</div>
	
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Monthly Payroll</div>
			<div class="DashboardTileFigure">£<?php echo $monthly_total ;?></div>
			<div class="DashboardTileFurther">Yearly Total : £<?php echo $yearly_total ;?></div>

		</div>

 		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Vacancies</div>
			<div class="DashboardTileFigure"><?php echo $vacancies ;?></div>
			<div class="DashboardTileFurther">-</div>

		</div>





		<?php

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









	</div>

</body>
</html>

