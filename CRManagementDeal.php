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
	$page = "CRM Deals and Quotes";
	include("connect.php");
	include("top_bar.php");
	include("navigation.php");	

	$ContactID = $_GET["id"];
	$ReferenceType 	= 	"quote";
	$ReferenceID   	= 	$_GET["id"];

	$sql = "SELECT * FROM `quote` WHERE `QuoteID` = '$ContactID'";
	$query = mysqli_query($connection, $sql);
	while($row = mysqli_fetch_assoc($query)){

		$name = $row["Title"];

	?>

	<div id="display">
		<div class="display_left">

			<div class="WhiteContainer">
				<form action="update.php" method="post">
				<input type="hidden" name="table_name" value="quote">
				<input type="hidden" name="key" value="QuoteID">
				<input type="hidden" name="value" value="<?php echo $_GET['id'] ;?>">
				<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id'] ;?>">

				<h3>Deal Information</h3>
				<div class="label">Deal Title</div>
				<input name="Title" type="text" class="left_input" value="<?php echo $row['Title'];?>"><br>
				<div class="label">Deal Value</div>
				<input name="Amount" type="number" class="left_input" value="<?php echo $row['Amount'];?>"><br>
				<div class="label">Deal Status</div>
				<select name="Status" class="left_input">
					<option value="<?php echo $row['Status'];?>"><?php echo $row['Status'];?></option>
					<option value="New">New</option>
					<option value="Stage 1">Stage 1</option>
					<option value="Stage 2">Stage 2</option>
					<option value="Stage 3">Stage 3</option>
					<otpion value="Deal">Deal</otpion>
					<option value="No Deal">No Deal</option>
				</option>

					
				</select><br>
				<br><input type="submit" value="Update">

		</form>
			</div>

		</div>
<?php

}?>
		<div class="display_right">
			
			<div class="WhiteContainer">
		<div id="actiondraw">
				<div id="note" class="actionbutton">Note</div>
				<div id="email" class="actionbutton">Email</div>
				<div id="call" class="actionbutton">Call</div>
				<div id="task" class="actionbutton">Task</div>
				<div id="schedule" class="actionbutton">Schedule</div>
				<div id="file" class="actionbutton">File</div>
				<!-- <div id="quote" class="actionbutton">Quote</div> -->
				<div style="clear: both"></div>
			</div>


		<div class="action" id="anote">
			<form autocomplete="off" action="add.php" method="post">
			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="notes">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">
			<textarea class="whole_input" name="NoteContent" placeholder="Leave a note here"></textarea>
			<input class="whole_input"   type="submit">
			</form>
		</div>
		<div class="action" id="aemail">
			<form autocomplete="off" action="add.php" method="post">
			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="send_emails">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">
			<input class="whole_input"   name="EmailRecipient" placeholder="Email Recipient"><br>
			<!-- <input class="whole_input"   name="cc" placeholder="CC"><br> -->
			<input class="whole_input"   name="EmailSubject" placeholder="Subject"><br>
			<textarea class="whole_input"  name="EmailContent" placeholder="Email Body"></textarea>
			<input class="whole_input"   type="submit">
			</form>
		</div>

		<div class="action" id="acall">
			<form autocomplete="off" action="add.php" method="post">
			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="calls">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">

			<textarea class="whole_input"  name="CallContent" placeholder="What happened in the call ?"></textarea>
			<input class="whole_input"   type="submit">
			</form>
		</div>
		<div class="action" id="atask">

			<form autocomplete="off" action="add.php" method="post">
			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="tasks">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">
			<input type="hidden" name="Status" value="New">

			<textarea class="whole_input"  name="TaskContent" placeholder="Add a task or to-do list item"></textarea>
			<input class="whole_input"   type="submit">
			</form>
		</div>
		<div class="action" id="aschedule">
			<form autocomplete="off" action="add.php" method="post">
			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="schedule">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">
				<input class="whole_input"   type="date" name="Date">
				<input class="whole_input"   type="time" name="Time">
				<input class="whole_input"   type="text" name="Location" placeholder="Location">
				<input class="whole_input"   type="text" name="Title" placeholder="Title of scheduled event">
			<input class="whole_input"   type="submit">
			</form>
		</div>
		<div class="action" id="afile">
			<form autocomplete="off" action="addFile.php" enctype="multipart/form-data" method="post">

			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="schedule">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">

				<input class="whole_input"   type="file" name="FileName">
				<input class="whole_input"   type="text" name="FileDescription" placeholder="File Name / Description">
			<input class="whole_input"   type="submit">
			</form>
		</div>
		<div class="action" id="aquote">
			<form autocomplete="off" action="add.php" method="post">
			<input type="hidden" name="page_relocate" value="load.php?page=CRManagementDeal.php?id=<?php echo $_GET['id']; ?>">
			<input type="hidden" name="UserID" value="<?php echo $logged_in_user ; ?>">
			<input type="hidden" name="DateCreated" value="<?php echo $long_date;?>">
			<input class="whole_input"   type="hidden" name="table_name" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceType" value="quote">
			<input class="whole_input"   type="hidden" name="ReferenceID" value="<?php echo $_GET['id']; ?>">
				<input class="whole_input"   type="text" name="Title" placeholder="What's it for ?">
				<input class="whole_input"   type="text" name="Amount" placeholder="Amount (£)">
				<input type="hidden" name="Status" value="New">
			<input class="whole_input"   type="submit">
			</form>
		</div>
		<?php



			$quote_array = array();

			$sql = "SELECT * FROM `users` WHERE `UserID` = '$ReferenceID'";
			$query = mysqli_query($connection, $sql);
			while($row = mysqli_fetch_assoc($query)){

				$quote_array[$row["UserID"]] = $row["Username"];
			}

		?>

			</div>
			<!-- Tasks -->
			<div class="WhiteContainer">
				<h3>Tasks to complete</h3>
			

				<table style="border: 0px">

			<?php

			$sql = "SELECT * FROM `tasks` WHERE `ReferenceType` = '$ReferenceType' AND `ReferenceID` = '$ReferenceID' AND `Status` <> 'Complete'";
			// echo $sql;
			$query = mysqli_query($connection, $sql);
			while($row = mysqli_fetch_assoc($query)){
				?>
				<form action="update.php" method="post">

				<input type="hidden" name="table_name" value="tasks">
				<input type="hidden" name="key" value="TaskID">
				<input type="hidden" name="value" value="<?php echo $row['TaskID'] ;?>">
				<input type="hidden" name="Status" value="Complete">

				<tr>
					<td style="width: 75%"><?php echo $row["TaskContent"]; ?></td>
					<td><input type="submit" class="table_input" value="Complete"></td>
				</tr>
				</form>
				<?php
			}
			?>

				</table>
			</div>




  <div class="timeline" style="margin-left: 20px">
	<!-- <h3>quote Timeline</h3> -->
    <div class="timeline__group">


    	<?php 

    	$sql = "SELECT * FROM `postfeed` WHERE `ReferenceType` = '$ReferenceType' AND `ReferenceID` = '$ReferenceID' ORDER BY `PostID` DESC";
    	$query = mysqli_query($connection, $sql);

    	while($post = mysqli_fetch_assoc($query)){

    		$table = $post["PostType"];
    		$postreferenceid = $post["PostReferenceID"];

    		if($table == "notes"){ $sql = "SELECT * FROM `notes` WHERE `NoteID` = '$postreferenceid' "; }
    		if($table == "calls"){ $sql = "SELECT * FROM `calls` WHERE `CallID` = '$postreferenceid' "; }
    		if($table == "send_emails"){ $sql = "SELECT * FROM `send_emails` WHERE `EmailID` = '$postreferenceid' "; }
    		if($table == "tasks"){ $sql = "SELECT * FROM `tasks` WHERE `TaskID` = '$postreferenceid' "; }
    		if($table == "schedule"){ $sql = "SELECT * FROM `schedule` WHERE `ScheduleID` = '$postreferenceid' "; }
    		if($table == "files"){ $sql = "SELECT * FROM `files` WHERE `FileID` = '$postreferenceid' "; }
    		if($table == "quote"){ $sql = "SELECT * FROM `quote` WHERE `QuoteID` = '$postreferenceid' "; }

    		$secondary_query = mysqli_query($connection, $sql);



    		while($row = mysqli_fetch_assoc($secondary_query)){

    			if($table == "notes"){
    				$title = $quote_array[$row["UserID"]] . " posted a note for " .  $name;
    				$body = $row["NoteContent"];
    			}
    			if($table == "files"){
    				$title = $quote_array[$row["UserID"]] . " uploaded a file for " .  $name;
    				$body = "<a href='" . $row["FileName"] . "'> Click to download " .  $row["FileDescription"] . "</a>";
    			}
    			if($table == "calls"){
    				$title = $quote_array[$row["UserID"]] . " posted a call log for " .  $name;
    				$body = $row["CallContent"];
    			}
    			if($table == "send_emails"){
    				$title = $quote_array[$row["UserID"]] . " sent an for " .  $name;
    				$body = "To : " . $row["EmailRecipient"] . "<br>Subject : " . $row["EmailSubject"] . "<br>" . $row["EmailContent"];
    			}
    			if($table == "tasks"){
    				$title = $quote_array[$row["UserID"]] . " posted a Task for " .  $name;
    				$body = $row["TaskContent"];
    			}
    			if($table == "schedule"){
    				$title = $quote_array[$row["UserID"]] . " posted a schedule for " .  $name;
    				$body = $row["Date"] . " " . $row["Time"] . " - " . $row["Location"] . "<br>" . $row["Title"];
    			}
    			if($table == "quote"){
    				$title = $quote_array[$row["UserID"]] . " posted a quote for " .  $name;
    				$body = "<a href='load.php?page=quote.php?id=" . $row["QuoteID"] . "'>Click to see more about : " . $row["Title"] . "</a>";
    			}
    			echo "<br>";
    			$month = date("M",strtotime($row["DateCreated"]));
    			$day = date("d", strtotime($row["DateCreated"]));
    			// echo $date;
    			// print_r($row);

?>

      <div class="timeline__box">
        <div class="timeline__date">
          <span class="timeline__day"><?php echo $day; ?></span>
          <span class="timeline__month"><?php echo $month; ?></span>
        </div>
        <div class="timeline__post">
          <div class="timeline__content">
					<b style="color: #0B0E75;"><?php echo $title ;?></b><br>
					<span class="sub_title" style="line-height: 30px; color: grey"><?php echo $row["DateCreated"]; ?></span><br>
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