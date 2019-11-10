<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';

//Import the $db object
require_once '../db/test_db.php';

$jobName = mysqli_real_escape_string($db, $_POST["jobname"]);
$jobDate = mysqli_real_escape_string($db, $_POST["duedate"]);
$jobTime = mysqli_real_escape_string($db, $_POST["duetime"]);
$remindDate = mysqli_real_escape_string($db, $_POST["remindDate"]);
$remindTime = mysqli_real_escape_string($db, $_POST["remindTime"]);
$remindRepeat = mysqli_real_escape_string($db, $_POST["repeat"]);
$jobGroup = mysqli_real_escape_string($db, $_POST["Group"]);
$jobCategory = mysqli_real_escape_string($db, $_POST["Category"]);
$jobMessage = mysqli_real_escape_string($db, $_POST["message"]);
$jobType = mysqli_real_escape_string($db, $_POST["Type"]);

$remindDateTime = date('Y-m-d H:i:s', strtotime("$remindDate $remindTime"));

$sql = "INSERT INTO JOBS 
('JOB_ID', 'GROUP_ID', 'TITLE', 'MESSAGE', 'CREATION_DATE', 'REMINDER_TIME', 'REPEATS_EVERY', 'JOB_TYPE', 'EXPIRED')
VALUES (NULL, $jobGroup, $jobName, $jobMessage, current_date, $remindDateTime, $remindRepeat, $jobType, '0')";
$result = mysqli_query($sql);

?>
