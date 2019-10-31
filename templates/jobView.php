<html>
<head>
<style>

input:not([type = "radio"]) {
    border: none;
    border-bottom: 1px solid black;
    margin: 10px;
    margin-left: 0px;
}
textarea {
    border: 1px solid black;
    height: 75px;
    width: 300px;
    margin: 10px;
    margin-left: 0px;
}
select {
    border: none;
    border-bottom: 1px solid black;
    margin: 10px;
    margin-left: 0px;
}
form {
    border: 1px solid black;
    padding: 10px;
    width: 300px;
}
</style>
</head>

<body>
<form method = "post" id = "jobform">
    Job Name<br>
    <input type = "text" name = "jobname"><br>
    Date/Time<br>
    <input type = "date" name = "duedate"><input type = "time" name = "duetime"><br>
    Reminder Time<br>
    <div style = "margin: 10px; margin-left: 0px">
        <input type = "radio" id = "onTime" name = "remindTime" value = "onTime">
        <label for = "onTime">On Time</label><br>
        <input type = "radio" id = "30min" name = "remindTime" value = "30min">
        <label for = "30">30 minutes before</label><br>
        <input type = "radio" id = "1hour" name = "remindTime" value = "1hour">
        <label for = "1hour">1 hour before</label><br>
        <input type = "radio" id = "2hours" name = "remindTime" value = "2hours">
        <label for = "2hours">2 hours before</label><br>
        <input type = "radio" id = "1day" name = "remindTime" value = "1day">
        <label for = "1day">1 day before</label><br>
        <input type = "radio" id = "1week" name = "remindTime" value = "1week">
        <label for = "1week">1 week before</label><br>
    </div>
    <select id = "Group">
        <option value = "none" disabled selected>Select Group</option>
        <option value = "none">None</option>
        <option value = "work">Work</option>
        <option value = "school">School</option>
        <option value = "family">Family</option>
    </select>
    <select id = "Category">
        <option value = "none" disabled selected>Select Category</option>
        <option value = "none">None</option>
        <option value = "birthday">Birthday</option>
        <option value = "work">Work</option>
        <option value = "assignment">Assignment</option>
    </select><br>
    <textarea placeholder = "Comments/Info"></textarea>
    <button type = "button" form = "jobform" value = "Save">Save</button>
    <button type = "button" form = "jobform" value = "Cancel">Cancel</button>
</form>

</body>
</html>