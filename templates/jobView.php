<?php 
  include_once '../utils/login_required.php';
  include_once '../db/test_db.php';
  include '../utils/debug.php';
  include 'header.php';
?>

<form action = "jobController.php" method = "post" id = "jobform">
    Job Name<br>
    <input type = "text" name = "jobname"><br>

    Due Date<br>
    <input type = "date" name = "duedate"><input type = "time" name = "duetime"><br>

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
        <option value = "none" disabled selected>Select Group</option>
        <option value = "none">None</option>
        <option value = "work">Work</option>
        <option value = "school">School</option>
        <option value = "family">Family</option>
    </select>
    <select name = "Category">
        <option value = "none" disabled selected>Select Category</option>
        <option value = "none">None</option>
        <option value = "birthday">Birthday</option>
        <option value = "work">Work</option>
        <option value = "assignment">Assignment</option>
    </select><br>
    <textarea name = "message" placeholder = "Comments/Info"></textarea>
    <button type = "submit" form = "jobform" value = "Save">Save</button>
    <button type = "button" form = "jobform" value = "Cancel">Cancel</button>
</form>

<?PHP


?>
