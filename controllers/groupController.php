<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';
include '../utils/debug.php';

//Import the $db object
require_once '../db/test_db.php';

//import POST message as a native PHP object
$contents = file_get_contents('php://input');
$json = json_decode($contents);


//Controller logic
$userID = $_SESSION['user_id'];

//remember that if you take user input and pass it into a query that you need to sanitize the input
//or use prepared statements.
// $sql = "SELECT * FROM USERS";
// $result = mysqli_query($db, $sql);
// $count = mysqli_num_rows($result);

if(isset($_POST['groupName']))
{
    $groupName = mysqli_real_escape_string($db, $_POST['groupName']);
    if (isset($_POST['superGroup']) && !empty($_POST['superGroup'])) {
        $superGroup = mysqli_real_escape_string($db, $_POST['superGroup']);
        $sql = "INSERT INTO GROUPS
        (GROUP_ID, GROUP_NAME, GROUP_OWNER, SUPER_GROUP)
        VALUES (NULL, '$groupName','$userID' , '$superGroup')";
    } else {
        $sql = "INSERT INTO GROUPS
        (GROUP_ID, GROUP_NAME, GROUP_OWNER, SUPER_GROUP)
        VALUES (NULL, '$groupName','$userID' , NULL)";
    }
    $result = mysqli_query($db, $sql);
}
else if(isset($_POST['deleteGroupID']))
{
    $deleteGroupID= mysqli_real_escape_string($db, $_POST['deleteGroupID']);
    $sql = "DELETE FROM GROUPS 
    WHERE GROUPS.GROUP_ID = $deleteGroupID";
    $result = mysqli_query($db, $sql);
    tablify($result);
}
else if(isset($_POST['leaveGroupID']))
{
    $leaveGroupID= mysqli_real_escape_string($db, $_POST['leaveGroupID']);
    $sql =" DELETE FROM USERS_GROUPS
    WHERE USERS_GROUPS.GROUP_ID = $leaveGroupID
    AND USERS_GROUPS.MEMBER_ID = $userID";
    $result = mysqli_query($db, $sql);


}
else if(isset($_POST['kickUserID']))
{
     $kickuserID =mysqli_real_escape_string($db, $_POST['kickUserID']);
    $params = explode("::", $kickuserID);
    $kickedUser = $params[0];
    $kickingGroup = $params[1];
     $sql = "DELETE FROM USERS_GROUPS
     WHERE USERS_GROUPS.MEMBER_ID = ".$kickedUser."
    and USERS_GROUPS.GROUP_ID = ".$kickingGroup;
     $result = mysqli_query($db, $sql);
 }
else if (isset($_POST['joinGroupID']))
{
    $joinGroupID = mysqli_real_escape_string($db, $_POST['joinGroupID']);
    $sql = "INSERT INTO USERS_GROUPS
    (USERS_GROUPS_ID, MEMBER_ID, GROUP_ID, MEMBERSHIP_STATUS)
    VALUES (NULL, '$userID','$joinGroupID','PENDING') ";
    $result = mysqli_query($db, $sql);
    
}
else if(isset($_POST['acceptDeclineUserID']))
{
    $acceptDeclineUserID =mysqli_real_escape_string($db, $_POST['acceptDeclineUserID']);
    $params = explode("::", $acceptDeclineUserID);
    $acceptdecline = $params[0];
    $pendinguserID = $params[1];
    $groupID = $params[2];
    $sql = "UPDATE USERS_GROUPS
    SET MEMBERSHIP_STATUS = ".$acceptdecline."
    WHERE MEMBER_ID = ".$pendinguserID. "
    AND GROUP_ID = ".$groupID;
    $result = mysqli_query($db, $sql);

}



   









//Insert data into the database
//$groupName = $group['name'];
//$sql = "INSERT INTO `GROUPS` 
//(`GROUP_NAME`, `GROUP_OWNER`, `SUPER_GROUP`) 
//VALUES ($groupName, $id, NULL);";
//$result = mysqli_query($db, $sql);


//close result array
// mysqli_free_result($result);

// //close database connection
// mysqli_close($db);

?>
