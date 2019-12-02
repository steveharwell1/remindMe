<?php

require_once "../db/test_db.php";
require_once "debug.php";
require_once "../db/keys.php";

$messages = array();
$messageIDs = array();

$sql = "SELECT * FROM JOBS
inner join USERS_GROUPS on USERS_GROUPS.GROUP_ID = JOBS.GROUP_ID
inner join USERS on USERS_GROUPS.MEMBER_ID = USERS.USER_ID
inner join GROUPS on USERS_GROUPS.GROUP_ID = GROUPS.GROUP_ID
WHERE REMINDER_TIME IS NOT NULL
AND REMINDER_TIME <= CURRENT_TIMESTAMP
AND MEMBERSHIP_STATUS = 'ACCEPTED'";

$result = mysqli_query($db, $sql);
$count = mysqli_num_rows($result);
//tablify($result);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $rowTitle = htmlspecialchars($row['TITLE']);
    $rowEmail = $row['USER_EMAIL'];
    $rowComment = htmlspecialchars($row['COMMENT']);
    $rowGroupName = htmlspecialchars($row['GROUP_NAME']);
    array_push($messageIDs, $row['JOB_ID']);

    array_push($messages, array(
      'title' => $rowTitle,
      'email' => $rowEmail,
      'comment' => $rowComment,
      'groupName' => $rowGroupName
    ));
  }
} else {
  //empty
}

$sql = "SELECT * FROM JOBS
inner join GROUPS on GROUPS.GROUP_ID = JOBS.GROUP_ID
inner join USERS on GROUPS.GROUP_OWNER = USERS.USER_ID
WHERE REMINDER_TIME IS NOT NULL
AND REMINDER_TIME < current_timestamp";



$result = mysqli_query($db, $sql);
$count = mysqli_num_rows($result);
//tablify($result);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $rowTitle = htmlspecialchars($row['TITLE']);
    $rowEmail = $row['USER_EMAIL'];
    $rowComment = htmlspecialchars($row['COMMENT']);
    $rowGroupName = htmlspecialchars($row['GROUP_NAME']);
    array_push($messageIDs, $row['JOB_ID']);

    array_push($messages, array(
      'title' => $rowTitle,
      'email' => $rowEmail,
      'comment' => $rowComment,
      'groupName' => $rowGroupName
    ));
  }
} else {
  //empty
}

//var_dump($messageIDs);

foreach ($messages as $message) {
  //echo
  send($message['groupName'], $message['title'], $message['comment'], $message['email']);
}

foreach($messageIDs as $id){
  $sql = "UPDATE JOBS
  SET REMINDER_TIME = NULL
  WHERE JOB_ID =$id";
  $result = mysqli_query($db, $sql);
}

//send('Steve Group 1', 'Thanksgiving Shopping', 'Do not go shopping', 'steveharwell@gmail.com');