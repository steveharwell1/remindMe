<?php 
  include_once '../utils/login_required.php';
  include_once '../db/test_db.php';
  include '../utils/debug.php';
  include 'header.php';

  $date = $_POST['date'];

?>

<form action = "../controllers/jobController.php" method = "post" id = "jobform">

    <!-- text field for job title -->
    Job Name <span class = "red">*</span><br>
    <input type = "text" name = "jobname"><br>

    <!-- date field for date of job -->
    Date of Event <span class = "red">*</span><br>
    <input type = "date" name = "duedate" value = "<?php echo $date?>" /><input type = "time" name = "duetime"><br>

    <!-- reminder date -->
    Date to be Reminded <span class = "red">*</span><br>
    <input type = "date" name = "remindDate"><input type = "time" name = "remindTime"><br>

    <!-- radio field for how often to repeat remeinder -->
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
    </div>

    <!-- drop down to select type of job -->
    <select name = "Type">
        <option value = "none" disabled selected>Select Type</option>
        <option value = "DEADLINE">Deadline</option>
        <option value = "INFORMATIONAL">Informational</option>
        <option value = "TODO">To Do</option>
        <option value = "EVENT">Event</option>
    </select><span class = "red">*</span><br>

    <!-- drop down to select group -->
    <select name = "Group">
        <?PHP
            $userid = $_SESSION['user_id'];
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
                    echo "<option value = " . $row['GROUP_ID'] . ">" . $row['GROUP_NAME'] . "</option>";
                }
            } else {
                //empty
            }

        ?>
    </select>

    <!-- drop down to select category -->
    <select name = "Category">
        <?PHP
            $userid = $_SESSION['user_id'];

            $sql = "SELECT * 
            FROM CATEGORY
            WHERE CATEGORY.USER_ID = $userid";
            $result = mysqli_query($db, $sql);

            echo "<option value = '' disabled selected>Select Category</option>";
            echo "<option value = ''>None</option>";

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['CATEGORY_ID'] . ">" . $row['CATEGORY_NAME'] . "</option>";
                }
            } else {
                //empty
            }

        ?>
    </select><br>

    <!-- text for comments to send with reminder -->
    <textarea name = "message" placeholder = "Comments/Info"></textarea>

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
