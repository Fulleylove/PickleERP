<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
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
			<div style="float: left"><h2>Account Manager</h2></div>
			<div style="float: right" class="new_button" id="NewFinanceManagementAccount" onclick="location.href='load.php?page=NewFinanceManagementAccount.php'">+ Account</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Account Name</th>
					<th>Account Description</th>
					<th>Balance</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `accounts` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					?>
					<tr onclick='location.href = "load.php?page=FinanceManagementAccount.php?id=<?php echo $row['AccountID']; ?> "'>
						<td><?php echo $row["AccountName"];?></td>
						<td><?php echo $row["AccountDescription"];?></td>
						<td>£<?php echo number_format($row["Balance"], 2);?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

