<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
	<link rel="stylesheet" type="text/css" href="CSS/timeline.css?v=1">
</head>
<body>

	<?php
	$page = "User";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$EmployeeID = $_GET["id"];
	$ReferenceType 	= 	"user";
	$ReferenceID   	= 	$_GET["id"];

	$sql = "SELECT * FROM `users` WHERE `UserID` = '$EmployeeID'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){

		// $name = $row["EmployeeName"];

	?>

	<div id="display">
		
		<div class="display_left">

			<div class="WhiteContainer">
				<form action="update.php" method="post">
				<input type="hidden" name="table_name" value="users">
				<input type="hidden" name="key" value="UserID">
				<input type="hidden" name="value" value="<?php echo $_GET['id'] ;?>">
				<input type="hidden" name="page_relocate" value="load.php?page=AdministrationUser.php?id=<?php echo $_GET['id'] ;?>">

				<h3>Change Password</h3>
				<div class="label">Password</div>
				<input name="Password" type="password" class="left_input" value="<?php echo $row['Password'];?>"><br><br>

				<input type="submit" value="Update">

					</form>
			</div>

	
		</div>
<?php

}?>
		<div class="display_right">
		
		<div class="Container">
			<table>
				<tr>
				<th>Page Name</th>
				<th>Status</th>
			</tr>
			<?php


				$sql = "SELECT * FROM `user_access` WHERE `UserID` = '$ReferenceID'";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){

					$EmployeeID = $row["PageID"];
					// echo $EmployeeID;

					$secondary_sql = "SELECT * FROM `pages` WHERE `PageID` = '$EmployeeID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$employee_name = $secondary_row["PageURL"];
					}

					?>
					<form action="update.php" method="post">

				<input type="hidden" name="table_name" value="user_access">
				<input type="hidden" name="key" value="AccessID">
				<input type="hidden" name="value" value="<?php echo $row['AccessID'] ;?>">
				<input type="hidden" name="page_relocate" value="load.php?page=AdministrationUser.php?id=<?php echo $_GET['id'] ;?>">

					<tr>
						<td><?php echo $employee_name;?></td>
						<td><select name="Access">

							<option value="<?php echo $row['Access'];?>"><?php echo $row["Access"];?></option>

							<option value="False">False</option>
							<option value="True">True</option>
							
						</select><button>Update</button></td>
					</tr>
				</form>
					<?php
				}
			?>
			</table>
		</div>

   
    </div>
  </div>
	</div>

</body>
</html>

<style>

.actionbutton{
	width: calc(100% / 7);;
	line-height: 40px;
	float: left;
	text-align: center;
}

.actionbutton:hover{
	font-weight: bold
}

.display_left{

	width: calc(30% - 20px);
	margin-left: 20px;
	float: left;

}
.display_right{

	width: calc(70% - 40px);
	margin-right: 20px;
	float: right;

}


</style>
<script>


	$(".actionbutton").click(function(){
		// ChangeAction()
		ChangeAction($(this).attr("id"))
	})

	function ChangeAction(action){

		console.log("hide");
		$(".action").hide();
		$("#a"+action).show();

	}



	ChangeAction("note");

function deleter(table, column, id){

	answer = confirm();
	if(answer == true){
		$.ajax({
			url : "Backend/delete.php",
			type : "post",
			data : { table : table, column : column, id : id},
			success : function(data){
				console.log(data); location.reload()
			}	
		});
	}

}
</script>
</script>