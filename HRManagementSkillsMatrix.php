<!DOCTYPE html>
<html>
<head>
	<title>Pickle ERP</title>
	<script src="Javascript/JQuery.js"></script>
	<link rel="stylesheet" type="text/css" href="CSS/index.css?v=1">
</head>
<body>

	<?php
	$page = "Company Skills Matrix";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">

<div class="Container">
			<form action="AddSkill.php" method="get" style="float: left; margin-left: 10px">
				<input type="submit" value="Add Skill">
			</form>
			<form action="AddEmployeeSkill.php" method="get"  style="float: left; margin-left: 10px">
				<input type="submit" value="Add Employee Skill">
			</form>
		</div>
		<br>

		
		<div id="SkillsMatrixHolder">

			<div id="SkillsMatrix">

				<div class="all_titles">
				<div class="title_box">Skill / Employee</div>
				<?php

				$skill_array = array();

				$sql = "SELECT * FROM `company_skills` WHERE `CompanyID` = '$logged_in_company' ";
				$query = mysqli_query($connection, $sql);
				while($skill = mysqli_fetch_assoc($query)){
					echo "<div class='title_box'>" . $skill["SkillName"] . "</div>";
				}
				?>
			</div>

			<style type="text/css">
				
				.all_titles{
					float:left;
				}

			</style>
			<div style="float: left">
			<div class="title_row">
				<?php

				$skill_array = array();

				$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company' ";
				$query = mysqli_query($connection, $sql);
				while($skill = mysqli_fetch_assoc($query)){
					echo "<div class='title_box' style='float: left'>" . $skill["EmployeeName"] . "</div>";
				}
				?>
			</div>

				<?php


				$sql = "SELECT * FROM `company_skills` WHERE `CompanyID` = '$logged_in_company' ";
				$query = mysqli_query($connection, $sql);
				while($skill = mysqli_fetch_assoc($query)){

					$SkillID = $skill["CompanySkillID"];

					// array_push($skill_array, array($skill["CompanySkillID"], $skill["SkillName"]));
					
					$secondary_sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
					$secondary_query = mysqli_query($connection, $secondary_sql);


						?>

						<div class="row">
							<div style="clear: both"></div>
						<?php

					while($employee = mysqli_fetch_assoc($secondary_query)){
						$selected_employee_id = $employee["EmployeeID"];


						$third_sql = "SELECT * FROM `skills` WHERE `Skill` = '$SkillID' AND `EmployeeID` = '$selected_employee_id'";
						$third_query = mysqli_query($connection, $third_sql);
						if(mysqli_num_rows($third_query) != 0){
							while($s = mysqli_fetch_assoc($third_query)){
								echo "<div class='box'>" . $s["Expiry"] . "</div>";
							}
						}
						else{
							echo "<div class='empty_box'></div>";
						}
					}

											?>

					</div>

						<?php


				}

				// print_r($skill_array);




				?>


			</div>
			
		</div>


		<style>
			.row{

			}
			.empty_box{
				width: 140px;
				line-height: 40px;
				text-align: center;
				font-size: 11px;
				border: 1px solid lightgrey;
				float: left;
				height: 40px;
			}
			.box{
				width: 140px;
				line-height: 40px;
				text-align: center;
				font-size: 11px;
				border: 1px solid lightgrey;
				float: left;
				height: 40px;
				background-color: lightgreen
			}

			.title_box{
				width: 140px;
				line-height: 40px;
				text-align: center;
				font-size: 11px;
				border: 1px solid lightgrey;
				font-weight: bold;				/*float: left;*/
				height: 40px;
				/*background-color: lightgreen*/
			}
			#SkillsMatrixHolder{
				width: calc(100% - 40px);
				margin: 20px;
				height: auto;
				overflow:scroll;
				background-color: white;
			}
			#SkillsMatrix{
				width: 3000px;
				height: auto;
				background-color: white;

			}
		</style>


	</div>

</body>
</html>

