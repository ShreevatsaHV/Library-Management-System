<?php
	$isbnsel = $_POST["isbnselected"];
	
	$con2=mysqli_connect("localhost","root","root","library");
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
	
	$query = "Update book_loans set date_in=CURDATE() where isbn='$isbnsel' && row_deleted=0";
	$result = mysqli_query($con2,$query);
	//$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if($result)
	{
		//echo "Book Loans table date in updated";
		$query1="Update book_table set availability=1 where isbn10='$isbnsel'";
		$result2 = mysqli_query($con2,$query1);
		
		if($result2)
		{
			$query2="Select datediff((select date_in from book_loans where isbn='$isbnsel' && row_deleted=0),(select due_date from book_loans where isbn='$isbnsel' && row_deleted=0))";
			$result3 = mysqli_query($con2,$query2);
			$row3=mysqli_fetch_array($result3,MYSQLI_NUM);
			
			if($row3[0]>0)   //check this 
			{
				$fineamount=$row3[0]*0.25;    
				$query3="Select loan_id from book_loans where isbn='$isbnsel' && row_deleted=0";			
				$result4 = mysqli_query($con2,$query3);
				$row4=mysqli_fetch_array($result4,MYSQLI_NUM);
				if($row4[0] != null)  
				{   
					$m=intval($row4[0]);
					$query8="Select loan_id from fines where loan_id=$m";
					$result8 = mysqli_query($con2,$query8);
					$row8=mysqli_fetch_array($result8,MYSQLI_NUM);
					
				    if($row8[0]==null)
				    {                                  
						$query4="Insert into fines(fine_amount, loan_id, paid) values ($fineamount,$row4[0],'0')";
						$result5 = mysqli_query($con2,$query4);
						if($result5)
						{
							echo "Values inserted into fine table";
							$query5 = "Update book_loans set row_deleted=1 where isbn='$isbnsel'";
							$result6 = mysqli_query($con2,$query5);
						}
						else
						{
							echo "Not inserted into fines table";
						}
					}
					else
					{
						echo "Fine already exists in the table";
						$query7 = "Update book_loans set row_deleted=1 where isbn='$isbnsel'";
						$result8 = mysqli_query($con2,$query7);
										
						$query9 = "Select fine_amount from fines where loan_id=$m";
						$result9 = mysqli_query($con2,$query9);
						$row9=mysqli_fetch_array($result9,MYSQLI_NUM);
						if($row9[0]!=$fineamount)
						{
							$query10 = "Update fines set fine_amount=$fineamount where loan_id=$m";
							$result10 = mysqli_query($con2,$query10);
							if($result10)
							{
								echo "Fine table updated too";
							}
						}
												
					}
				}
				else
				{
					echo "Loan Id doesnt exist for the isbn or book has been returned already";
				}
			}
			else
			{					
					$query6 = "Update book_loans set row_deleted=1 where isbn='$isbnsel'";
					$result7 = mysqli_query($con2,$query6);
					if($result7)
					{
						echo "book returned on time and row deleted is updated";
					}
			}
		}
		else
		{
			echo "book table(availability) not updated";
		}	
	}
	else
	{
		echo "update book loans(date in) not done";
	}

?>