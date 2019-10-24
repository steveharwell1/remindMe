<?php 
  include_once 'db/test_db.php';
  include 'utils/debug.php';
  include 'templates/header.php';
?>

<section>
<h1>Create Account</h1>
    <div>
        <form action="utils/create_user.php" method="POST">
            <input type="text" name="first_name" placeholder="Jane">
            <input type="text" name="last_name" placeholder="Doe">
            <input type="text" name="email" placeholder="email">
            <input type="password" name="passwd" placeholder="password">
            <button type="submit" name="submit">Create</button>
        </form>
    </div>
<section>


<?php
include 'templates/footer.php'
?>