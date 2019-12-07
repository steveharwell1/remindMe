<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';

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
    $superGroup = mysqli_real_escape_string($db, $_POST['superGroup']);
    $sql = "INSERT INTO GROUPS
    (GROUP_ID, GROUP_NAME, GROUP_OWNER, SUPER_GROUP)
    VALUES (NULL, '$groupName','$userID' , $superGroup)";
    $result = mysqli_query($db, $sql);

    
}
else if(isset($_POST['deleteGroupID']))
{
    $deleteGroupID= mysqli_real_escape_string($db, $_POST['deleteGroupID']);
}
else if(isset($_POST['leaveGroupID']))
{
    $leaveGroupID= mysqli_real_escape_string($db, $_POST['leaveGroupID']);
}
else if(isset($_POST['kickUserID']))
{
     $kickuserID =mysqli_real_escape_string($db, $_POST['kickUserID']);
}
else if(isset($_POST['joinGroupID']))
{
    $joinGroupID = mysqli_real_escape_string($db, $_POST['joinGroupID']);
}



   



if(!empty($deleteGroup)){
    $sql = "SELECT * 
    FROM 'GROUPS'
    WHERE GROUPS.GROUP_ID = $deleteGroup";

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