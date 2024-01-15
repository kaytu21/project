<?php
	require_once 'db.php';
	
	if(ISSET($_POST['update'])){
		$user_id = $_POST['id'];
		$firstname = $_POST['number'];
		
		mysqli_query($conn, "UPDATE `phonenumber` SET `number` = '$number' WHERE `id` = '$id'") or die(mysqli_error());

		header("location: phone.php");
	}
?>