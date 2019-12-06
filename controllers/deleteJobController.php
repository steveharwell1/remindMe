<?php

//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';
require_once '../utils/debug.php';

//Import the $db object
require_once '../db/test_db.php';

require_once '../utils/error_msg.php';
$deleteID = mysqli_real_escape_string($db, $_GET['delete']);
if(!empty($deleteID)) {
    $sql = "DELETE j FROM JOBS j
            INNER JOIN GROUPS ON GROUPS.GROUP_ID = j.GROUP_ID
            WHERE GROUPS.GROUP_OWNER = ".$_SESSION['user_id']."
            AND j.JOB_ID = ".$deleteID;
    if(!mysqli_query($db, $sql)) {
        log_error('Could not delete that job it is not in your group. '.$deleteID);
    }
}



header('Location: /index.php');
?>