<?php
	include('connectDB.php');

	$sql = "DELETE FROM book_author";
	if (mysqli_query($conn, $sql)) {
	  echo "Table book_author deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "DELETE FROM author";
	if (mysqli_query($conn, $sql)) {
	  echo "Table author deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "DELETE FROM copy";
	if (mysqli_query($conn, $sql)) {
	  echo "Table copy deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "DELETE FROM book";
	if (mysqli_query($conn, $sql)) {
	  echo "Table book deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "DELETE FROM location";
	if (mysqli_query($conn, $sql)) {
	  echo "Table location deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "DELETE FROM publisher";
	if (mysqli_query($conn, $sql)) {
	  echo "Table publisher deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}


	$sql = "DELETE FROM member";
	if (mysqli_query($conn, $sql)) {
	  echo "Table member deleted successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	mysqli_close($conn);
?>