 <?php  
	session_start();
	$college_id = $_SESSION['college_id'];

	include('../config/connectDB.php');

	$flipped_get = array_flip($_GET);
	if(isset($flipped_get['Review & Rate']))
	{
		$_SESSION['accession_id'] = $flipped_get['Review & Rate'];
		header('Location: BookReview.php'); 
	}
	$availablerecord = true;
    $sql = "SELECT r.accession_id,b.name,r.issue_date,r.due_date,COALESCE(r.return_date,'not returned')  FROM member m,record r,book b,copy c where 
    r.gr_no=c.gr_no and  r.copy_no=c.copy_no  and b.gr_no=c.gr_no and r.issued_by=m.mem_id and m.college_id='$college_id' order by r.return_date,r.due_date desc ";
	$result = mysqli_query($conn, $sql);

	
	if(mysqli_num_rows($result) > 0)
	{
		$recordinfo = mysqli_fetch_all($result);
	}
	else
	{
		$availablerecord = false;
	}
	mysqli_free_result($result);
	if($college_id==NULL)
	{
		session_destroy();
		header('Location: ../index.php');
	}
 ?>


 <!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Book Search Page</title>
		<link rel="stylesheet"  href="../CSS/styles.css">
	</head>
	<body>
		<nav id="main-navigation">
                <ul>
                	<li><a href = "Myprofile.php" >My profile</a> </li>
                    <li><a href = "userhomepage.php"> Back</a></li>

                </ul>
                </nav> 
 
 <form>
 <table border = "1" class = "tables">
 	
 	<tr>
 		<th>accession id</th>
 	<th> Book Name </th>
 	<th> Date of issue</th>
 	<th> Due Date</th>
 	<th> Return Date</th>
 </tr>
 <?php 
     
					
					if($availablerecord):
						foreach( $recordinfo as $recordrow):
				?>
						<tr>
				<?php
						echo "<td>". $recordrow[0]."</td>";
						echo "<td>". $recordrow[1] ."</td>";
						echo "<td>". $recordrow[2] ."</td>";
						echo "<td>". $recordrow[3]." </td>";
						echo "<td>". $recordrow[4]." </td>";
				?>
						<td>
							<input type="submit" name="<?php echo $recordrow[0]?>" value = "Review & Rate">
						</td>

						

						</tr>
				<?php
						endforeach;
						else:
							echo " <tr><td colspan=\"5\">nothing to show as ".$college_id ." has not read any book yet!!</td></tr>";
						 endif;

                 ?>

					
				
</table>
</form>
</body>
</html>
