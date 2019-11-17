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
$jobDateTime = date('Y-m-d H:i:s', strtotime("$jobDate $jobTime"));
$todayDate = date("Y-m-d");

// inserts into job table
$sql = "INSERT INTO JOBS 
(JOB_ID, GROUP_ID, TITLE, COMMENT, CREATION_DATE, REMINDER_TIME, REPEATS_EVERY, JOB_TYPE, EXPIRED)
VALUES (NULL, '$jobGroup', '$jobName', '$jobMessage', '$todayDate', '$remindDateTime', '$remindRepeat', '$jobType', '0')";
$result = mysqli_query($db, $sql);

//insert into reminder table
$id = $db->insert_id;
$sql = "INSERT INTO REMINDER
(REMINDER_ID, JOB_ID, IS_SENT, SEND_AFTER)
VALUES (NULL, '$id', '0', '$remindDateTime')";
$result = mysqli_query($db, $sql);

//insert into category table if category is selected
if ($jobCategory !== NULL) {
    $sql = "INSERT INTO CATEGORY_ASSOC
    (CATEGORY_ID, JOB_ID)
    VALUES ('$jobCategory', '$id')";
    $result = mysqli_query($db, $sql);
}

//insert into appropriate job type table
if ($jobType == "INFORMATIONAL") {
    $sql = "INSERT INTO INFORMATIONAL
    (JOB_ID, IS_READ)
    VALUES ('$id', '0')";
} else if ($jobType == "EVENT") {
    $sql = "INSERT INTO EVENT_
    (JOB_ID, BEGIN_TIME)
    VALUES ('$id', '$jobDateTime')";
} else if ($jobType == "DEADLINE") {
    $sql = "INSERT INTO DEADLINE
    (JOB_ID, IS_COMPLETE)
    VALUES ('$id', '0')";
} else if ($jobType == "TODO") {
    $sql = "INSERT INTO TODO
    (JOB_ID, IS_COMPLETE)
    VALUES ('$id', '0')";
}
$result = mysqli_query($db, $sql);

?>
