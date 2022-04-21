<?php
require_once "includes/functions.php";
session_start();

// Retrieve all movies
#$movies = getDb()->query('select * from movie order by mov_id desc'); 
?>

<!doctype html>
<html>

<?php require_once "includes/head.php"; ?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>