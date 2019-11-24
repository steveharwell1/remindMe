<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Remind Me!</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <header>
        <nav>

            <?php if(isset($_SESSION['user_id'])) {?>
            <form action="/utils/logout_user.php" method="POST">
                <button type="submit" name="submit">Logout</button>
            </form>
            <?php }?>
            <?php if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
                echo '<div id="error-container" class = "red">';
                while (count($_SESSION['errors']) > 0) {
                    echo '<p>'.array_pop($_SESSION['errors']).'</p>';
                }
                echo '</div>';
            } ?>
        </nav>

    </header>  
