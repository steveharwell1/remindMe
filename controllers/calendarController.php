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
$month = Array();
for($i = 0; $i < 30; $i++){
    array_push($month, Array("Reminder $i"));
}

//Send Data at the end
$data = array( 'data' => $group, 'action' => 'create');
header('Content-Type: application/json');
echo json_encode($data);


//close result array
// mysqli_free_result($result);

// //close database connection
// mysqli_close($db);