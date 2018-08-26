<?php
	$detail = $_POST["detailCI"];
	$pieces1 = explode(" ", $detail);
	
	$con1=mysqli_connect("localhost","root","root","library");
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
	
	$arrlength1 = count($pieces1);
	//$items1 = array();
	
	echo "<select id='selectisbn'>";
	for($x1=0;$x1<$arrlength1;$x1++)
	{
		$detail1=$pieces1[$x1];
			
		$query = "select bl.loan_id, bl.isbn, bl.card_id , bl.date_out , bl.due_date from book_table as b join  
		          book_loans as bl on b.isbn10 = bl.isbn join borrower as br on br.card_id = bl.card_id where 
		          date_in is null and(b.isbn10='$detail1' or br.card_id='$detail1' or br.bname like '%$detail1%')";
		
		$result = mysqli_query($con1,$query);
		//echo "<table>";
		//echo "<tr><th width='100'>Loan ID</th><th width='100'>ISBN</th><th width='100'>Card ID</th><th width='100'>Date Out</th><th width='100'>Due date</th></tr>";
				
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{
			$lid=$row['loan_id'];
			$isbn1=$row['isbn'];
			$cid=$row['card_id'];
			$dout=$row['date_out'];
			$dued=$row['due_date'];
			
			if (!in_array($isbn1, $items1)) {
				echo "<option value='".$isbn1."'> ISBN: ".$isbn1." Card id: ".$cid."</option>";          
			}
			$items1[] = $isbn1;
			//echo "<tr><td align='center'>".$lid."</td><td align='center'> ".$isbn1."</td><td align='center'>".$cid."</td><td align='center'>".$dout."</td><td align='center'>".$dued."</td></tr>";
		}
		
		//echo "</table>";
	}
	echo "</select>";
?>