<?php 
  include_once 'db/test_db.php';
  include 'utils/debug.php';
  include 'templates/header.php';

  $name = 'Remind Me';
  echo "This is the $name App. This is PHP!";

  $sql = "SELECT * FROM test_table_0";
  if (!$result = $db->query($sql)) {
    echo "An error happened".$db->error;
  } else {
    tablify($result);
  }
  ?>

<div id="cal-container">

</div>

<?php
  include 'templates/footer.php'
?>

