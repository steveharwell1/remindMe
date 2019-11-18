<?php 
  include_once '../utils/login_required.php';
  include_once '../db/test_db.php';
  include '../utils/debug.php';
  include 'header.php';

  $date = $_POST['date'];

?>

<form action = "../controllers/jobController.php" method = "post" id = "jobform">
    Job Name<br>
    <input type = "text" name = "jobname"><br>

    Due Date<br>
    <input type = "date" name = "duedate" value = "<?php echo $date?>" /><input type = "time" name = "duetime"><br>

    Reminder Date<br>
    <input type = "date" name = "remindDate"><input type = "time" name = "remindTime"><br>

    Repeat Every<br>
    <div style = "margin: 10px; margin-left: 0px">
        <input type = "radio" id = "ONCE" name = "repeat" value = "ONCE">
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
    <select name = "Type">
        <option value = "none" disabled selected>Select Type</option>
        <option value = "DEADLINE">Deadline</option>
        <option value = "INFORMATIONAL">Informational</option>
        <option value = "TODO">To Do</option>
        <option value = "EVENT">Event</option>
    </select><br>
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

            echo "<option value = 'NULL' disabled selected>Select Group</option>";
            echo "<option value = 'NULL'>None</option>";

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['GROUP_ID'] . ">" . $row['GROUP_NAME'] . "</option>";
                }
            } else {
                echo "<option value = 'NULL'></option>";
            }

        ?>
    </select>
    <select name = "Category">
        <?PHP
            $userid = $_SESSION['user_id'];

            $sql = "SELECT * 
            FROM CATEGORY
            WHERE CATEGORY.USER_ID = $userid";
            $result = mysqli_query($db, $sql);

            echo "<option value = 'NULL' disabled selected>Select Category</option>";
            echo "<option value = 'NULL'>None</option>";

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value = " . $row['CATEGORY_ID'] . ">" . $row['CATEGORY_NAME'] . "</option>";
                }
            } else {
                echo "<option value = 'NULL'></option>";
            }

        ?>
    </select><br>
    <textarea name = "message" placeholder = "Comments/Info"></textarea>
    <button type = "submit" form = "jobform" value = "Save">Save</button>
    <button type = "button" id = "Cancel">Cancel</button>
</form>

<script>
    document.getElementById("Cancel").onclick = function () {
        location.href = "/index.php";
    };
</script>
