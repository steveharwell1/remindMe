<?php 
  include_once 'db/test_db.php';
  include 'utils/debug.php';
  include 'templates/header.php';
?>

<section>
<h1>Log In</h1>
    <div>
        <form action="utils/login_user.php" method="POST">
            <input type="text" name="email" placeholder="email">
            <input type="password" name="passwd" placeholder="password">
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
    <a href="create.php">Create Account</a>
<section>


<?php
include 'templates/footer.php'
?>