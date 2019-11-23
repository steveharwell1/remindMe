<?php 
  include_once '../utils/login_required.php';
  include_once '../db/test_db.php';
  include '../utils/debug.php';
  //include 'header.php';

?>
<h2> CATEGORIES </h2>
<form action = "../controllers/CategoryController.php" method = "post">
    Create
    <input type = "color" name = "createColor" value = "black" />
    <input type = "text" name = "createTitle" placeholder="New Category">
    <button type = "submit" name = 'submit' value = 'create'> Create </button>
    </form>
    <form action = "../controllers/CategoryController.php" method = "post">
    <br>
     Category
     <input type = "color" name = "updateColor" value = "black" />

    <select name = "Type">
    <?php
     $userid = $_SESSION['user_id'];

   $sql = "SELECT * 
   FROM CATEGORY
   WHERE CATEGORY.USER_ID = $userid";
   $result = mysqli_query($db, $sql);

   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
           echo "<option value = " . $row['CATEGORY_ID'] . ">" . $row['CATEGORY_NAME'] . "</option>";
       }
   } else {
       echo "<option value = 'NULL'></option>";
   }
   ?>
</select>
<button type = "submit" name = 'submit' value = 'update'> update </button>
</form>
<form action = "../controllers/CategoryController.php" method = "post">
<?php
$userid = $_SESSION['user_id'];

   $sql = "SELECT * 
   FROM CATEGORY
   WHERE CATEGORY.USER_ID = $userid";
   $result = mysqli_query($db, $sql);

   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
           $color = $row[ 'color'];
           echo "<h3 style=\"color: $color;\">" . $row['CATEGORY_NAME'] . "</h3>";

    //loop through reminder in category
    $sql = "SELECT * 
   FROM CATEGORY_ASSOC
   INNER JOIN JOBS
   ON CATEGORY_ASSOC.JOB_ID = JOBS.JOB_ID
   WHERE CATEGORY_ID = ".$row['CATEGORY_ID'];
   $Reresult = mysqli_query($db, $sql);

   if ($Reresult->num_rows > 0) {
       echo "<ul>";
       while($Rerow = $Reresult->fetch_assoc()) {
           $color = $row[ 'color'];
           echo "<li style=\"color: $color;\">" . $Rerow['TITLE'] . "</li>";
       }
       echo "</ul>";
   } 
       }
   } 
   
   echo '<select name="deleteID">';
   $sql = "SELECT * 
   FROM CATEGORY
   WHERE CATEGORY.USER_ID = $userid";
   $result = mysqli_query($db, $sql);

   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
           echo "<option value = " . $row['CATEGORY_ID'] . ">" . $row['CATEGORY_NAME'] . "</option>";
       }
   } else {
       echo "<option value = 'NULL'></option>";
   }
   ?>
</select>
<input type="checkbox" name = "Confirm"/> 
<button type = "submit" name = 'submit' value = 'delete'> Delete</button>

</form>