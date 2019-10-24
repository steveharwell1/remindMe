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
<div id="CategoryView"> 
<?php
  include 'templates/CategoryView.php'
?>

<h2>CATEGORIES</h2>

<ul>
  <li>G1: Category Name</li>
    <ul>
      <li>Job 1</li>
      <li>Job 2</li>
    </ul>
  <li>G2: Category Name</li>
      <ul>
      <li>Job 1</li>
      <li>Job 2</li>
    </ul>
</ul>
</div>

<div id = "groupView">
<?php
  include 'templates/groupView.php'
?>
</div>

<div id = "jobView">
<?php
  include 'templates/jobView.php'
?>
</div>


<?php
  include 'templates/footer.php'
?>

