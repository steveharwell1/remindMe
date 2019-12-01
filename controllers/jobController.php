<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';

//Import the $db object
require_once '../db/test_db.php';
//import log error function
require_once '../utils/error_msg.php';

$userid = $_SESSION['user_id'];
$jobid = $_SESSION['jobid'];
$jobName = mysqli_real_escape_string($db, $_POST["jobname"]);
$jobDate = mysqli_real_escape_string($db, $_POST["duedate"]);
$jobTime = mysqli_real_escape_string($db, $_POST["duetime"]);
$remindDate = mysqli_real_escape_string($db, $_POST["remindDate"]);
$remindTime = mysqli_real_escape_string($db, $_POST["remindTime"]);
//$remindRepeat = mysqli_real_escape_string($db, $_POST["repeat"]);
$jobGroup = mysqli_real_escape_string($db, $_POST["Group"]);
$jobCategory = mysqli_real_escape_string($db, $_POST["Category"]);
$jobMessage = mysqli_real_escape_string($db, $_POST["message"]);
$jobType = mysqli_real_escape_string($db, $_POST["Type"]);

// check to make sure all required fields are filled in
if(empty($jobName)) {
    log_error('Please fill in the job name');
    header('Location: ../templates/jobView.php');
    exit();
}
else if (empty($jobDate) || empty($jobTime)) {
    log_error('Please fill in both the date and time of the event');
    header('Location: ../templates/jobView.php');
    exit();
}
else if (empty($remindDate) || empty($remindTime)) {
    log_error('Please fill in both the date and time of the reminder');
    header('Location: ../templates/jobView.php');
    exit();
}
else if (empty($jobType)) {
    log_error('Please select the job type');
    header('Location: ../templates/jobView.php');
    exit();
}

// if group is NULL then change jobGroup variable to user's personal group id
if(empty($jobGroup)) {
    $sql = "SELECT *
    FROM GROUPS
    WHERE GROUP_OWNER = $userid
    LIMIT 1";
    $result = mysqli_query($db, $sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jobGroup = $row['GROUP_ID'];
    }
}

// formats dates to be input into database
$remindDateTime = date('Y-m-d H:i:s', strtotime("$remindDate $remindTime"));
$jobDateTime = date('Y-m-d H:i:s', strtotime("$jobDate $jobTime"));
$todayDate = date("Y-m-d");

// if job needs to be created
if ($jobid == 0) {
    // inserts into job table
    $sql = "INSERT INTO JOBS 
    (JOB_ID, GROUP_ID, TITLE, COMMENT, CREATION_DATE, DUE_DATE, REMINDER_TIME, JOB_TYPE, EXPIRED)
    VALUES (NULL, '$jobGroup', '$jobName', '$jobMessage', '$todayDate', '$jobDateTime', '$remindDateTime', '$jobType', '0')";
    $result = mysqli_query($db, $sql);

    //get id of job created
    $jobid = $db->insert_id;

    /*//insert into reminder table
    $sql = "INSERT INTO REMINDER
    (REMINDER_ID, JOB_ID, IS_SENT, SEND_AFTER)
    VALUES (NULL, '$id', '0', '$remindDateTime')";
    $result = mysqli_query($db, $sql);
    */

    //insert into category table if category is selected
    if ($jobCategory !== NULL) {
        $sql = "INSERT INTO CATEGORY_ASSOC
        (CATEGORY_ID, JOB_ID)
        VALUES ('$jobCategory', '$jobid')";
        $result = mysqli_query($db, $sql);
    }

    /*
    //insert into appropriate job type table
    if ($jobType == "INFORMATIONAL") {
        $sql = "INSERT INTO INFORMATIONAL
        (JOB_ID, IS_READ)
        VALUES ('$jobid', '0')";
    } else if ($jobType == "EVENT") {
        $sql = "INSERT INTO EVENT_
        (JOB_ID, BEGIN_TIME, END_TIME, location)
        VALUES ('$jobid', '$jobDateTime', '$jobDateTime', NULL)";
    } else if ($jobType == "DEADLINE") {
        $sql = "INSERT INTO DEADLINE
        (JOB_ID, IS_COMPLETE)
        VALUES ('$jobid', '0')";
    } else if ($jobType == "TODO") {
        $sql = "INSERT INTO TODO
        (JOB_ID, IS_COMPLETE)
        VALUES ('$jobid', '0')";
    }
    $result = mysqli_query($db, $sql);
    */
}
// if job needs to be updated
else {
    // update job in JOBS table
    $sql = "UPDATE JOBS
    SET GROUP_ID = '$jobGroup', TITLE = '$jobName', COMMENT = '$jobMessage', CREATION_DATE = '$todayDate', DUE_DATE = '$jobDateTime', REMINDER_TIME = '$remindDateTime', JOB_TYPE = '$jobType'
    WHERE JOB_ID = $jobid";
    $result = mysqli_query($db, $sql);

    // update category table
    $sql = "UPDATE CATEGORY_ASSOC
    SET CATEGORY_ID = '$jobCategory'
    WHERE JOB_ID = $jobid";
    $result = mysqli_query($db, $sql);
}

//header('Location: https://remindme.business/index.php');
header('Location: /index.php');
?>
