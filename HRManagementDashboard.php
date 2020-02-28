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
	$page = "Your HR Dashboard";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$sql = "SELECT * FROM `departments` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$departments = mysqli_num_rows($query);

	$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$employees = mysqli_num_rows($query);

	$sql = "SELECT * FROM `vacancies` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	$vacancies = mysqli_num_rows($query);

	$monthly_total = 0;
	$yearly_total = 0;
	$sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){
		$yearly_total = $yearly_total + $row["EmployeeWage"];
	}



	$yearly_total = round($yearly_total);
	// $yearly_total = round($yearly_total, 2);
	$monthly_total = number_format(($yearly_total / 12), 2); 


	$Transactions = 3;

	?>

	<div id="display">
		
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Employees</div>
			<div class="DashboardTileFigure"><?php echo $employees ;?></div>
			<div class="DashboardTileFurther"><?php echo ($departments) ;?> Departments</div>

		</div>
	
		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Monthly Payroll</div>
			<div class="DashboardTileFigure">£<?php echo $monthly_total ;?></div>
			<div class="DashboardTileFurther">Yearly Total : £<?php echo $yearly_total ;?></div>

		</div>

 		<div class="DashboardTile">
			
			<div class="DashboardTileTitle">Total Vacancies</div>
			<div class="DashboardTileFigure"><?php echo $vacancies ;?></div>
			<div class="DashboardTileFurther">-</div>

		</div>

		<div class="Container">
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        
        // data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows([

        <?php

            $result = mysqli_query($connection, "SELECT * FROM employees WHERE `CompanyID` = '$logged_in_company' AND `EmployeeManager` IS NULL");
            while($row = mysqli_fetch_assoc($result)){
            	$t = array("v" => $row["EmployeeID"], "f" => $row["EmployeeName"]);
            	echo json_encode([$t, ""]) . ",";
            }
  			
        ?>


			<?php

function display_children($connection, $category_id, $level, $logged_in_company) 
{

	$count = 0;
    // retrieve all children
    $result = mysqli_query($connection, "SELECT * FROM employees WHERE `CompanyID` = '$logged_in_company' AND `EmployeeManager`='$category_id'");
  
    // display each child


    while ($row = mysqli_fetch_array($result)) 
    {

    	$t = array("v" => $row["EmployeeID"], "f" => "<div>" . $row["EmployeeName"] . " <Br><Br><i>" . $row["EmployeePosition"] . "</i></div>");

    	echo json_encode([$t, $row["EmployeeManager"]]) . ",";
       	// echo $row[""];
       	display_children($connection, $row['EmployeeID'], $level+1, $logged_in_company);
    }

}

display_children($connection, 1, 1, $logged_in_company);
?>
        ]);

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // data.setRowProperty(0, 'style', 'border: 1px solid green');
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        // data.setRowProperty(2,"border", "0px");
        chart.draw(data, {'allowHtml':true, "size" : "medium"});
      }
   </script>
    </head>
    <div id="chart_div" ></div>

<style>

#chart_div{
	background-color: #e9ebee;
}

#chart_div tr, #chart_div th{

background-color: #e9ebee;
border: 0px;
}

#chart_div td{
	border: 0px
}

#chart_div .google-visualization-orgchart-linebottom {
  border-bottom: 2px solid #0B0E75;
}

#chart_div .google-visualization-orgchart-lineleft {
  border-left: 2px solid #0B0E75;
}

#chart_div .google-visualization-orgchart-lineright {
  border-right: 2px solid #0B0E75;
}

#chart_div .google-visualization-orgchart-linetop {
  border-top: 2px solid #0B0E75;
}



</style>






		</div>


	<table style="width: calc(100% - 40px); margin: 20px">
				<tr>
					<th>Vacation ID</th>
					<th>Employee</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
			<?php

				if(!isset($_GET["offset"])){ $offset = 0;}
				else{ $offset = $_GET["offset"]; }

				$sql = "SELECT * FROM `vacation` WHERE `CompanyID` = '$logged_in_company' LIMIT 20 OFFSET $offset";
				$query = mysqli_query($connection, $sql);
				while($row = mysqli_fetch_assoc($query)){
					$EmployeeID = $row["EmployeeID"];
					$employee_name = "";
					$secondary_sql = "SELECT * FROM `employees` WHERE `EmployeeID` = '$EmployeeID'";
					$secondary_query = mysqli_query($connection, $secondary_sql);
					while($secondary_row = mysqli_fetch_assoc($secondary_query)){
						$employee_name = $secondary_row["EmployeeName"];
					}

					?>
					<tr onclick='location.href = "load.php?page=HRManagementVacantion.php?id=<?php echo $row['EmployeeID']; ?> "'>
						<td><?php echo $row["VacationID"];?></td>
						<td><?php echo $employee_name;?></td>
						<td><?php echo $row["StartDate"] ;?></td>
						<td><?php echo $row["EndDate"]; ?></td>
					</tr>
					<?php
				}
			?>
				<tr>
					<td><a href='?offset=<?php echo $offset - 20;?>'>Previous 20</a></td>
					<td></td>
					<td></td>
					<td><a href='?offset=<?php echo $offset + 20;?>'>Next 20</a></td>
				</tr>

			</table>





		</div>

	</div>

</body>
</html>


<style>


.DashboardTile{
	width: calc((100% / 3) - 100px);
	margin: 20px;
	background-color: white;
	padding: 30px;
	float: left;
	box-shadow: 0px 0px 5px lightgrey;
}

.DashboardTileTwo{
	width: calc((100% / 2) - 100px);
	margin: 20px;
	background-color: white;
	padding: 30px;
	float: left;
	box-shadow: 0px 0px 5px lightgrey;
}


.DashboardTileFigure{

	font-size: 40px;
	line-height: 55px

}

</style>
