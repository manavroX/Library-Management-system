<?php
	include('../config/connectDB.php');
	$search_book_name = '';
	$error = '';
	$flag=0;
	$search_by="";
    $data="";
    $sql="";
    $sql1="";
    $books1=array();
    $books2=array();
	$availableBooks = true;
	$notavailableBooks=true;
	$sql01 = "SELECT book.gr_no,name,rating,category,status from book,copy where book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no order by length(book.gr_no),book.gr_no";
    $result01 = mysqli_query($conn, $sql01);
			if(mysqli_num_rows($result01) > 0)
			{
				$books1 = mysqli_fetch_all($result01);
			}
			else
			{
				$availableBooks = false;
			}
			mysqli_free_result($result01);
 
    $sql02 = "SELECT book.gr_no,name,rating,category,status from book,copy where  book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no order by length(book.gr_no),book.gr_no";
     


	$result = mysqli_query($conn, $sql02);
	if(mysqli_num_rows($result) > 0)
	{
		$books2 = mysqli_fetch_all($result);
	}
	else
	{
		$notavailableBooks = false;	
	}
	mysqli_free_result($result);
    






     $flipped_get = array_flip($_GET);
	
	if(isset($flipped_get['checkout reviews']))
	{
		//echo $flipped_get['Remove'];
		$my_gr_no = mysqli_real_escape_string($conn, $flipped_get['checkout reviews']);
                session_start();
                $_SESSION["my_gr_no"] = $my_gr_no;
                header('Location: ShowReview.php');
  }




   if(isset($_POST['gr_button']))
	{
		$gr_num = mysqli_real_escape_string($conn, $_POST['gr_button']);
		session_start();
		$_SESSION["gr_no"] = $gr_num;
		header('Location: BookDetails.php');
	}
	if(isset($_GET['clear']))
	{
		header('Location: BookSearchPage.php');
	}


   if(isset($_POST['search_book']))
{ 
	if(isset($_POST['search_on']))
	{
		$search_by = mysqli_real_escape_string($conn, $_POST['search_on']);
		$data= mysqli_real_escape_string($conn, $_POST['data']);
		
	}
   else
   { $flag=1;
   }

  
   if($search_by=="name")
   {
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no order by length(book.gr_no),book.gr_no";


    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where name like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no order by length(book.gr_no),book.gr_no";

   }
   if($search_by=="genre")
   {  
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where category like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no order by length(book.gr_no),book.gr_no";

    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy where category like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where category like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no order by length(book.gr_no),book.gr_no";
   
   }
   if($search_by=="rating")
   {if(is_numeric($data))
   	{
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where rating=$data AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no order by length(book.gr_no),book.gr_no";


     $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy where rating=$data AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where rating=$data AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no order by length(book.gr_no),book.gr_no";
   } 
}

  if($search_by=="auth1")
   {  
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where  a.first_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and   copy.conditions=1 AND copy.status = 1 group by book.gr_no order by length(book.gr_no),book.gr_no";

    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where a.first_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and  copy.conditions=1 AND copy.status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy,book_author ba,author a where a.first_name like '%$data%' AND book.gr_no = copy.gr_no AND  book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and copy.conditions=1 AND copy.status = 1 group by book.gr_no) group by book.gr_no order by length(book.gr_no),book.gr_no";
   
   }

 if($search_by=="auth2")
   {  
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where  a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and   copy.conditions=1 AND copy.status = 1 group by book.gr_no order by length(book.gr_no),book.gr_no";

    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and  copy.conditions=1 AND copy.status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy,book_author ba,author a where a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND  book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and copy.conditions=1 AND copy.status = 1 group by book.gr_no) group by book.gr_no order by length(book.gr_no),book.gr_no";
   
   }





  // if($search_by=="auth2")
  //  {  
  //   $sql = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where  a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and   copy.conditions=1 AND status = 1 group by book.gr_no";

  //   $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and  copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy,book_author ba,author a where a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND  book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
   
  //  }


   
   if($sql!="")
    {		$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{   $availableBooks = true;
				$books1 = mysqli_fetch_all($result);
			}
			else
			{
				$availableBooks = false;
			}
			mysqli_free_result($result);
   }
   else
   {
   	$availableBooks = false;
    
   }

    if($sql1!="")
    {
    $result = mysqli_query($conn, $sql1);
	if(mysqli_num_rows($result) > 0)
	{      $notavailableBooks = true;	
		$books2 = mysqli_fetch_all($result);
	}
	else
	{
		$notavailableBooks = false;	
	}
	mysqli_free_result($result);
  }
  else
  {
   $notavailableBooks = false;	
  }

	if(!$availableBooks && !$notavailableBooks)
	{   
		$error = "NA";
	}



}










































	// if(isset($_GET['search_book']))
	// {
	// 	$search_book_name = mysqli_real_escape_string($conn, $_GET['search_book']);
	// }
	//else
	// {
	// 	$search_book_name = '';
	// }
	// $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$search_book_name%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no";
	// $result = mysqli_query($conn, $sql);
	// if(mysqli_num_rows($result) > 0)
	// {
	// 	$books1 = mysqli_fetch_all($result);
	// }
	// else
	// {
	// 	$availableBooks = false;
	// }
	// mysqli_free_result($result);
	// $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$search_book_name%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where name like '%$search_book_name%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
	// $result = mysqli_query($conn, $sql);
	// if(mysqli_num_rows($result) > 0)
	// {
	// 	$books2 = mysqli_fetch_all($result);
	// }
	// else
	// {
	// 	$notavailableBooks = false;	
	// }
	// mysqli_free_result($result);
	// if(!$availableBooks && !$notavailableBooks)
	// {
	// 	$error = "No Such book exists";
	// }

?>


<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Book Search Page</title>
		
		<link rel="stylesheet"  href="../CSS/styles.css">
		<style>
.tables {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width:70%;
  Position:absolute;
  left:15%;
  margin-top:30px;

}

td, th {
  border: 1px solid black;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color:#BCC6F0;
}

tr:nth-child(odd) {
  background-color:#99A4C;
}
</style>
	</head>
	<body>
		
		<nav id="main-navigation">
                <ul>
                	<li><a href = "Myprofile.php" >My profile</a> </li>
                    <li><a href = "userhomepage.php"> Back</a></li>

                </ul>    
            </nav>
           <div class = "searchbar">
		
					<form action="BookSearchPage.php" method="POST">
						 <div class = "login-box">
						 	<div class = "textbox">
						
							<input type = "text" placeholder = "SearchBook" name = "data" value = "">
							<input type="submit" name="search_book" class = "buttons" value="search">
							<input type="submit" name="clear" class = "buttons" value="Clear">
						</div>
						</div>
							

						

						 <div class = "textbox">
					 	<input type="radio" id="name" name="search_on" value="name">
							<label for="name">BY BOOK NAME</label>
						<input type="radio" id="genre" name="search_on" value="genre">
							<label for="genre">BY GENRE</label>
						<input type="radio" id="rating" name="search_on" value="rating">
							<label for="rating">BY RATING</label>
						<input type="radio" id="auth1" name="search_on" value="auth1">
							<label for="auth1">BY AUTHOR FIRST NAME</label>
						<input type="radio" id="auth2" name="search_on" value="auth2">
							<label for="auth1">BY AUTHOR LAST NAME</label>
					</div>
				
					</form>
	</div>
						 
						
							
				
	

		<table class="tables" style = "margin-top:100px;">
			<thread>
			<tr>
				<th scope="col"> GR number</th>
				<th scope="col"> Book Name</th>
				<th scope="col"> Rating</th>
				<th scope="col"> Genre</th>				
				<th scope="col"> Author</th>
				<th scope="col"> Availability</th>
				<th scope="col"> Reviews</th>
				
			</tr>
		</thread>
				<?php
					if($availableBooks):
						foreach($books1 as $book):
				?>
						<tr>
	                     <form action="BooksearchPage.php" method="POST">
	      					<td>
	      						<input type="submit" name="gr_button" class = "buttons" value="<?php echo $book[0]; ?>" > 
	      					</td>
	                    	</form>	
				
                    	<?php
                      //  
						//echo "<td>". $book[0]."</td>";
						echo "<td>". $book[1] ."</td>";
						echo "<td>". $book[2] ."</td>";
						echo "<td>". $book[3]." </td>";
						 
						$sql = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$book[0]')";
						$result = mysqli_query($conn, $sql);
						$authors = mysqli_fetch_all($result);
				?>
						<td>
							<table>
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
						if($book[4]==1)
						{
							echo "<td> Available </td>";
						}
						else
						{
							echo "<td>". "Reserved" ."</td>";
						}
				?>
             <form action="BooksearchPage.php" method="GET">
				  	<td>
      				<input type="submit" name="<?php echo $book[0]; ?>" class = "buttons" value="checkout reviews" > 
      			</td>
      			</form>


						</tr>
				<?php
						endforeach;
					endif;
					if($notavailableBooks):
						foreach($books2 as $book):
				?>
						<tr>

							<form action="BooksearchPage.php" method="POST">
      					<td>
      						<input type="submit" name="gr_button" class = "buttons" value="<?php echo $book[0]; ?>" > 
      					</td>
                    		</form>

				<?php
						//echo "<td>". $book[0]."</td>";
						echo "<td>". $book[1] ."</td>";
						echo "<td>". $book[2] ."</td>";
						echo "<td>". $book[3]." </td>";
						
						$sql = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$book[0]')";
						$result = mysqli_query($conn, $sql);
						$authors = mysqli_fetch_all($result);
				?>
						<td>
							<table >
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

						if($book[4]==1)
						{
							echo "<td> Available </td>";
						}
						else
						{
							echo "<td>". "Reserved" ."</td>";
						}
				?>
              <form action="BooksearchPage.php" method="GET">
				 <td>
      				<input type="submit" name="<?php echo $book[0]; ?>" class = "buttons" value="checkout reviews" > 
      			</td>
      		</form>


						</tr>
				<?php
						endforeach;
					endif;
					if($flag==1):
		               echo "<tr><td colspan=\"7\">"."please select the search criteria  "."</td></tr>";
					
					elseif(!$availableBooks&&!$notavailableBooks):
						echo "<tr><td colspan=\"7\">".$error."</td></tr>";
					endif;
				?>
			</tr>
				

	
	
	
	</body>
<?php 
	//mysqli_free_result($result);
	mysqli_close($conn);
?>
	