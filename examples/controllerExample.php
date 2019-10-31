<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';

//Import the $db object
require_once '../db/test_db.php';

//import POST message as a native PHP object
$json = json_decode(file_get_contents('php://input'));

//Controller logic

//here is an example of accessing the users information to make decisions.
//No decisions are made here, but here is how to access.
//Current available user values are below. These are created in login_user.php
// $_SESSION['user_id']
// $_SESSION['user_first_name']
// $_SESSION['user_last_name']
// $_SESSION['user_email']
$email = $_SESSION['user_email'];

//remember that if you take user input and pass it into a query that you need to sanitize the input
//or use prepared statements.
$sql = "SELECT * FROM USERS";
$result = mysqli_query($db, $sql);
$count = mysqli_num_rows($result);

//turn sql result into php array object
$users = Array();
$i = 0;
while($row =  $result->fetch_assoc()) {
    $users[$i] = Array('name' => $row['USER_FIRST_NAME'].' '.$row['USER_LAST_NAME'], 'email' => $row['USER_EMAIL']);
    $i++;
}






//Send Data at the end
$data = array( 'data' => $users, 'count' => $count);
header('Content-Type: application/json');
echo json_encode($data);


//close result array
mysqli_free_result($result);

//close database connection
mysqli_close($db);