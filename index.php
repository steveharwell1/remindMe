<?php 
  include_once 'utils/login_required.php';
  include_once 'db/test_db.php';
  include 'utils/debug.php';
  include 'templates/header.php';
  ?>

<div id="cal-container">
<?php
  include 'templates/calendarView.php';
?>
</div>
<div id = "groupView">
<?php
  include 'templates/groupView.php';
?>
</div>
<div id="CategoryView"> 
<?php
  include 'templates/CategoryView.php';
?>
</div>




<!-- overlays below here -->
<?php
  //include 'templates/jobView.php'
?>


<?php
  include 'templates/footer.php';
?>

