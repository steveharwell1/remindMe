<?php
require_once 'error_msg.php';
if(isset($_POST['submit'])) {
    include_once('../db/test_db.php');
    include_once('debug.php');

    //Change this to a prepared statement later
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $passwd = mysqli_real_escape_string($db, $_POST['passwd']);

    if(empty($first_name) || empty($last_name) || empty($email) || empty($passwd)) {
        log_error('Please ensure all fields are complete');
        header('Location: ../create.php');
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        log_error('Invalid email address');
        header('Location: ../create.php');
        exit();
    } else {
        $hashed_passwd = password_hash($passwd, PASSWORD_DEFAULT);
        $sql2 = "INSERT INTO USERS (USER_FIRST_NAME, USER_LAST_NAME, USER_EMAIL, USER_PWD) VALUES ('$first_name', '$last_name', '$email', '$hashed_passwd');";
        $result2 = mysqli_query($db, $sql2);

        //TODO: Test if person was added or not.
        if($result2){
            $id = $db->insert_id;
            //log_error('id'.$id);
            $sql3 = "INSERT INTO GROUPS (GROUP_ID, GROUP_NAME, GROUP_OWNER, SUPER_GROUP) VALUES (NULL, '$first_name', $id, NULL)";
            mysqli_query($db, $sql3);
            header('Location: ../login.php');
        } else {
            log_error('Email already used.');
            header('Location: ../create.php');
        }
        exit();
    }

} else {
    log_error('Please use the account creation form');
    header('Location: ../create.php');
    exit();
}