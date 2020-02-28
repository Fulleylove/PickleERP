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
			<div style="float: left"><h2>Client Manager</h2></div>
			<div style="float: right" class="new_button" id="NewCRManagementClient" onclick="location.href='load.php?page=NewCRManagementClient.php?type=client'">+ Client</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Client ID</th>
					<th>Client Name</th>
					<th>Groups</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `contacts` WHERE `CompanyID` = '$logged_in_company' AND `ContactType` = 'client' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

						$ContactID = $row["ContactID"];

					   	$secondary_sql = "SELECT * FROM `group_members` WHERE `MemberType` = 'client' AND `MemberTypeID` = '$ContactID'";
					   	$member_of = mysqli_query($connection, $secondary_sql);
					   	$member_of = mysqli_num_rows($member_of);


					?>
					<tr onclick='location.href = "load.php?page=CRManagementClient.php?id=<?php echo $row['ContactID']; ?> "'>
						<td><?php echo $row["ContactID"];?></td>
						<td><?php echo $row["ContactName"];?></td> 
						<td style="width: 20%">Member of <?php echo $member_of;?> groups</td>
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

