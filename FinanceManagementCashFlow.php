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
	$page = "Cash Flow";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<a href='load.php?page=FinanceManagementAccounts.php'>Go Back</a><br><Br>
			<div style="float: left"><h2>Cashflow All Accounts</h2></div>
			<div style="float: right">
				<form action="" method="get">
				Start Date : <input name="DateStart" type="date" style="margin-right: 10px">End Date : <input  type="date"  name="DateEnd"><button>Update</button>
				</form>
			</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Payment Reference</th>
					<th>Payment Amount</th>
					<th>Transaction Date</th>
					<th>Account</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				if(!isset($_GET["DateStart"])){ $DateStart = date("Y-m-01");}
				else{ $DateStart = $_GET["DateStart"]; }

				if(!isset($_GET["DateEnd"])){ $DateEnd = date("Y-m-d");}
				else{ $DateEnd = $_GET["DateEnd"]; }


				$sql = "SELECT * FROM `payments` WHERE `CompanyID` = '$logged_in_company' AND `DateCreated` >= '$DateStart' and `DateCreated` <= '$DateEnd'";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					$AccountID = $row["AccountID"];

					$secondary_sql = "SELECT * FROM `accounts` WHERE `AccountID` = '$AccountID' ";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$AccountName = $secondary_row["AccountName"];
					}
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
						if($row["ReferenceType"] == "expense"){
								?>
							<td>Expense Reference - <?php echo $row["ReferenceID"];?></td>
							<?php							
					}
						?>						
						<td><?php echo $row["Amount"];?></td>
						<td><?php echo $row["DateCreated"]; ?></td>
						<td><?php echo $AccountName; ?></td>
						
					</tr>
					<?php
				}
				?>


			</table>

		</div>
	</div>

</body>
</html>