<?php
    $connection = mysqli_connect(getenv('BOT1DBSERVER'), getenv('BOT1DBUSERNAME'), getenv('BOT1DBPASSWORD'), getenv('BOT1DBTABLE'));
    // var_dump(function_exists('mysqli_connect'));
    if(!$connection) {
        echo "Database connection failed. shit!";
    }