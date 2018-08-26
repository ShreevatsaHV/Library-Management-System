<?php
	$isbnCO1 = $_POST["isbnCO"];	
	$cardID1 = intval($_POST["cardID"]);
	
	$con=mysqli_connect("localhost","root","root","library");
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
    
    $len=strlen($isbnCO1);
    if($len==10)
    {
		$query4 ="Select f.loan_id from book_loans as b join fines as f on b.loan_id=f.loan_id where paid='0' and b.card_id=$cardID1 and f.fine_amount>0"; 
		$result4 = mysqli_query($con,$query4);
		$row4=mysqli_fetch_array($result4,MYSQLI_NUM);
		if($row4[0]==null)
		{
			$query1 ="Select count(card_id) from book_loans as bl where card_id=$cardID1 and row_deleted=0 and date_in is null and 
	                 (DATEDIFF((Select due_date from book_loans where loan_id= bl.loan_id),(CURDATE())) > 0)";   //change to >
			$result1 = mysqli_query($con,$query1);
			$row1=mysqli_fetch_array($result1,MYSQLI_NUM);
	
			if($row1[0]<3)
			{
				$c=$row1[0];
				$query2 ="Select availability from book_table where isbn10='$isbnCO1'";	
				$result2 = mysqli_query($con,$query2);
				$row2=mysqli_fetch_array($result2,MYSQLI_NUM);
				$c1=$row2[0];
					if($c1==1)
					{	
						$query3 = "Insert into book_loans(isbn,card_id,date_out,due_date,date_in,row_deleted) 
		                          values('$isbnCO1',$cardID1 ,curdate(),date_add(curdate(),interval 14 day),null,0)";   //change to 14 day	
						$result3 = mysqli_query($con,$query3);
						if($result3)
						{
								$query5 ="UPDATE book_table SET availability=0 WHERE isbn10='$isbnCO1'";
								$result5=mysqli_query($con,$query5);
								if($result5)
									echo "Successfully Checked Out!";		
								
								else
									echo "Book table availability not changed";	
						}
						else
						{
							echo "Unsuccessful. Please try again. Borrower does not exist";
						}
					}
					else
					{
						echo "Book not available";
					}
			}
			else
			{
				echo "Maximum number of books reached";
			}
		}
		else
		{
			echo "Fine amount due";
		}
	}
	else
	{
		echo "Isbn entered is incorrect";
	}
?>