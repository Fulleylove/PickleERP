<?php

	include("connect.php");

	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["FileName"]["name"]);

	$ta = $_FILES["FileName"]["tmp_name"];
	echo $ta;
	$uploadOk = 1;


    $ReferenceType = $_POST["ReferenceType"];
    $ReferenceID = $_POST["ReferenceID"];
    $FileDescription = $_POST["FileDescription"];

    $sql = "INSERT INTO `files` (`CompanyID`,`ReferenceType`,`ReferenceID`,`DateCreated`,`UserID`,`FileName`,`FileDescription`, `FileSize`) VALUES ('$logged_in_company', '$ReferenceType', '$ReferenceID', '$long_date', '$logged_in_user', '$file_name', '$FileDescription', '0')";
    $query = mysqli_query($connection, $sql);

    echo mysqli_error($connection);

    $number = mysqli_insert_id($connection);

		$PostReferenceID = mysqli_insert_id($connection);
		$PostType = "files";
		$ReferenceType = $_POST["ReferenceType"];
		$ReferenceID = $_POST["ReferenceID"];


		$sql = "INSERT INTO `postfeed` (`PostReferenceID`, `PostType`, `ReferenceType`, `ReferenceID`) VALUES ('$PostReferenceID','$PostType','$ReferenceType', '$ReferenceID')";
		$query = mysqli_query($connection, $sql);


	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["FileName"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["FileName"]["size"] > 50000000) {
	    header("location:toobig.php?page=" . $_SERVER["HTTP_REFERRER"]);
	    $uploadOk = 0;
	}

    $file_name = "uploads/" . time() . "-" . $number.  ".". $imageFileType;
    // define ('SITE_ROOT', realpath(dirname(__FILE__)));
    // $file_name =  "" . $file_name . "" . $long_date . "." . $imageFileType;
    // $file_name = mysqli_real_escape_string($connection, $file_name);
    // echo $file_name;


    if (move_uploaded_file($ta, $file_name)) {
        echo "The file ". basename( $_FILES["FileName"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }


    $sql = "UPDATE `files` SET `FileName` = '$file_name' WHERE `FileID`='$number' ";
    $query = mysqli_query($connection, $sql);

    echo mysqli_error($connection);


    header("location:" . $_POST["page_relocate"]);



?>