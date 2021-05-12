<?php	
	include('connectDB.php');
	 $sql = "ALTER table record modify column returned_by int unsigned";
	 if (mysqli_query($conn, $sql)) {
	   echo "record table ALTERed<br />";
	 } else {
	   echo "error ALTERing table record " . mysqli_error($conn) . "<br />";
	 }
	$sql = "ALTER table member modify column email varchar(60) not null unique";
	if (mysqli_query($conn, $sql)) {
	  echo "member table ALTERed<br />";
	} else {
	  echo "error ALTERing table member " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table member modify column college_id varchar(20) not null unique";
	if (mysqli_query($conn, $sql)) {
	  echo "member table ALTERed<br />";
	} else {
	  echo "error ALTERing table member " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table member modify column phone varchar(11) not null unique";
	if (mysqli_query($conn, $sql)) {
	  echo "member table ALTERed<br />";
	} else {
	  echo "error ALTERing table member " . mysqli_error($conn) . "<br />";
	}
	$sql = "update copy modify set status = 1;";
	if (mysqli_query($conn, $sql)) {
	  echo "member table ALTERed<br />";
	} else {
	  echo "error ALTERing table member " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table location modify column shelf int unsigned";
	if (mysqli_query($conn, $sql)) {
	  echo "location table ALTERed<br />";
	} else {
	  echo "error ALTERing table location " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table location modify column section int unsigned";
	if (mysqli_query($conn, $sql)) {
	  echo "location table ALTERed<br />";
	} else {
	  echo "error ALTERing table location " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table location modify column floor int unsigned";
	if (mysqli_query($conn, $sql)) {
	  echo "location table ALTERed<br />";
	} else {
	  echo "error ALTERing table location " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table publisher modify column contact_no VARCHAR(11)";
	if (mysqli_query($conn, $sql)) {
	  echo "publisher table ALTERed<br />";
	} else {
	  echo "error ALTERing table publisher " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table publisher modify column email VARCHAR(60)";
	if (mysqli_query($conn, $sql)) {
	  echo "publisher table ALTERed<br />";
	} else {
	  echo "error ALTERing table publisher " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table book modify column rating REAL ";
	if (mysqli_query($conn, $sql)) {
	  echo "book table ALTERed<br />";
	} else {
	  echo "error ALTERing table publisher " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table record modify column rating REAL ";
	if (mysqli_query($conn, $sql)) {
	  echo "record table ALTERed<br />";
	} else {
	  echo "error ALTERing table publisher " . mysqli_error($conn) . "<br />";
	}
	$sql = "ALTER table publisher modify column pname VARCHAR(50) NOT NULL";
	if (mysqli_query($conn, $sql)) {
	  echo "publisher table ALTERed<br />";
	} else {
	  echo "error ALTERing table publisher " . mysqli_error($conn) . "<br />";
	}
	mysqli_close($conn);
?>