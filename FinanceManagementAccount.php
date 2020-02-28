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
	$page = "Finance Accounts";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<a href='load.php?page=FinanceManagementAccounts.php'>Go Back</a><br><Br>
			<div style="float: left"><h2>Account Details</h2></div>
			<div style="float: right" class="new_button" id="NewPayment" onclick="location.href='load.php?page=NewPayment.php?account=<?php echo $_GET['id'];?>'">+ Transaction</div>
			<div style="clear: both"></div>

<!-- Begin Chart -->
<br>
<div style="width: 800px; height:420px; margin: auto">
<canvas id="myChart" style="width: 600px"></canvas>
</div>
<br>

<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$AccountID = $_GET["id"];


	$dates = [];
	$values = [];

	$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `AccountID` = '$AccountID' LIMIT 20 OFFSET $offset";
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

new Chart(document.getElementById("myChart"),

{
"type":"line",
"data":
	{
		"labels":<?php 	echo json_encode($dates); ?>,
		"datasets":[{"label":"Rolling Balance","data":<?php echo json_encode($values); ?>,"fill":false,"borderColor":"#0B0E75","lineTension":0.1}]},"options":{}});

</script>

<!-- End Chart -->
			<table>
				<tr>
					<th>Payment Reference</th>
					<th>Payment Amount</th>
					<th>Transaction Date</th>
					<th>Balance</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$AccountID = $_GET["id"];





				$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `AccountID` = '$AccountID' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					?>
					<tr>

						<?php

						if($row["ReferenceType"] == "invoice"){
							?>
							<td><a href='load.php?page=FinanceManagementInvoice.php?id=<?php echo $row["ReferenceID"];?>'>Invoice Identifier - <?php echo $row["ReferenceID"];?></a></td>
							<?php
						}

						if($row["ReferenceType"] == "purchaseorder"){
							?>
							<td><a href='load.php?page=FinanceManagementPurhaseOrder.php?id=<?php echo $row["ReferenceID"];?>'>Purchase Order Identifier - <?php echo $row["ReferenceID"];?></a></td>
							<?php
						}
						if($row["ReferenceType"] == "Custom"){
								?>
							<td>Custom Transaction Reference - <?php echo $row["ReferenceID"];?></td>
							<?php						
						}
						?>



						
						<td><?php echo $row["Amount"];?></td>
						<td><?php echo $row["DateCreated"]; ?></td>
						<?php 

						if($row["ReferenceType"] == "invoice"){
							?>
							<td>£<?php echo $row["CurrentBankBalance"] + $row["Amount"] ;?></td>
							<?php
						}
						else if($row["ReferenceType"] == "purchaseorder"){
							?>
							<td>£<?php echo $row["CurrentBankBalance"] - $row["Amount"] ;?></td>
							<?php
						}	
						else{
							?>
							<td>£<?php echo $row["CurrentBankBalance"] + $row["Amount"] ;?></td>
							<?php							
						}						

						?>

						
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?id=<?php echo $_GET['id']; ?>&offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
					<td></td>
					<td><a href='?id=<?php echo $_GET['id']; ?>&offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>