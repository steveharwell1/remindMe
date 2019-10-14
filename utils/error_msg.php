<?php

function log_error($message) {

    session_start();

    if(!isset($_SESSION['errors'])){
        $_SESSION['errors'] = array();
    }

    array_push($_SESSION['errors'], $message);

}