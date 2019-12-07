<?php
 include_once '../utils/login_required.php';
 include_once '../db/test_db.php';
 include '../utils/debug.php';
 //include 'header.php';

 $userid = $_SESSION['user_id'];
?>

<!-- forms for buttons that will be connected via javascript -->
<form id = "deleteGroupForm" action = "/controllers/groupController.php" method = "POST" style = "display: none;">
	<input id = "deleteGroup" name = "groupID" />
</form>
<form id = "kickUserForm" action = "/controllers/groupController.php" method = "POST" style = "display: none;">
	<input id = "kickUser" name = "userID" />
</form>
<form id = "leaveGroupForm" action = "/controllers/groupController.php" method = "POST" style = "display: none;">
	<input id = "leaveGroup" name = "groupID" />
</form>

<h2>GROUPS</h2>
<div style = "display: flex;">
<h3>My Groups</h3>
<button type = "button" id = "createGroup">+</button>
</div>

<form action = "/controllers/groupController.php" method = "post" id = "createGroupForm">
<input type = "text" name = "groupName" placeholder = "Group Name"/>
 Super Group: <select name = "superGroup">
<?php
	// find groups user is in
	$sql = "SELECT * 
	FROM GROUPS 
	INNER JOIN USERS_GROUPS 
	ON GROUPS.GROUP_ID = USERS_GROUPS.GROUP_ID
	WHERE MEMBER_ID = $userid
	ORDER BY GROUP_ID";
	$result = mysqli_query($db, $sql);

	// find groups user is owner of
	$sql2 = "SELECT *
	FROM GROUPS
	WHERE GROUP_OWNER = $userid
	ORDER BY GROUP_OWNER";
	$result2 = mysqli_query($db, $sql2);

	//add option for no super group
	echo "<option value = ''>None</option>";

	// display groups user is owner of and display personal group first if not group connected to job
	if ($result2->num_rows > 0) {
		while($row2 = $result2->fetch_assoc()) {
			echo "<option value = " . $row2['GROUP_ID'];
			echo ">" . $row2['GROUP_NAME'] . "</option>";
		}
	}

	// display groups user is a part of and display group job is connected to
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<option value = " . $row['GROUP_ID'];
			echo ">" . $row['GROUP_NAME'] . "</option>";
		}
	}
?>
</select>
<button type = "submit" value = "submit">Create</button>
</form>

<?php
	// find groups user is owner of
	$sql = "SELECT *
	FROM GROUPS
	WHERE GROUP_OWNER = $userid
	ORDER BY GROUP_ID";
	$result = mysqli_query($db, $sql);

	// display result
	$first = true;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<div class = 'groups'>";
			echo "<button type = 'button' class = 'groupFilter' value = " . $row['GROUP_ID'] . ">&#x2713;</button>";
			echo $row['GROUP_NAME'];
			if (! $first) {
				echo "<button type = 'button' class = 'groupDelete' value = " . $row['GROUP_ID'] . ">Destroy</button>";
			}
			else {
				$first = false;
			}
			echo "</div>";

			//find users in group
			$sql2 = "SELECT *
			FROM USERS_GROUPS
			INNER JOIN USERS
			ON USERS_GROUPS.MEMBER_ID = USERS.USER_ID
			WHERE USERS_GROUPS.GROUP_ID = " . $row['GROUP_ID'];
			$result2 = mysqli_query($db, $sql2);

			if ($result2->num_rows > 0) {
				echo "<ul>";
				while($row2 = $result2->fetch_assoc()) {
					echo "<li>" . $row2['USER_FIRST_NAME'] . " " . $row2['USER_LAST_NAME'];
					echo "<button type = 'button' class = 'kickUser' value = " . $row2['USER_ID'] . "::" . $row['GROUP_ID'] . ">Kick</button></li>";
				}
				echo "</ul>";
			}
		}
	}
?>

<br>
<div style = "display: flex;">
<h3>My Memberships</h3>
<form action = "/controllers/groupController.php" method = "post" id = "joinGroupForm">
<input type = "text" name = "groupID">
<button type = "submit" value = "join">Join</button>
</form>
</div>

<?php
	//find groups user is member of
	$sql = "SELECT *
	FROM USERS_GROUPS
	INNER JOIN GROUPS
	ON USERS_GROUPS.GROUP_ID = GROUPS.GROUP_ID
	WHERE USERS_GROUPS.MEMBER_ID = $userid
	AND USERS_GROUPS.MEMBERSHIP_STATUS = 'ACCEPTED'";
	$result = mysqli_query($db, $sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<div class = 'groups'>";
			echo "<button type = 'button' class = 'groupFilter' value = " . $row['GROUP_ID'] . ">&#x2713;</button>";
			echo $row['GROUP_NAME'];
			echo "<button type = 'button' class = 'groupLeave' value = " . $row['GROUP_ID'] . ">Leave</button>";
			echo "</div>";
		}
		echo "</ul>";
	}
?>

<script>
//create arrays for each group of buttons created
deleteGroupButtons = Array.from(document.querySelectorAll(".groupDelete"));
console.log(deleteGroupButtons.length);
kickButtons = Array.from(document.querySelectorAll(".kickUser"));
console.log(kickButtons.length);
leaveGroupButtons = Array.from(document.querySelectorAll(".groupLeave"));
console.log(leaveGroupButtons.length);

// adding click event to delete group buttons
for(row of deleteGroupButtons) {
	let val = row.value;
	row.addEventListener('click', function () {
		document.getElementById('deleteGroup').value = val;
		document.getElementById('deleteGroupForm').submit();
	});
}

// adding click event to kick user buttons
for(row of kickButtons) {
	let val = row.value;
	row.addEventListener('click', function () {
		document.getElementById('kickUser').value = val;
		document.getElementById('kickUserForm').submit();
	});
}

// adding click event to leave group buttons
for(row of leaveGroupButtons) {
	let val = row.value;
	row.addEventListener('click', function () {
		document.getElementById('leaveGroup').value = val;
		document.getElementById('leaveGroupForm').submit();
	});
}

</script>