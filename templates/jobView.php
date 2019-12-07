<?php 
    include_once '../utils/login_required.php';
    include_once '../db/test_db.php';
    include '../utils/debug.php';
    include 'header.php';

    // get user id
    $userid = $_SESSION['user_id'];

    //post from clicking on reminder on calendar
    $id = 0;
    $title = "";
    date_default_timezone_set('America/Chicago');
    $jobDate = date('m/d/Y');
    $jobTime = date('H:i');
    $reminderDate = date('m/d/Y');
    $reminderTime = date();
    //$repeat;
    $type = "";
    $groupID = 0;
    $categoryID = 0;
    $message = "";
    if (isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
        $id = $_POST['reminderID'];
        $sql = "SELECT *
        FROM JOBS
        WHERE JOB_ID = $id";
        $result = mysqli_query($db, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $title = htmlspecialchars($row['TITLE']);
            $jobDateTime = $row['DUE_DATE'];
            $jobDate = date('Y-m-d', strtotime($jobDateTime . " UTC"));
            $jobTime = date('H:i', strtotime($jobDateTime . " UTC" . ''));
            if ($row['REMINDER_TIME'] !== NULL) {
                $reminderDateTime = $row['REMINDER_TIME'];
                $reminderDate = date('Y-m-d', strtotime($reminderDateTime." UTC"));
                $reminderTime = date('H:i', strtotime($reminderDateTime." UTC" . ''));
            }
            //$repeat;
            $type = $row['JOB_TYPE'];
            $groupID = $row['GROUP_ID'];
            $message = htmlspecialchars($row['COMMENT']);
        }
    }
    else {
        //post from + button on calendar
        $jobDate = $_POST['date'];
    }
    $_SESSION['jobid'] = $id;

?>

<form action = "../controllers/jobController.php" method = "post" id = "jobform">

    <!-- text field for job title -->
    Job Name <span class = "red">*</span><br>
    <input type = "text" name = "jobname" value = "<?php echo $title; ?>" required><br>

    <!-- date field for date of job -->
    Date of Event <span class = "red">*</span><br>
    <input type = "date" name = "duedate" value = "<?php echo $jobDate; ?>" required/>
    <?php 
        if(isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
            echo "<input type = 'time' name = 'duetime' value = " . $jobTime . " required>";
        }
        else {
            echo "<input type = 'time' name = 'duetime' value = '12:00' required>";
        }
        ?>
    <br>

    <!-- reminder date -->
    Date to be Reminded <span class = "red">*</span><br>
    <input type = "date" name = "remindDate" value = "<?php echo $reminderDate; ?>" required/>
    <?php 
        if(isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
            echo "<input type = 'time' name = 'remindTime' value = " . $reminderTime . " required>";
        }
        else {
            echo "<input type = 'time' name = 'remindTime' value = '12:00' required>";
        }
        ?>
    <br>

    <!-- radio field for how often to repeat remeinder 
    Repeat Reminder: <span class = "red">*</span><br>
    <div style = "margin: 10px; margin-left: 0px">
        <input type = "radio" id = "ONCE" name = "repeat" value = "ONCE" checked>
        <label for = "ONCE">Once</label><br>
        <input type = "radio" id = "DAY" name = "repeat" value = "DAY">
        <label for = "DAY">Daily</label><br>
        <input type = "radio" id = "WEEK" name = "repeat" value = "WEEK">
        <label for = "WEEK">Weekly</label><br>
        <input type = "radio" id = "BIWEEK" name = "repeat" value = "BIWEEK">
        <label for = "BIWEEK">Every 2 Weeks</label><br>
        <input type = "radio" id = "MONTH" name = "repeat" value = "MONTH">
        <label for = "MONTH">Monthly</label><br>
        <input type = "radio" id = "YEAR" name = "repeat" value = "YEAR">
        <label for = "YEAR">Yearly</label><br>
    </div> -->

    <!-- radio to select type of job -->
    Type: <span class = "red">*</span>
    <div style = "margin: 10px; margin-left: 0px">
        <input type = "radio" name = "Type" value = "DEADLINE" checked>
        <label for = "DEADLINE">Deadline</label><br>
        <input type = "radio" name = "Type" value = "INFORMATIONAL" <?php if ($type == "INFORMATIONAL") {echo "checked";} ?>>
        <label for = "INFORMATIONAL">Informational</label><br>
        <input type = "radio" name = "Type" value = "TODO" <?php if ($type == "TODO") {echo "checked";} ?>>
        <label for = "TODO">To Do</label><br>
        <input type = "radio" name = "Type" value = "EVENT" <?php if ($type == "EVENT") {echo "checked";} ?>>
        <label for = "EVENT">Event</label><br>
    </div>

    <!-- drop down to select group -->
    <label for = "Group">Select Group:</label>
    <select name = "Group">
        <?PHP
            // find groups user is in
            $sql = "SELECT * 
            FROM GROUPS 
            INNER JOIN USERS_GROUPS 
            ON GROUPS.GROUP_ID = USERS_GROUPS.GROUP_ID
            WHERE MEMBER_ID = $userid";
            $result = mysqli_query($db, $sql);

            // find groups user is owner of
            $sql2 = "SELECT *
            FROM GROUPS
            WHERE GROUP_OWNER = $userid
            ORDER BY GROUP_ID";
            $result2 = mysqli_query($db, $sql2);

            // display groups user is owner of and display personal group first if not group connected to job
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = " . $row2['GROUP_ID'];
                    if (isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
                        if ($groupID == $row2['GROUP_ID']) {echo " selected";} 
                    }
                    echo ">" . $row2['GROUP_NAME'] . "</option>";
                }
            }

            // display groups user is a part of and display group job is connected to
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['GROUP_ID'];
                    if (isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
                        if ($groupID == $row['GROUP_ID']) {echo " selected";} 
                    }
                    echo ">" . $row['GROUP_NAME'] . "</option>";
                }
            }
        ?>
    </select><br>

    <!-- drop down to select category -->
    <label for = "Category">Select Category:</label>
    <select name = "Category">
        <?PHP
            // find categories of user to display
            $sql = "SELECT * 
            FROM CATEGORY
            WHERE CATEGORY.USER_ID = $userid";
            $result = mysqli_query($db, $sql);
            
            // find category that is associated with job and user
            $sql2 = "SELECT *
            FROM CATEGORY_ASSOC
            INNER JOIN CATEGORY
            ON CATEGORY.CATEGORY_ID = CATEGORY_ASSOC.CATEGORY_ID
            WHERE CATEGORY_ASSOC.JOB_ID = $id
            AND CATEGORY.USER_ID = $userid";
            $result2 = mysqli_query($db, $sql2);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
            }

            echo "<option value = 'NONE'>None</option>";

            // display categories and select one that is connected to job
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['CATEGORY_ID'];
                    if (isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
                        if ($id == $row2['JOB_ID']) {echo " selected";}
                    }
                    echo ">" . $row['CATEGORY_NAME'] . "</option>";
                }
            } 

        ?>
    </select><br>

    <!-- text for comments to send with reminder -->
    <textarea name = "message" placeholder = "Comments/Info"><?php echo $message; ?></textarea>

    <!-- buttons to submit job/reminder or go back -->
    <button type = "submit" form = "jobform" value = "Save">Save</button>
    <button type = "button" id = "Cancel">Back</button>
</form>

<!-- script to make back button go to main page -->
<script>
    document.getElementById("Cancel").onclick = function () {
        location.href = "/index.php";
    };

    var monthImages = ["winter", "winter", "spring", "spring", "spring", "summer",
                        "summer", "summer", "autumn", "autumn", "autumn", "winter"];

    document.getElementsByTagName('html')[0].classList.add(monthImages[<?php echo date('m', $jobDate) ?> -1]);

</script>
