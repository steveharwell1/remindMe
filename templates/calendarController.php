<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';

//Import the $db object and error messaging system
require_once '../db/test_db.php';
require_once '../utils/error_msg.php';

//import POST message as a native PHP object
$json = json_decode(file_get_contents('php://input'), true);

//Controller logic

//Current available user values are below. These are created in login_user.php
$_SESSION['user_id'];
// $_SESSION['user_first_name']
// $_SESSION['user_last_name']
// $_SESSION['user_email']
// $email = $_SESSION['user_email'];

//remember that if you take user input and pass it into a query that you need to sanitize the input
//or use prepared statements.
$mon = mysqli_real_escape_string($db, $json['month']);
$year = mysqli_real_escape_string($db, $json['year']);
$sql = "SELECT * FROM JOBS WHERE MONTH(REMINDER_TIME) = '$mon' and YEAR(REMINDER_TIME) = '$year'";
$result = mysqli_query($db, $sql);
$count = mysqli_num_rows($result);
error_log($sql);
//turn sql result into php array object
$jobs = Array();
$i = 0;
while($row =  $result->fetch_assoc()) {
    $jobs[$i] = Array('title' => $row['TITLE'],
                      'comment' => $row['COMMENT'],
                      'date' => $row['REMINDER_TIME']);
    $i++;
}

//Send Data at the end
$data = array( 'data' => $jobs, 'count' => $count, 'echo'=> $sql);
header('Content-Type: application/json');
echo json_encode($data);


//close result array
mysqli_free_result($result);

//close database connection
mysqli_close($db);