<?php
		$isbnfi = $_POST["isbnselected1"];
		$car1 = intval($_POST["cardfine1"]);
		
		$con5=mysqli_connect("localhost","root","root","library");
		if (mysqli_connect_errno())
  			{
  				echo "Failed to connect to MySQL: " . mysqli_connect_error();
  			}	
		
		$query="Select max(loan_id) as loan_id from book_loans where isbn='$isbnfi' && row_deleted=1 && card_id=$car1";   // not right
		$result=mysqli_query($con5,$query);
		$row=mysqli_fetch_array($result,MYSQLI_NUM);
		
		if($row[0]!=null)                            
		{
			$query1="Select paid from fines where loan_id='$row[0]'";
			$result1=mysqli_query($con5,$query1);
			$row1=mysqli_fetch_array($result1,MYSQLI_NUM);
			
			if($row1[0]=='0')
			{
				$query2="Update fines set paid='1' where loan_id='$row[0]'";
				$result2=mysqli_query($con5,$query2);
				
				if($result2)
				{
					echo "Payment of fee successful";
				}
			}
			else
			{
				echo "The fee amount has already been paid";
			}			
		}
		else
		{
			echo "Book has not been returned";
		}

?>