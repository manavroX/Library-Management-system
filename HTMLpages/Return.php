<?php 
session_start();
	$college_id = $_SESSION['college_id'];

	include('../config/connectDB.php');
	$availablerecord = true;

    
$flipped_get = array_flip($_GET);

if(isset($flipped_get['Return']))
	{
		
		$accessionid = mysqli_real_escape_string($conn, $flipped_get['Return']);
         $sql1 = "select b.gr_no,c.copy_no,r.issued_by from record r,copy c,book b where r.accession_id = '$accessionid' and b.gr_no=c.gr_no and b.gr_no=r.gr_no and c.copy_no=r.copy_no";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$grno = $infos['gr_no'];
	$copyno =$infos['copy_no'];
	$issued_by=$infos['issued_by'];
	mysqli_free_result($result);
	$sql2 = "update copy set status=1 where copy.gr_no='$grno' and copy.copy_no='$copyno'";
         mysqli_query($conn, $sql2);
    $sql22 = "update member set fine_due=0 where mem_id='$issued_by'";
         mysqli_query($conn, $sql22);
    $sql4 = "select mem_id from member where college_id='$college_id'";
	$result = mysqli_query($conn, $sql4);
	$data1 = mysqli_fetch_assoc($result);
	$mem_id = $data1['mem_id'];
	mysqli_free_result($result);

     $sql3 = "update record set returned_by='$mem_id' where accession_id='$accessionid'";
         mysqli_query($conn, $sql3);  

     $strt_d = strtotime("today");
	 $today_date = date("Y/m/d", $strt_d); 
	   $sql5 = "update record set return_date='$today_date' where accession_id='$accessionid'";
         mysqli_query($conn, $sql5);
    $sql = "SELECT issued_by from record where accession_id = $accessionid";
    $result = mysqli_query($conn, $sql); 
    $issuedByArr = mysqli_fetch_assoc($result);
	$issued_by = $issuedByArr['issued_by'];
	mysqli_free_result($result);
    $sql = "select email,name,college_id from member where mem_id = $issued_by";
	$result = mysqli_query($conn, $sql); 
  	$emailArr = mysqli_fetch_assoc($result);
	$email = $emailArr['email'];
	$name = $emailArr['name'];
	$college_id_issued = $emailArr['college_id'];
	mysqli_free_result($result);
	$sql = "Select name from book where gr_no = '$grno'";
  	$result = mysqli_query($conn, $sql); 
  	$bookNameArr = mysqli_fetch_assoc($result);
	$bookName = $bookNameArr['name'];
	mysqli_free_result($result);
	$sql1 = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$grno')";
	$result1 = mysqli_query($conn, $sql1);
	$authors = mysqli_fetch_all($result1);
	mysqli_free_result($result1);
	$auth = '';
	foreach ($authors as $author):
		$auth .= $author[0] . " " . $author[1] . ", ";
	endforeach;
    $to_email = "$email";
	$subject = "Return Book Email";
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
	  <p>Dear $name($college_id_issued)<br>
	  The following book has been returned by you today.<br>
	  $grno |$bookName |".substr($auth, 0, -2)." |Accession id: $accessionid
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

	
	}
	$sql = "SELECT r.accession_id,m.college_id,b.gr_no,c.copy_no,b.name,r.due_date,m.fine_due  FROM member m,record r,book b,copy c where 
    r.gr_no=c.gr_no and  r.copy_no=c.copy_no  and b.gr_no=c.gr_no and r.issued_by=m.mem_id and r.return_date is NULL
    order by r.accession_id ";
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

 <table border="1" class = "tables">
 	<tr>
 		<th>accession id</th>
 		<th>user id</th>
 		<th>book id</th>
 		<th>Copy  no.</th>
 		<th>book name</th>
 		<th> due date</th>
 		<th>fine due</th>
 		<th>Return Book</th>
 	</tr>
 	<?php 
     
					
					if($availablerecord):
						foreach( $recordinfo as $record):
				?>
						<tr>
				<?php
						echo "<td>". $record[0]."</td>";
						echo "<td>". $record[1] ."</td>";
						echo "<td>". $record[2] ."</td>";
						echo "<td>". $record[3] ."</td>";
						echo "<td>". $record[4] ."</td>";
						echo "<td>". $record[5]."</td>";
						echo "<td>". $record[6]."</td>";
					
						
				?>
				   <form action="Return.php" method="GET">
      <td><center><input type="submit" name="<?php echo $record[0]?>" class = "buttons" value="Return"> </center></td>
                    </form>
						</tr>
						
				<?php
						endforeach;
						else:
							{
                         
                               echo "<tr><td colspan=\"8\">nothing to return!</td></tr>";  
							}
						
						 endif;

                 ?>
 </table>

</body>
