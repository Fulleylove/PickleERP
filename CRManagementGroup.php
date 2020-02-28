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
			<div style="float: left"><h2>Group Manager</h2></div>
			<div style="float: right;" class="new_button" id="NewCRManagementGroupMember" onclick="location.href='load.php?page=NewCRManagementGroupMember.php?id=<?php echo $_GET["id"];?>-type=client'">+ Client</div>
			<div style="float: right;margin-right: 10px" class="new_button" id="NewCRManagementGroupMember" onclick="location.href='load.php?page=NewCRManagementGroupMember.php?id=<?php echo $_GET["id"];?>-type=employee'">+ Employee</div>
			<div style="float: right; margin-right: 10px" class="new_button" id="NewCRManagementGroupMember" onclick="location.href='load.php?page=NewCRManagementGroupMember.php?id=<?php echo $_GET["id"];?>-type=supplier'">+ Supplier</div>
			<div style="clear: both"></div>

			<table>
				<tr>
					<th>Member Type</th>
					<th>Member Name</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$GroupID = $_GET["id"];

				$sql = "SELECT * FROM `group_members` WHERE `GroupID` = '$GroupID'";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

						$MemberType = $row["MemberType"];
						$MemberTypeID = $row["MemberTypeID"];

						if($MemberType == "client"){
							$secondary_sql = "SELECT * FROM `contacts` WHERE `ContactID` = '$MemberTypeID'";
							$namee = mysqli_query($connection, $secondary_sql);
							while($secondary_row = mysqli_fetch_assoc($namee)){
								$name = $secondary_row["ContactName"];
							}
						}
						if($MemberType == "supplier"){
						$secondary_sql = "SELECT * FROM `contacts` WHERE `ContactID` = '$MemberTypeID'";
							$namee = mysqli_query($connection, $secondary_sql);
							while($secondary_row = mysqli_fetch_assoc($namee)){
								$name = $secondary_row["ContactName"];
							}
						}
						if($MemberType == "employee"){
						$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$MemberTypeID'";
							$namee = mysqli_query($connection, $secondary_sql);
							while($secondary_row = mysqli_fetch_assoc($namee)){
								$name =  $secondary_row["EmployeeName"];
							}
						}
					   	


					?>
					<tr onclick='location.href = "load.php?page=CRManagementGroup.php?id=<?php echo $row['GroupID']; ?> "'>
						<td><?php echo $MemberType; ?></td>
						<td><?php echo $name;?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>

		</div>
	</div>

</body>
</html>

