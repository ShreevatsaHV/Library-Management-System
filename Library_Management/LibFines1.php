<?php
	$isbnf = $_POST["isbnfine"];	
	$option = $_POST["option1"];
	$car = intval($_POST["cardfine"]);
	
	$con4=mysqli_connect("localhost","root","root","library");
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
	
	if($option=='refreshfine')
	{
		$query ="Select loan_id from book_loans where date_in is null";
		$result = mysqli_query($con4,$query);
		$count=0;
		$count1=0;
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$lid=$row['loan_id'];
			$query1="Select datediff(curdate(),(select due_date from book_loans where loan_id=$lid))";
			$result1 = mysqli_query($con4,$query1);
			$row1=mysqli_fetch_array($result1,MYSQLI_NUM);
			
			if($row1[0]>0)
			{
				$fine=($row1[0])*0.25;  
				
				if($fine<0)
				{
					$fine=0;
				}
				
				$query2="Select loan_id from fines where loan_id=$lid";
				$result2=mysqli_query($con4,$query2);
				
				if(mysqli_num_rows($result2) == 0)
				{
					$query3="Insert into fines(loan_id,fine_amount,paid) values ($lid,$fine,'0')";
					$result3=mysqli_query($con4,$query3); 
					if($result3 && $count1==0)
						{
							print "Inserted into fine table";
							$count1=1;  
						}                                         
				}
				else
				{	
					$query4="Select paid from fines where loan_id=$lid";
					$result4=mysqli_query($con4,$query4);
					$row4=mysqli_fetch_array($result4,MYSQLI_NUM);
					
					if($row4[0]==0)
					{
						$query5="Update fines set fine_amount=$fine where loan_id=$lid";
						$result5=mysqli_query($con4,$query5);  
						//print "$count";
						if($result5 && $count==0)
						{
							print "Updated fine table";
							$count=1;  
						}
					}                                            
				}
			}
		}
	}
	
	
	elseif($option=='findfine')
	{	
		$query6="Select loan_id from book_loans where card_id=$car";
		$result6=mysqli_query($con4,$query6);
		echo "<select id='selectisbnforfine'>";

		while($row6=mysqli_fetch_array($result6,MYSQLI_ASSOC))
		{	
			$x=$row6['loan_id'];

			$query7="Select isbn,f.loan_id from book_loans as b join fines as f on b.loan_id=f.loan_id where b.loan_id=$x and f.paid='0'";
			$result7=mysqli_query($con4,$query7);

			while($row7=mysqli_fetch_array($result7,MYSQLI_ASSOC))
			{
				$x1=$row7['isbn'];
				$x2=intval($row7['loan_id']);
				echo "<option value='".$x1."'>".$x1."</option>";
				
				
				$query8="Select $x4+sum(fine_amount) from fines where loan_id=$x2";
				$result8=mysqli_query($con4,$query8);
				$row8=mysqli_fetch_array($result8,MYSQLI_NUM);
				$x4=$row8[0];
				
			}	
						
		}
		echo "</select>";
		echo "<br></br>";
		echo "Fine amount is ".$x4." dollars";	

	}
	
	
	elseif($option=='display')
	{
		
		$query9="Select distinct card_id from book_loans";
		$result9=mysqli_query($con4,$query9);
		while($row9=mysqli_fetch_array($result9,MYSQLI_ASSOC))
		{	
			$f1=intval($row9['card_id']);
			$query10="Select b.card_id,sum(f.fine_amount) as fine from book_loans as b join fines as f on b.loan_id=f.loan_id where b.card_id=$f1 and f.paid='0'";
			$result10=mysqli_query($con4,$query10);
			$row10=mysqli_fetch_array($result10,MYSQLI_ASSOC);
			
			$f=floatval($row10['fine']);
			$c=$row10['card_id'];

			if($f > 0 || $f!=null)
			{
				echo "Fine is ".$f." dollars and card id is ".$c.".";
				echo "<br></br>";
			}
		}		
	}
	

?>