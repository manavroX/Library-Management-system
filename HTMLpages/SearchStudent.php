<?php 

include('../config/connectDB.php');
$search_by="";
$data="";
$availablerecord = true;
 

$sql="";
$flag=0;
$flipped_get = array_flip($_GET);
	//echo "<br>";
	//print_r($flipped_get);
if(isset($flipped_get['Remove']))
{
		//echo $flipped_get['Remove'];
	$college_id = mysqli_real_escape_string($conn, $flipped_get['Remove']);
    $sql1 = "select designation,mem_id from member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$desig = $infos['designation'];
	$mem_id=$infos['mem_id'];
	mysqli_free_result($result);
  if($desig!="head_librarian")
	{
		    $sql01="select count(*) from record r where issued_by='$mem_id' and return_date is NULL";
		         $result01 = mysqli_query($conn, $sql01);
			$i1 = mysqli_fetch_assoc($result01);
			$n1 = $i1['count(*)'];
			
		if($n1==0)
	    {

				    $sql2 = "select count(*) from record where issued_by = '$mem_id'";
					$result = mysqli_query($conn, $sql2);
					$info = mysqli_fetch_assoc($result);
					$num = $info['count(*)'];

					mysqli_free_result($result);
				    if($num>0)
				     {
						$sql3 = "delete from record where issued_by='$mem_id'";
				         mysqli_query($conn, $sql3);

					}

					if($desig=="admin" || $desig=="head_librarian")
					{

				         $sql4="update record set returned_by=NULL where returned_by='$mem_id'";
				                  mysqli_query($conn, $sql4);

					}




						$sql = "delete from member where college_id='$college_id'";
						if(mysqli_query($conn, $sql))
						{
							//echo "entry altered <br>";
						}
						else 
						{
					  		echo "error altering values: " . mysqli_error($conn) . "<br />";
						}
		}

		else
		{
			echo "<center>can't remove user, because ".$college_id." is still to return an issued book </center>";
		}	
	}
	else
	{
		echo "<center>head librarian cannot be removed</center>";
	}	
}


$sql1 = "select college_id,name,designation,phone,email,fine_due from member where verification_status=1 ";
$result1 = mysqli_query($conn, $sql1);
$studentinfo=  mysqli_fetch_all($result1);
mysqli_free_result($result1);


if(isset($_POST['search']))
{ 
	if(isset($_POST['search_on']))
	{
		$search_by = mysqli_real_escape_string($conn, $_POST['search_on']);
		$data= mysqli_real_escape_string($conn, $_POST['data']);
		
	}
   else
   { $flag=1;
   	
   }

  
   if($search_by=="college_id")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where college_id like '%$data%' and verification_status=1 order by mem_id";
   }
   if($search_by=="name")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where name like '%$data%' and verification_status=1  order by mem_id";
   }
   if($search_by=="designation")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where designation like '%$data%' and verification_status=1  order by mem_id";
   } 
   if($search_by=="phone")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where phone like '%$data%' and verification_status=1  order by mem_id";
   }
   if($search_by=="email")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where email like '%$data%' and verification_status=1  order by mem_id";
   }
   if($sql!="")
   {
			$result = mysqli_query($conn, $sql);

			
			if(mysqli_num_rows($result) > 0)
			{
				$studentinfo = mysqli_fetch_all($result);
			}
			else
			{
				$availablerecord = false;
			}
			mysqli_free_result($result);
   }
   else
   {
   	$availablerecord = false;
   }

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
 <div class = "searchbar">
 <form action="SearchStudent.php" method="POST">
 <div class = "login-box">
 	 
			<input type = "text" placeholder = "Search user" name = "data" value = "">
			<input type="submit" name="search" class = "buttons" value="search">
	
		 </div>

		 <div class = "textbox">
					 	<input type="radio" id="name" name="search_on" value="name">
							<label for="name">BY NAME</label>
						<input type="radio" id="college_id" name="search_on" value="college_id">
							<label for="college_id">BY COLLEGE ID</label>
						<input type="radio" id="designation" name="search_on" value="designation">
							<label for="designation">BY DESIGNATION</label>
						<input type="radio" id="phone" name="search_on" value="phone">
							<label for="phone">BY PHONE NUMBER</label>
						<input type="radio" id="email" name="search_on" value="email">
							<label for="email">BY EMAIL</label>
					</div>

			</form>	
			</div>	
		 <table border ="1" class = "tables" style = "margin-top:100px;">
		 	<tr>
		 		<th> College ID </th>
 	            <th> Name </th>
 	            <th> Designation </th>
 	            <th>Phone</th>
				<th>Email</th>
				<th>Fine due</th>

				
 	        </tr>
 	        <?php 
     
					
					if($availablerecord):
						foreach( $studentinfo as $student):
				?>
						<tr>
				<?php
						echo "<td>". $student[0]."</td>";
						echo "<td>". $student[1] ."</td>";
						echo "<td>". $student[2] ."</td>";
						echo "<td>". $student[3] ."</td>";
						echo "<td>". $student[4] ."</td>";
						echo "<td>". $student[5] ."</td>";

						
				?>
				   <form action="SearchStudent.php" method="GET">
      <td><input type="submit" name="<?php echo $student[0]?>" class = "buttons" value="Remove"> </td>
                    </form>
						</tr>
				<?php
						endforeach;
						else:
							{
                               if($flag==1)
                               	 echo "<tr><td colspan=\"6\">please select the search criteria </td></tr> ";

                               echo " <tr><td colspan=\"6\"> nothing to show!</td></tr>";  
							}
						
						 endif;

                 ?>
 	           
 	       
 	 
		 </table>