<?php
 include_once '../utils/login_required.php';
 include_once '../db/test_db.php';
 include '../utils/debug.php';
 //include 'header.php';

?>

<form action ="" method="GET">
	Group ID 	<input type="text" name="GroupID" value=""/><br>
	Group name	<input type="text" name="GroupName" value=""/><br>
	Group owner	<input type="text" name="GroupOwner" value=""/><br>
	Super group	<input type="text" name="SuperGroup" value=""/><br>
	<input type="submit" name="submit" value="submit"/>
</form>

<?php
if($_GET['submit'])
{
	$groupID = mysqli_real_escape_string($db, $_GET['GroupID']);
	$groupName= $_GET['GroupName'];
	$groupOwner= $_GET['GroupOwner'];
	$superGroup= $_GET['SuperGroup'];
	if(!empty($_GET['GroupID']) && !empty($_GET['GroupName']) && $groupOwner!="" && $superGroup!="")
	{
		$query= "INSERT INTO GROUPS VALUES('$groupID', '$groupName',
				'$groupOwner', '$superGroup')";
		$data= mysqli_query($db,$query);
		if($data)
		{
			echo "Data inserted into Database";
		} else {

		}
	}
	else
	{
		echo "All fields are required";
	}
}

?>
<?php
//include '/templates/footer.php';
?>
