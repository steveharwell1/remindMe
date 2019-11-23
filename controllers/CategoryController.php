<?PHP
//This makes sure this file is only accesses in an authorized way.
//This also ensures we can get the user name from $_SESSION
require_once '../utils/login_required.php';

//Import the $db object
require_once '../db/test_db.php';
require_once '../utils/error_msg.php';

$createColor = mysqli_real_escape_string($db, $_POST["createColor"]);
$createTitle = mysqli_real_escape_string($db, $_POST["createTitle"]);
$updateColor  = mysqli_real_escape_string($db, $_POST["updateColor"]);
$updateID = mysqli_real_escape_string($db, $_POST["Type"]);
$deleteID = mysqli_real_escape_string($db, $_POST["deleteID"]);
$confirm= mysqli_real_escape_string($db, $_POST["Confirm"]);
$submit= mysqli_real_escape_string($db, $_POST["Submit"]);
$USER_ID = $_SESSION['user_id'];

// echo $createColor;
// echo $createTitle;
// echo $updateColor;
// echo $updateID;
// echo $USER_ID;

echo $confirm.'<br>';
echo $deleteID;
// inserts into job table

if($createColor !== "" && $createTitle !== ""){
    echo "Inside Create";
    $sql = "INSERT INTO CATEGORY (CATEGORY_ID, CATEGORY_NAME, USER_ID, color) VALUES (NULL, '$createTitle', '$USER_ID', '$createColor')";
    $result = mysqli_query($db, $sql);
}else if ($updateColor !=="" && $updateID !== "" && $confirm !== 'on'){
    echo "Inside Update";
    $sql = "UPDATE CATEGORY SET color = '$updateColor' WHERE CATEGORY_ID = '$updateID'";
    $result = mysqli_query($db, $sql);
}
else if ($confirm == 'on' && $deleteID !== '' ){
    $sql = "DELETE FROM CATEGORY WHERE CATEGORY_ID = '$deleteID'";
    $result = mysqli_query($db, $sql);
}
else {
    log_error('Invalid Category Input');
}

//header('Location: https://remindme.business/index.php');
header('Location: /index.php');
?>
