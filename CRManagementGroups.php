<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "CRM Groups";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

		<div class="Container">
			<div style="float: left"><h2>Client Manager</h2></div>
			<div style="float: right" class="new_button" id="NewCRManagementGroup" onclick="location.href='load.php?page=NewCRManagementGroup.php'">+ Group</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Group ID</th>
					<th>Group Name</th>
					<th># Of Members</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `groups` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

						$GroupID = $row["GroupID"];

					   	$secondary_sql = "SELECT * FROM `group_members` WHERE `GroupID` = '$GroupID'";
					   	$member_of = mysqli_query($connection, $secondary_sql);
					   	$member_of = mysqli_num_rows($member_of);


					?>
					<tr onclick='location.href = "load.php?page=CRManagementGroup.php?id=<?php echo $row['GroupID']; ?> "'>
						<td><?php echo $row["GroupID"];?></td>
						<td><?php echo $row["GroupName"];?></td> 
						<td style="width: 20%"><?php echo $member_of;?> Members</td>
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

