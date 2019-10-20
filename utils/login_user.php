<?php

session_start();
include_once 'error_msg.php';

if (isset($_POST['submit'])) {
    include_once '../db/test_db.php';

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $passwd = mysqli_real_escape_string($db, $_POST['passwd']);

    if(empty($email) || empty($passwd)) {
        log_error('Password or Email are empty!');
        header('Location: ../login.php');
        exit();
    }
    else {
        $hashed_passwd = password_hash($passwd, PASSWORD_DEFAULT);
        //TODO: turn statement into prepared statement
        $sql = "SELECT * FROM USERS WHERE USER_EMAIL='$email'";
        $result = mysqli_query($db, $sql);
        $count = mysqli_num_rows($result);
        if($count === 1){
            $entry = mysqli_fetch_assoc($result);
            if(password_verify($passwd, $entry['USER_PWD'])) {
                //echo 'Password Verified';
                //Login
                $_SESSION['user_id'] = $entry['USER_ID'];
                $_SESSION['user_first_name'] = $entry['USER_FIRST_NAME'];
                $_SESSION['user_last_name'] = $entry['USER_LAST_NAME'];
                $_SESSION['user_email'] = $entry['USER_EMAIL'];
                header("Location: ../index.php");
            } else {
                log_error('Email or Password are incorrect.');
                header("Location: ../login.php");
                exit();
            }
        } else {
            log_error('Email or Password are incorrect.');
            header("Location: ../login.php");
            exit();
        }
    }

} else {
    log_error('Please use the account creation form.');
    header('Location: ../login.php');
    exit();
}