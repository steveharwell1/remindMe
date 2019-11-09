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
$id = $_SESSION['user_id'];

//remember that if you take user input and pass it into a query that you need to sanitize the input
//or use prepared statements.
// $sql = "SELECT * FROM USERS";
// $result = mysqli_query($db, $sql);
// $count = mysqli_num_rows($result);



//turn sql result into php array object
$group = Array('name' => 'Birthday Planning');

//Send Data at the end
$data = Array( 'data' => $contents, 'action' => 'create');
header('Content-Type: application/json');
echo json_encode($data);

//Insert data into the database
$groupName = $group['name'];
$sql = "INSERT INTO `GROUPS` 
(`GROUP_NAME`, `GROUP_OWNER`, `SUPER_GROUP`) 
VALUES ($groupName, $id, NULL);";
$result = mysqli_query($db, $sql);


//close result array
// mysqli_free_result($result);

// //close database connection
// mysqli_close($db);