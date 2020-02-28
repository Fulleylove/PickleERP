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
	$page = "CRM Events and Schedules";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	
	?>

	<div id="display">
		

  <div class="timeline" style="margin-left: 20px">
	<!-- <h3>client Timeline</h3> -->
    <div class="timeline__group">


    	<?php 

			$client_array = array();

			$sql = "SELECT * FROM `users` WHERE `CompanyID` = '$logged_in_company'";
			$query = mysqli_query($connection, $sql);
			while($row = mysqli_fetch_assoc($query)){

				$client_array[$row["UserID"]] = $row["Username"];
			}


    	$sql = "SELECT * FROM `postfeed` WHERE `CompanyID` = '$logged_in_company' AND `PostType` = 'schedule' ORDER BY `PostID` DESC";
    	$query = mysqli_query($connection, $sql);

    	while($post = mysqli_fetch_assoc($query)){

    		$ReferenceID = $post["ReferenceID"];
    		$type = $post["ReferenceType"];

			if($type == "client"){
				$secondary_sql = "SELECT * FROM `contacts` WHERE `CompanyID` = '$logged_in_company'";
				$namee = mysqli_query($connection, $secondary_sql);
				while($secondary_row = mysqli_fetch_assoc($namee)){
					$name = $secondary_row["ContactName"];
				}
			}
			if($type == "supplier"){
			$secondary_sql = "SELECT * FROM `contacts` WHERE `CompanyID` = '$logged_in_company'";
				$namee = mysqli_query($connection, $secondary_sql);
				while($secondary_row = mysqli_fetch_assoc($namee)){
					$name = $secondary_row["ContactName"];
				}
			}
			if($type == "employee"){
			$secondary_sql = "SELECT * FROM `employees` WHERE `CompanyID` = '$logged_in_company'";
			// echo $secondary_sql;
				$namee = mysqli_query($connection, $secondary_sql);
				while($secondary_row = mysqli_fetch_assoc($namee)){
					$name = $secondary_row["EmployeeName"];
				}
			}


    		$table = $post["PostType"];
    		$postreferenceid = $post["PostReferenceID"];
    		if($table == "schedule"){ $sql = "SELECT * FROM `schedule` WHERE `ScheduleID` = '$postreferenceid' "; }

    		$secondary_query = mysqli_query($connection, $sql);

    		while($row = mysqli_fetch_assoc($secondary_query)){
    			if($table == "schedule"){
    				$title = $client_array[$row["UserID"]] . " posted a schedule for " .  $name;
    				$body = $row["Date"] . " " . $row["Time"] . " - " . $row["Location"] . "<br>" . $row["Title"];
    			}
    			echo "<br>";
    			$month = date("M",strtotime($row["Date"]));
    			$day = date("d", strtotime($row["Date"]));

?>

      <div class="timeline__box">
        <div class="timeline__date">
          <span class="timeline__day"><?php echo $day; ?></span>
          <span class="timeline__month"><?php echo $month; ?></span>
        </div>
        <div class="timeline__post">
          <div class="timeline__content">
					<b style="color: #0B0E75;"><?php echo $title ;?></b><br>
					<span class="sub_title" style="line-height: 30px; color: grey">Created at <?php echo $row["DateCreated"]; ?></span><br>
					<span class="body"><?php echo $body; ?></span>
          </div>
        </div>
      </div>

<?php

    		}
    		


    	}

    	?>
   
    </div>
  </div>
	</div>

	</div>

</body>
</html>

