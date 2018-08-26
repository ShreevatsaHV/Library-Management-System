<?php
	$detailall = $_POST["detailSearch"];
	$pieces = explode(" ", $detailall);
	
	$con2=mysqli_connect("localhost","root","root","library");
	if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
	
	$arrlength = count($pieces);
	$items = array();
	echo "<table>";
	//echo "<tr><th width='100'>ISBN</th><th width='500'>Title</th><th width='400'>Author(s)</th><th width='50'>Availability</th></tr>";
	echo "<tr><th width='50'>Image</th><th width='100'>ISBN</th><th width='500'>Title</th><th width='400'>Author(s)</th><th width='50'>Availability</th></tr>";
	for($x=0;$x<$arrlength;$x++)
	{
		$detail=$pieces[$x];
			
		$query1 = "Select distinctrow isbn10,cover,title,group_concat(a.Author_Name1) as authors,availability from book_table as b 
			       join book_author1 as ba on b.isbn10=ba.isbn join authors1 as a on ba.author_id=a.Author_id1 
			       where (isbn10='$detail' or title like '%$detail%' or a.Author_Name1 like '%$detail%') 
			       group by ba.isbn order by isbn10, title,authors";
		
		$result1 = mysqli_query($con2,$query1);
		while($row=mysqli_fetch_array($result1,MYSQLI_ASSOC))
		{
			$isbn1=$row['isbn10'];
			$btitle=$row['title'];
			$cov=$row['cover'];
			$auth=$row['authors'];
			$av=$row['availability'];
			
			
			if($av==1)
				$av1="Available";
			else
				$av1="Not available";
			
			if (!in_array($isbn1, $items)) {
	    		//echo "<tr></td><td align='center'>".$isbn1."</td><td align='center'>".$btitle."</td><td align='center'>".$auth."</td><td align='center'>".$av1."</td></tr>";
	    		echo "<tr><td align='center'><img src='".$cov."' alt='' width='50' height='70'/></td><td align='center'>".$isbn1."</td><td align='center'>".$btitle."</td><td align='center'>".$auth."</td><td align='center'>".$av1."</td></tr>";
			}
			$items[] = $isbn1;
		}
	}
	echo "</table>";
?>