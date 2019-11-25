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
$user_id = $_SESSION['user_id'];

//remember that if you take user input and pass it into a query that you need to sanitize the input
//or use prepared statements.
$mon = mysqli_real_escape_string($db, $json['month']);
$year = mysqli_real_escape_string($db, $json['year']);
$thisMonth = new DateTime($year.'-'.$mon);
$message = "";

$sql = "select * from JOBS
        INNER JOIN GROUPS ON JOBS.GROUP_ID = GROUPS.GROUP_ID
        WHERE GROUPS.GROUP_OWNER = '$user_id'
        and MONTH(REMINDER_TIME) = '$mon'
        and YEAR(REMINDER_TIME) = '$year'";
        //and REPEATS_EVERY = 'ONCE'";
$result = mysqli_query($db, $sql);
$count = mysqli_num_rows($result);
//error_log($sql);
//turn sql result into php array object
$jobs = Array();
$i = 0;
while($row =  $result->fetch_assoc()) {
    $jobs[$i] = Array('title' => $row['TITLE'],
                      'comment' => $row['COMMENT'],
                      'date' => $row['REMINDER_TIME'],
                      'id' => $row['JOB_ID']
                    );
    $i++;
}

$sql = "select * from JOBS
        INNER JOIN GROUPS ON JOBS.GROUP_ID = GROUPS.GROUP_ID
        INNER JOIN USERS_GROUPS on JOBS.GROUP_ID = USERS_GROUPS.GROUP_ID
        WHERE USERS_GROUPS.MEMBER_ID = '$user_id'
        and MONTH(REMINDER_TIME) = '$mon'
        and YEAR(REMINDER_TIME) = '$year'";
        //and REPEATS_EVERY = 'ONCE'";
$result = mysqli_query($db, $sql);
$count += mysqli_num_rows($result);
//turn sql result into php array object
while($row =  $result->fetch_assoc()) {
    $jobs[$i] = Array('title' => $row['TITLE'],
                      'comment' => $row['COMMENT'],
                      'date' => $row['REMINDER_TIME'],
                      'id' => $row['JOB_ID']
                    );
    $i++;
}

// $sql = "select * from JOBS
//         INNER JOIN GROUPS ON JOBS.GROUP_ID = GROUPS.GROUP_ID
//         INNER JOIN USERS_GROUPS on JOBS.GROUP_ID = USERS_GROUPS.GROUP_ID
//         WHERE USERS_GROUPS.MEMBER_ID = '$user_id'
//         and REMINDER_TIME <= '$year-$mon'
//         and REPEATS_EVERY != 'ONCE'";
// $result = mysqli_query($db, $sql);
// $count += mysqli_num_rows($result);
// //turn sql result into php array object
// while($row =  $result->fetch_assoc()) {
//     $d = new DateTime($row['REMINDER_TIME']);
//     $one_week = DateInterval::createFromDateString('1 week');
//     $message = 'Inside while loop'.$d.'----'.$thisMonth;
//     while($d <= $thisMonth)
//     {
//       $message = 'Inside while loop'.$d;
//       //$d = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"))
//       $jobs[$i] = Array('title' => $row['TITLE'],
//                       'comment' => $row['COMMENT'],
//                       'date' => $d,
//                       'id' => $row['JOB_ID']
//                     );
//       $d->add($one_week);
//       $i++;        
//     }
    
// }

// $sql = "select * from JOBS
//         INNER JOIN GROUPS ON JOBS.GROUP_ID = GROUPS.GROUP_ID
//         WHERE GROUPS.GROUP_OWNER = '$user_id'
//         and REMINDER_TIME <= '$year-$mon'
//         and REPEATS_EVERY != 'ONCE'";
// $result = mysqli_query($db, $sql);
// $count += mysqli_num_rows($result);
// //turn sql result into php array object
// while($row =  $result->fetch_assoc()) {
//   $d = new DateTime($row['REMINDER_TIME']);
//   $one_week = DateInterval::createFromDateString('1 week');
//   while($d < $thisMonth)
//   {
//     $message = $d->format('m');
//     if($d->format('m') == ($mon - 1) && $d->format('Y') == $year)
//     {
//         $jobs[$i] = Array('title' => $row['TITLE'],
//         'comment' => $row['COMMENT'],
//         'date' => $d->format('Y-m-d\TH:i:sP'),
//         'id' => $row['JOB_ID']
//       );
//       $i++; 
//     }
//     $d->add($one_week);
//   }
// }

//Send Data at the end
$data = array(  'data' => $jobs,
                'count' => $count,
                'echo'=> $message,
                'month' => $mon,
                'year' => $year 
              );
header('Content-Type: application/json');
echo json_encode($data);


//close result array
mysqli_free_result($result);

//close database connection
mysqli_close($db);