<?php
	$finame = $_POST["firname"];
	$ssnuser = $_POST["ssnn"];
	$strad = $_POST["stad"];
	$emid = $_POST["eid"];
	$phno = $_POST["ph"];
	
	$spl = str_split($ssnuser);
	if($spl[3]=='-' && $spl[6]=='-')
	{
		
		if($finame=="" || $ssnuser=="" || $strad=="")
		{
			echo "One of the values is empty. Please complete the form.";
		}
		else
		{
			$con2=mysqli_connect("localhost","root","root","library");
			if (mysqli_connect_errno())
		  		{
		  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  		}
		
			$query = "Select ssn from borrower where ssn='$ssnuser'";		
			$result = mysqli_query($con2,$query);
			$row3=mysqli_fetch_array($result,MYSQLI_NUM);
			if($row3[0]=="")
			{
				$query1 = "Insert into borrower(ssn,bname,email,address,phone) values('$ssnuser','$finame','$emid','$strad','$phno')";
				$result1 = mysqli_query($con2,$query1);
				if($result1)
					echo "Member inserted successfully";
				else
				echo "Please try again";
			}
			else
			{
				echo "Member exists";
			}
		}
}
else
{
	echo "SSN format incorrect";
}
?>