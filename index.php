<?php 
  include_once 'utils/login_required.php';
  include_once 'db/test_db.php';
  include 'utils/debug.php';
  include 'templates/header.php';
  ?>

<div id="cal-container">
  Hello <?php
  if (isset($_SESSION['user_id']))
  {
    echo $_SESSION['user_first_name'];
  }
  else {
    echo "You are not logged in!";
  }
  
  ?>!
</div>

<?php
  include 'templates/footer.php'
?>

