<?php
    $connection = mysqli_connect(getenv('BOT1DBSERVER'), getenv('BOT1DBUSERNAME'), getenv('BOT1DBPASSWORD'), getenv('BOT1DBTABLE'));
    if(!$connection) {
        die("Database connection failed!");
    }