<?php
include("test_db.php");
error_reporting(0);
?>

<html>
<head> 

</head>

<body>
	<form action ="" method="GET">
	Group ID 	<input type="text" name="GroupID" value=""/><br><br>
	Group name	<input type="text" name="GroupName" value=""/><br><br>
	Group owner	<input type="text" name="GroupOwner" value=""/><br><br>
	Super group	<input type="text" name="SuperGroup" value=""/><br><br>
	<input type="submit" name="submit" value="Create"/>
	</form>

<?php
if($_GET['submit'])
{
	$groupID = $_GET['GroupID'];
	$groupName= $_GET['GroupName'];
	$groupOwner= $_GET['GroupOwner`'];
	$superGroup= $_GET['SuperGroup'];
	
	if($groupID!="" && $groupName!="" && $groupOwner!="" && $superGroup!="")
	{
		$query= "INSERT INTO GROUPS VALUES(`$groupID`, `$groupName`,
				`$groupOwner`, `$superGroup`)";
		$data= mysqli_query($db,$query);
		
		if($data)
		{
			echo "Data inserted into Database"
		}
	}
	else
	{
		echo "All fields are required";
	}
}


?>
</body>

</html>
