<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "CRM Deals / Quotes";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">
				<div class="Container">
			<div style="float: left"><h2>Deals</h2></div>
			<div style="float: right" class="new_button" id="NewFinanceManagementAccount" onclick="location.href='load.php?page=NewCRManagementDeal.php'">+ Deal</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Reference</th>
					<th>Date Created</th>
					<th>Value</th>
					<th>Created By</th>
					<th>Status</th>
					<th>Lead Generator</th>
				</tr>
				<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `quote` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
			
					// $LeadID = $row["LeadGeneratorID"];

					//$secondary_sql = "SELECT * FROM `quote` WHERE `LeadGeneratorID` = '$LeadID' ";
					//$secondary_query = mysqli_query($connection, $secondary_sql);
					//$LeadTotal = mysqli_num_rows($secondary_query);
					//$LT = 0;
					//while($secondary_row = mysqli_fetch_assoc($secondary_query)){
					//	$LT = $LT + $secondary_row["Amount"];
					// }



					?>
					<tr onclick='location.href = "load.php?page=CRManagementDeal.php?id=<?php echo $row['QuoteID']; ?>"'>

					<td><?php echo $row["ReferenceType"]; ?></td>
					<td><?php echo $row["DateCreated"] ;?></td>
					<td>£<?php echo number_format($row["Amount"], 2) ;?> </td>
					<td><?php echo $row["UserID"] ;?></td>
					<td><?php echo $row["Status"] ;?></td>
					<td><?php echo $row["LeadGeneratorID"] ;?></td>

					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
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

