<html>
<head> ADD GROUP</head>

<body>
	<form action ="" method="GET">
	Group ID 	<input type="text" name="GroupID" value=""/><br>
	Group name	<input type="text" name="GroupName" value=""/><br>
	Group owner	<input type="text" name="GroupOwner" value=""/><br>
	Super group	<input type="text" name="SuperGroup" value=""/><br>
	<input type="submit" name="submit" value="Create Group"/>
	</form>


</body>

</html>

<!DOCTYPE html>

<html>

    <head>

        <title>DELETE GROUP</title>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>

    <body>

        <form action="deleteGroup.php" method="post">

            Enter Group ID to delete:&nbsp;<input type="text" name="GROUP_ID" required><br><br>

            <input type="submit" name="delete" value="Delete Group">

        </form>

    </body>

</html>
