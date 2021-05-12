<?php 

include('../config/connectDB.php');
    session_start();
    $college_id = $_SESSION['college_id'];
	$gr_num = $_SESSION['gr_no'];
	
	$sql = "select mem_id from member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql);
	$mem_ids = mysqli_fetch_assoc($result);
	$mem_id = $mem_ids['mem_id'];
	mysqli_free_result($result);
	$flipped_get = array_flip($_GET);
    $sql = "Select designation from member where mem_id = '$mem_id'";
	$result = mysqli_query($conn, $sql);
	$desigArr = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	$designation = $desigArr['designation'];
    $waitlistBool = false;

     if(isset($flipped_get['Delete']))
     {

		$copyno = mysqli_real_escape_string($conn, $flipped_get['Delete']);
        //   $sqls="delete from record where copy_no='$copyno' ";
        //    mysqli_query($conn, $sqls);

        // $sqll="delete from copy where copy_no='$copyno' and gr_no='$gr_num' ";
        //  mysqli_query($conn, $sqll);
        $sql4="select status from copy where copy_no=$copyno and gr_no='$gr_num'";
        $result = mysqli_query($conn, $sql4);
		$delStatusArr = mysqli_fetch_assoc($result);
		$delStatus = $delStatusArr['status'];
		mysqli_free_result($result);
		if($delStatus==1)
        {
        	$sqll="update copy set conditions=0 where copy_no=$copyno and gr_no='$gr_num'";
                //echo $sqll;
                $result123=mysqli_query($conn, $sqll);
        
                if(mysqli_query($conn, $sqll))
                {
                	//echo "inside if";
        	        $sql123 = "select count(*) from copy where gr_no='$gr_num' and conditions=1";
        	        $result = mysqli_query($conn, $sql123);
        			$copyCountArr = mysqli_fetch_assoc($result);
        			$copyCount = $copyCountArr['count(*)'];
        			//echo $copyCount;
        			mysqli_free_result($result);
        			if($copyCount==0)
        			{
        				header('Location: BookSearchPage.php');
        			}
        		}
        }
		else
		{
			echo "<center>You Cannot delete a reserved book</center>";
		}
     }



	if(isset($flipped_get['Issue']))
	{
		$copyToIssue = mysqli_real_escape_string($conn, $flipped_get['Issue']);
		//echo "issue copy ". $copyToIssue;
		$sql = "Select count(*) from record where issued_by = '$mem_id' and return_date is NULL";
		$result = mysqli_query($conn, $sql);
		$noOfBooksArr = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		$noOfBooks = $noOfBooksArr['count(*)'];
		// echo "<br>";
		// echo "no of unreturned books = " . $noOfBooks;
		// echo "<br>";
		$sql = "Select designation from member where mem_id = '$mem_id'";
		$result = mysqli_query($conn, $sql);
		$desigArr = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		$designation = $desigArr['designation'];
		// echo "designation = " . $designation;
		// echo "<br>";
		if($designation=='student')
		{
			$noOfIssueableBooks = 2;
			$duration = "+1 week";
		}
		else if($designation == 'non_teacher')
		{
			$noOfIssueableBooks = 4;
			$duration = "+1 month";
		}
		else
		{
			$noOfIssueableBooks = 5;
			$duration = "+3 months";
		}
		// echo $noOfBooks;
		// echo $noOfIssueableBooks;
		if($noOfBooks<$noOfIssueableBooks)
		{
			//issue book
			//due_date	review	issue_date	return_date	rating	issued_by	returned_by	gr_no	copy_no
			//$today_date = date("Y/m/d");
			//echo $today_date;
			$sql="SELECT count(*) from record where gr_no='$gr_num' and return_date is NULL and issued_by=$mem_id";
			//echo $sql;
			$result = mysqli_query($conn, $sql);
			$countOfAlreadyIssuedArr = mysqli_fetch_assoc($result);
			$countOfAlreadyIssued = $countOfAlreadyIssuedArr['count(*)'];
			mysqli_free_result($result);
			//echo $countOfAlreadyIssued;
			if($countOfAlreadyIssued==0)
			{
				
				// mysqli_free_result($result);

				$strt_d = strtotime("today");
				$today_date = date("Y/m/d", $strt_d);
				$end_d = strtotime($duration,$strt_d);
				$end_date = date("Y/m/d", $end_d);
				// echo "Start date = $today_date end date = $end_date <br>";
				$sql = "UPDATE copy set status=0 where gr_no = '$gr_num' AND copy_no='$copyToIssue'";
				if(mysqli_query($conn, $sql)) {
				  	//echo "value updated<br>";
				} else {
				 	echo "<center>problem in updating Please contact library staff</center><br />";
				}
				$sql = "INSERT into record(due_date,review,issue_date,return_date,rating,issued_by,returned_by,gr_no,copy_no) values ('$end_date', NULL, '$today_date', NULL, NULL, $mem_id, NULL, '$gr_num', $copyToIssue)";
				if(mysqli_query($conn, $sql)) {
				  	echo "<center>You have Successfully reserved the book, please collect the book from the library</center><br>";
				  	$sql = "SELECT accession_id from record where due_date='$end_date' and issue_date = '$today_date' and issued_by = $mem_id and gr_no = '$gr_num' and copy_no=$copyToIssue";
				  	$result = mysqli_query($conn, $sql); 
				  	$accessionIdArr = mysqli_fetch_assoc($result);
					$accession_id = $accessionIdArr['accession_id'];
					mysqli_free_result($result);
				  	$sql = "Select name from book where gr_no = '$gr_num'";
				  	$result = mysqli_query($conn, $sql); 
				  	$bookNameArr = mysqli_fetch_assoc($result);
					$bookName = $bookNameArr['name'];
					mysqli_free_result($result);
					$sql1 = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$gr_num')";
					$result1 = mysqli_query($conn, $sql1);
					$authors = mysqli_fetch_all($result1);
					mysqli_free_result($result1);
					$auth = '';
					foreach ($authors as $author):
						$auth .= $author[0] . " " . $author[1] . ", ";
					endforeach;
					$sql = "select email,name from member where mem_id = $mem_id";
					$result = mysqli_query($conn, $sql); 
				  	$emailArr = mysqli_fetch_assoc($result);
					$email = $emailArr['email'];
					$name = $emailArr['name'];
					mysqli_free_result($result);

				  	$to_email = "$email";
					$subject = "Issue Book Email";
					$headers = "From: librarymody@gmail.com\r\n";
					//$headers .= "CC: susan@example.com\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$body = "
					<html>
					<head>
					  <title>Issue Book Email</title>
					</head>
					<body>
					  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MODY Library System</b></p><br>
					  <p>Dear $name($college_id)<br>
					  The following book has been issued by you today.<br>
					  $gr_num |$bookName |".substr($auth, 0, -2)."|Accession id: $accession_id
					  <br>
					  You are welcome to contact us at librarymody@gmail.com for any Queries.
					  <br>
					  Regards,
					  <br>
					  Librarian
					  </p>
					</body>
					</html>
					";
					if (mail($to_email, $subject, $body, $headers)) {
					    //echo "Email successfully sent to $to_email...";
					} else {
					    echo "Email sending failed...";
					}
				} else {
				 	 echo "<center>error reserving the book, please contact library staff" . mysqli_error($conn) . "</center><br />";
				}
				$sql = "UPDATE waitlist set priority_no=priority_no-1 where gr_no = '$gr_num'";
				if(mysqli_query($conn, $sql)) {
				 	//echo "waitlist updated <br />";
				} else {
				  	echo "error instering values: " . mysqli_error($conn) . "<br />";
				}
				$sql = "DELETE from waitlist where priority_no=0";
				if(mysqli_query($conn, $sql)) {
				 	//echo "waitlist updated <br />";
				} else {
				  	echo "error deleting values: " . mysqli_error($conn) . "<br />";
				}
			}
			else
			{
				echo "<center>You have already issued one copy of this book, you can't issue another</center>";
			}
			
		}
		else
		{
			//display error
			echo "<center>You Have already issued $noOfBooks books, please return some book before issuing the next</center><br />";
		}
		
	}
	if(isset($flipped_get['Waitlist']))
	{
		$bookToWaitlist = mysqli_real_escape_string($conn, $flipped_get['Waitlist']);
		// echo "Waitlist gr_no=" . $bookToWaitlist;
		$sql = "SELECT count(*) from record where gr_no = $gr_num and return_date IS NULL and issued_by=$mem_id";
		//echo $sql;
		$result = mysqli_query($conn, $sql);
		$alreadyIssuedArr = mysqli_fetch_assoc($result);
		$alreadyIssued = $alreadyIssuedArr['count(*)'];
		mysqli_free_result($result);
		if($alreadyIssued==1)
		{
			echo "<center>You have already issued this book, you cannot add yourself to the waitlist</center><br>";
		}
		else
		{
			$sql = "select count(*) from waitlist where gr_no = $gr_num";
			$result = mysqli_query($conn, $sql);
			$priority = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			// print_r($priority);
			// echo "<br>";
			$priorityNum = $priority['count(*)'];
			$priorityNum++;
			// echo "<br>";
			// echo "priority = $priorityNum";
			// echo "<br>";
			$college_id = $_SESSION['college_id'];
			$sql = "select mem_id from member where college_id = '$college_id'";
			$result = mysqli_query($conn, $sql);
			$mem_ids = mysqli_fetch_assoc($result);
			$mem_id = $mem_ids['mem_id'];
			mysqli_free_result($result);
			// echo "mem_id = $mem_id";
			// echo "<br>";
			$sql = "insert into waitlist values($mem_id,'$gr_num',$priorityNum)";
			if (mysqli_query($conn, $sql)) {
			  	echo "<center>You Have been added to the waitlist your waiting number is $priorityNum</center><br />";
			} else {
				$sql = "SELECT priority_no from waitlist where gr_no = '$gr_num' and mem_id = $mem_id";
				$result = mysqli_query($conn, $sql);
				$priorityNoArr = mysqli_fetch_assoc($result);
				$priorityNum = $priorityNoArr['priority_no'];
				mysqli_free_result($result);
			  	echo "<center>You are already in the Waitlist of this book your waiting number is ". $priorityNum . "</center><br />";
			}
		}
	}
	if(isset($flipped_get['Reserved']))
	{
		echo "<center>This Copy is reserved, you may issue any other copy or Add yourself to the waitlist</center><br />";
	}
	$sql = "SELECT b.gr_no,b.name,c.copy_no,p.pname,c.edition,b.category,l.shelf,l.section,l.floor,c.status from book b,copy c,publisher p,location l where b.gr_no='$gr_num' and b.gr_no=c.gr_no and b.pub_id=p.pub_id and l.loc_id=b.loc_id and c.conditions=1" ;
	$result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
	{
		$copyrecord=mysqli_fetch_all($result);
	}
	mysqli_free_result($result);
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
                	<li><a href ="BookSearchPage.php"> Goto search book </a></li>
                	<li><a href ="Recommender.php"> Goto my book recommender </a></li>
                    <li><a href = "Myprofile.php" >My Profile</a></li>
                     <li><a href = "userhomepage.php">Home page</a></li>

                </ul>    
            </nav>
		
	
		<form action="BookDetails.php" method="GET">
		<table class = "tables" >
			<tr>
				<th>Book Gr no.</th>	
				<th>Book Title</th>
				<th>Copy no.</th>
				<th>Author</th>
			
				<th>Publisher</th>
				
				<th>Edition</th>
				<th>Genre</th>
				<th>Shelf</th>
				<th>Section</th>
				<th>Floor</th>
				<th>Availability</th>
				<?php
					if($designation=='admin' || $designation=="head_librarian"):
				?>
					<th>Delete Copy</th>
				<?php
					endif;
				?>
				<th>Issue/Return</th>
			
			</tr>
			
	      <?php 
							foreach( $copyrecord as $copyinfo):
				?>
						<tr>
				<?php
						echo "<td>". $copyinfo[0]."</td>";
						echo "<td>". $copyinfo[1] ."</td>";
						echo "<td>". $copyinfo[2] ."</td>";
                        $sql1 = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$copyinfo[0]')";
						$result1 = mysqli_query($conn, $sql1);
						$authors = mysqli_fetch_all($result1);
				?>
						<td>
							<table class>
				<?php
							foreach ($authors as $author):
								echo "<tr>";
									echo "<td>";
									echo $author[0] . " " . $author[1];
									echo "</td>";
								echo "</tr>";
							endforeach;
				?>
							</table>
						</td>
							<?php  
								echo "<td>". $copyinfo[3]." </td>";	
								echo "<td>". $copyinfo[4]." </td>";	
								echo "<td>". $copyinfo[5]." </td>";	
								echo "<td>". $copyinfo[6]." </td>";	
								echo "<td>". $copyinfo[7]." </td>";	
								echo "<td>". $copyinfo[8]." </td>";	
								$sql = "Select count(*) from waitlist where gr_no = '$copyinfo[0]'";
								$result = mysqli_query($conn, $sql);
								$checkWaitlistArr = mysqli_fetch_assoc($result);
								$checkWaitlist = $checkWaitlistArr['count(*)'];
								mysqli_free_result($result);
								if($checkWaitlist>0)
								{
									$sql = "SELECT mem_id from waitlist where gr_no = '$copyinfo[0]' and priority_no=1";
									$result = mysqli_query($conn, $sql);
									$mem_id_priority = mysqli_fetch_assoc($result);
									$firstMemId = $mem_id_priority['mem_id'];
									mysqli_free_result($result);
									//echo $firstMemId;
									if($firstMemId==$mem_id){
										//echo "inside if";
										$waitlistBool = false;
									}
									else
										$waitlistBool = true;
								}
								else
								{
									$waitlistBool = false;
								}
								if ($copyinfo[9]==1 && !$waitlistBool)
								{
									echo "<td>". "Available "." </td>";
									
										//echo "making available true";
										$available = true;

								}
								else 
								{
									echo "<td>". "Reserved "." </td>";
									
										//echo "making available false";
										$available = false;
									
								}
								
							?>
						<?php
		               		$sql = "Select designation from member where college_id = '$college_id'";
		               		$result = mysqli_query($conn, $sql); 
						  	$designationArr = mysqli_fetch_assoc($result);
							$designation = $designationArr['designation'];
							mysqli_free_result($result);
							if($designation=='admin'||$designation=='head_librarian'):
		               	?>
		               	<td>
		               		<input type="submit" name="<?php echo $copyinfo[2]; ?>" class = "buttons" value="Delete">
		               	</td>
		               	<?php
		               		endif;
		               	?>
						<?php
						if(!$waitlistBool):
						?>
	               			<td>
	               		<?php
	               		else:
	               		?>
	               			<td colspan="<?php echo count($copyrecord); ?>">
	               		<?php
	               		endif;
	               		?>
		               		<input type="submit" name="<?php echo $copyinfo[2]; ?>" class = "buttons"
		               		value="<?php echo $available ? "Issue" :($waitlistBool? "Waitlist" : "Reserved" )?>">
	               		</td>
	               		
	         
					    
							</tr>
					<?php
							endforeach;
	                ?>

		
		<?php
			if(!$waitlistBool):
			$sql = "(SELECT gr_no from copy where gr_no ='". $_SESSION['gr_no'] . "' AND copy.conditions=1 AND status = 1)";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result)==0)
			{
		?>
		<tr>
			<td colspan="12">
				<input class = "buttons" type="submit" name="<?php echo $_SESSION['gr_no']?>" value = "Waitlist">
			</td>
		</tr>
		<?php
			}
			mysqli_free_result($result);
			mysqli_close($conn);
			endif;
		?>
		</table>
		</form>
	
	
</body>