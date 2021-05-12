<?php 
session_start();
	$college_id = $_SESSION['college_id'];

	include('../config/connectDB.php');
	$today;
	  $sql1 = "SELECT CURRENT_DATE AS Date ";
	$result = mysqli_query($conn, $sql1);
	$inf = mysqli_fetch_assoc($result);
	$today = $inf['Date'];
	mysqli_free_result($result);

    $sql01 = "SELECT due_date from record,member where record.due_date < '$today' and record.issued_by=member.mem_id and member.college_id='$college_id'and return_date is NULL ";
    $amt =0;
    $result01 = mysqli_query($conn, $sql01);
			if(mysqli_num_rows($result01) > 0)
			{
				$finerecord = mysqli_fetch_all($result01);
				foreach($finerecord as $fine):
					$d1 = new DateTime($today);
                    $d2 = new DateTime($fine[0]);
                    $d  = $d1->diff($d2)->format('%a');

					$amt=$amt+(10*$d );
					
				endforeach;
					
          }

     $sql22 = "UPDATE member set fine_due='$amt' where college_id='$college_id' ";
	    mysqli_query($conn, $sql22);


	 $sql = "SELECT name,college_id,password,designation,phone,email,fine_due from member 
	 where college_id='$college_id' ";
	$result = mysqli_query($conn, $sql);

	$recordinfo=mysqli_fetch_row($result);
	
 ?>


<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>User Home Page</title>
		<link rel="stylesheet" type = "text/css" href="../CSS/styles.css">
		
	</head>
	<body>

<div class="background">
  <div class="blur"></div>
</div>

		<div id="wrapper">
		<nav id="main-navigation">
                <ul>
                    <li><a href = "userhomepage.php"> Back</a></li>
                    <li><a href = "ChangePassword.php">Change Password</a></li>
                </ul>    
            </nav>
		<div class = "content">
		<table>
		<tr>
			<th>NAME</th>
			<?php echo "<td>" .$recordinfo[0] ."</td>"  ?>
		 </tr>
		 <tr>	
			<th>LOGIN ID/COLLEGE ID</th>
			<?php echo "<td>". $recordinfo[1] ."</td>"  ?>
			
		</tr>
		<tr>
			<th>PASSWORD</th>
			<?php echo "<td>" .$recordinfo[2]. "</td>"  ?>
			
		</tr>
		<tr>
			<th>DESIGNATION</th>
			<?php echo "<td>". $recordinfo[3] ."</td>"  ?>
			
		</tr>
		<tr>
			<th>PHONE NO.</th>
			<?php echo "<td>" .$recordinfo[4] ."</td>"  ?>
			
		</tr>
		<tr>
			<th>EMAIL</th>
			<?php echo "<td>". $recordinfo[5] ."</td>"  ?>
		   
		</tr>
		
		<tr>
			<th> FINE DUE </th>
			<?php echo "<td>". $recordinfo[6] ."</td>"  ?>
			
		</tr>
           

			
         
         

	</table>
</div>
</div>

	</body>
	</html>