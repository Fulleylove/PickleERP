<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Delivery Report";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$id = $_GET["id"];

	?>

	<div id="display">
		
		<div class="Container">


	<!-- 			InvoiceLineID	InvoiceID	Item	Description	UnitPrice	TaxRate	AmountGBP -->


			<table>

			<tr>
					
				<th>Item Code</th>
				<th>Description</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Total</th>

			</tr>

			<?php
			
			$sql = "SELECT * FROM `purchaseorderlines` WHERE `PurchaseOrderID` = '$id' AND `Delivered` = 'False'";

			$q = mysqli_query($connection, $sql);

			while($row = mysqli_fetch_assoc($q)){

			?>

			<tr>
				<td><?php echo $row["Item"]; ?></td>
				<td><?php echo $row["Description"]; ?></td>
				<td><?php echo $row["UnitPrice"]; ?></td>
				<td><?php echo $row["Amount"]; ?></td>
				<td><?php echo $row["AmountGBP"]; ?></td>
				<td>				<form action="update.php" method="post">
				<input type="hidden" name="table_name" value="purchaseorderlines">
				<input type="hidden" name="key" value="PurchaseOrderLineID">
				<input type="hidden" name="value" value="<?php echo $_GET['id'] ;?>">
				<input type="hidden" name="page_relocate" value="load.php?page=inventorymanagementdelivery.php?id=<?php echo $_GET['id'] ;?>">
				<input type="hidden" name="Delivered" value="True"><input type="submit" value="Mark as Delivered"></form></td>
			</tr>


			<?php

			}	

			?>

			<?php
			
			$sql = "SELECT * FROM `purchaseorderlines` WHERE `PurchaseOrderID` = '$id' AND `Delivered` = 'True'";

			$q = mysqli_query($connection, $sql);

			while($row = mysqli_fetch_assoc($q)){

			?>

			<tr>
				<td><?php echo $row["Item"]; ?></td>
				<td><?php echo $row["Description"]; ?></td>
				<td><?php echo $row["UnitPrice"]; ?></td>
				<td><?php echo $row["Amount"]; ?></td>
				<td><?php echo $row["AmountGBP"]; ?></td>
				<td>Already Delivered</td>

			</tr>


			<?php

			}	

			?>




	



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

