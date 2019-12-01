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
    $jobDate = date('m/d/Y');
    $jobTime = date('H:i');
    $reminderDate = date('m/d/Y');
    $reminderTime = date('H:i');
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
            $title = $row['TITLE'];
            $jobDateTime = $row['DUE_DATE'];
            $jobDate = date('Y-m-d', strtotime($jobDateTime));
            $jobTime = date('H:i', strtotime($jobDateTime));
            $reminderDateTime = $row['REMINDER_TIME'];
            $reminderDate = date('Y-m-d', strtotime($reminderDateTime));
            $reminderTime = date('H:i', strtotime($reminderDateTime));
            //$repeat;
            $type = $row['JOB_TYPE'];
            $groupID = $row['GROUP_ID'];
            $message = $row['COMMENT'];
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
    <input type = "text" name = "jobname" value = "<?php echo $title; ?>"><br>

    <!-- date field for date of job -->
    Date of Event <span class = "red">*</span><br>
    <input type = "date" name = "duedate" value = "<?php echo $jobDate; ?>" />
    <?php 
        if(isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
            echo "<input type = 'time' name = 'duetime' value = " . $jobTime . ">";
        }
        else {
            echo "<input type = 'time' name = 'duetime' value = '12:00'>";
        }
        ?>
    <br>

    <!-- reminder date -->
    Date to be Reminded <span class = "red">*</span><br>
    <input type = "date" name = "remindDate" value = "<?php echo $reminderDate; ?>" />
    <?php 
        if(isset($_POST['reminderID']) && !empty($_POST['reminderID'])) {
            echo "<input type = 'time' name = 'remindTime' value = " . $reminderTime . ">";
        }
        else {
            echo "<input type = 'time' name = 'remindTime' value = '12:00'>";
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
        <input type = "radio" name = "Type" value = "DEADLINE" <?php if ($type == "DEADLINE") {echo "checked";} ?>>
        <label for = "DEADLINE">Deadline</label><br>
        <input type = "radio" name = "Type" value = "INFORMATIONAL" <?php if ($type == "INFORMATIONAL") {echo "checked";} ?>>
        <label for = "INFORMATIONAL">Informational</label><br>
        <input type = "radio" name = "Type" value = "TODO" <?php if ($type == "TODO") {echo "checked";} ?>>
        <label for = "TODO">To Do</label><br>
        <input type = "radio" name = "Type" value = "EVENT" <?php if ($type == "EVENT") {echo "checked";} ?>>
        <label for = "EVENT">Event</label><br>
    </div>

    <!-- drop down to select group -->
    <select name = "Group">
        <?PHP
            #$usergroup = $_SESSION['group_id'];

            $sql = "SELECT * 
            FROM GROUPS 
            INNER JOIN USERS_GROUPS 
            ON GROUPS.GROUP_ID = USERS_GROUPS.GROUP_ID
            WHERE MEMBER_ID = $userid";
            $result = mysqli_query($db, $sql);

            echo "<option value = '' disabled selected>Select Group</option>";
            echo "<option value = ''>None</option>";

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['GROUP_ID'];
                    if ($groupID == $row['GROUP_ID']) {echo " selected";} 
                    echo ">" . $row['GROUP_NAME'] . "</option>";
                }
            } else {
                //empty
            }

        ?>
    </select>

    <!-- drop down to select category -->
    <select name = "Category">
        <?PHP

            $sql = "SELECT * 
            FROM CATEGORY
            WHERE CATEGORY.USER_ID = $userid";
            $result = mysqli_query($db, $sql);

            $sql2 = "SELECT *
            FROM CATEGORY_ASSOC
            WHERE CATEGORY_ASSOC.JOB_ID = $id";
            $result2 = mysqli_query($db, $sql2);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
            }

            echo "<option value = '' disabled selected>Select Category</option>";
            echo "<option value = ''>None</option>";

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['CATEGORY_ID'];
                    if ($id == $row2['JOB_ID']) {echo " selected";}
                    echo ">" . $row['CATEGORY_NAME'] . "</option>";
                }
            } else {
                //empty
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
</script>
