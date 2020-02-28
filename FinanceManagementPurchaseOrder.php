<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Purchase Order";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$id = $_GET["id"];

	$sql = "SELECT * FROM `purchaseorders` WHERE `PurchaseOrderID`='$id' ";
	$q = mysqli_query($connection, $sql);

	while($row = mysqli_fetch_assoc($q)){

		$Total = $row["Total"];
		$Paid = $row["Paid"];
		$DueDate = $row["DueDate"];
		$Reference = $row["Reference"];
	}

	?>

	<div id="display">
		

		<div class="Container">

		<a href='load.php?page=FinanceManagementPurchaseOrders.php'>Go Back</a><br>
		<br>
		<div style="float: left">
		<h2>Purchase Order <?php echo $id; ?></h2>
		<h3>Reference : <?php echo $Reference ; ?></h3>
		</div>
		<div style="float: right; margin-right: 10px">
			<h4>Total : £<?php echo $Total ;?></h4>
			<h4>Paid : £<?php echo $Paid; ?> </h4>
		</div>


	<!-- 			PurchaseOrderLineID	PurchaseOrderID	Item	Description	UnitPrice	TaxRate	AmountGBP -->


			<table>

			<tr>
					
				<th>Item Code</th>
				<th>Description</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>

			</tr>

			<?php
			
			$sql = "SELECT * FROM `purchaseorderlines` WHERE `PurchaseOrderID` = '$id' ";

			$q = mysqli_query($connection, $sql);

			while($row = mysqli_fetch_assoc($q)){

			?>

			<tr>
				<td><?php echo $row["Item"]; ?></td>
				<td><?php echo $row["Description"]; ?></td>
				<td><?php echo $row["UnitPrice"]; ?></td>
				<td><?php echo $row["Amount"]; ?></td>
				<td><?php echo $row["AmountGBP"]; ?></td>
			</tr>


			<?php

			}	

			?>


		<tr>
			

			<form action="add.php" method="post">
			<input type="hidden" name="table_name" value="purchaseorderlines">
			<input type="hidden" name="PurchaseOrderID" value="<?php echo $id ;?>">
			<input type="hidden" name="page_relocate" value="load.php?page=FinanceManagementPurchaseOrder.php?id=<?php echo $id;?>">
			<td><select class="table_input" id="Item" name="Item">
				
				<?php
				$sql = "SELECT * FROM `items` WHERE `CompanyID` = '$logged_in_company'";
				$q = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($q)){
					?>
					<option value="<?php echo $row['ItemID']; ?>"><?php echo $row["ItemID"] . " - " . $row["Name"]; ?></option>
					<?php
				}
				?>

			</select></td>
			<td><input name="Description" id="Description" class="table_input"></td>
			<td><input name="UnitPrice" id="UnitPrice" class="table_input"></td>
			<td><input name="Amount" id="Amount" class="table_input" style="border-bottom: 1px solid blue" required="true"></td>
			<td><input name="AmountGBP" id="AmountGBP" class="table_input"><input type="submit" class="table_input" style="padding: 6px" value="Add"></td>
		</form>
			</tr>



		</table>
		<h3>Payments</h3>
			<table>

			<tr>
					
				<th>Date</th>
				<th>AccountID</th>
				<th>Amount</th>
				<th>Balance Remaining</th>

			</tr>

			<?php
			
			$sql = "SELECT * FROM `payments` WHERE `ReferenceType` = 'purchaseorder' AND `ReferenceID` = '$id'";

			$q = mysqli_query($connection, $sql);

			while($row = mysqli_fetch_assoc($q)){

			$AccountID = $row["AccountID"];

			$secondary_sql = "SELECT * FROM `accounts` WHERE `AccountID` = '$AccountID' ";
			$secondary_q = mysqli_query($connection, $secondary_sql);

			while ($secondary_row = mysqli_fetch_assoc($secondary_q)) {
				$AccountName = $secondary_row["AccountName"];
			}

			?>

			<tr>
				<td><?php echo $row["DateCreated"]; ?></td>
				<td><?php echo $AccountName; ?></td>
				<td><?php echo $row["Amount"]; ?></td>
				<td><?php echo $row["CurrentBalance"]  - $row["Amount"]; ?></td>
			</tr>


			<?php

			}	

			?>


		<tr>
			

			<form action="add.php" method="post">
			<input type="hidden" name="table_name" value="payments">
			<input type="hidden" name="ReferenceType" value="purchaseorder">
			<input type="hidden" name="ReferenceID" value="<?php echo $id ;?>">
			<input type="hidden" name="ApprovedBy" value="<?php echo $logged_in_user ;?>">
			<input type="hidden" name="CurrentBalance" value="<?php echo ($Total - $Paid); ?>">
			<input type="hidden" name="page_relocate" value="load.php?page=FinanceManagementPurchaseOrder.php?id=<?php echo $id;?>">
			<td><input name="DateCreated" id="DateCreated" type="date" value="date()"></td>
			<td><select class="table_input" name="AccountID">
				
				<?php
				$sql = "SELECT * FROM `accounts` WHERE `CompanyID` = '$logged_in_company'";
				$q = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($q)){

					?>
					<option value="<?php echo $row['AccountID']; ?>"><?php echo $row["AccountName"]; ?></option>
					<?php
				}
				?>

			</select></td>
			<td><input name="Amount" style="border-bottom: 1px solid blue" class="table_input"></td>
			<td><input type="submit" class="table_input" style="padding: 6px" value="Add"></td>
		</form>

			</tr>



		</table>







		</div>





	</div>

</body>

<script>

$(document).ready(function(){

	document.getElementById('DateCreated').valueAsDate = new Date();

	$("#Item").change(function(){

		selected_value = $(this).val();

		$.ajax({
			url : "GetItemDescription.php",
			type : "post",
			data : {
				id : selected_value
			},
			success : function(data){
				$("#Description").val(data);
			}
		})
		$.ajax({
			url : "GetItemPrice.php",
			type : "post",
			data : {
				id : selected_value
			},
			success : function(data){
				$("#UnitPrice").val(data);
			}
		})
	})


	$("#Amount").keypress(function(){
		setTimeout(function(){
			q = $("#Amount").val();
			p = $("#UnitPrice").val();
			$("#AmountGBP").val(q * p)
		}, 50)

	})


})


</script>

</html>

