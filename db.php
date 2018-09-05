<?php
    /* connect to the database. (Note: using the enviromental variables) */
    $connection = mysqli_connect(getenv('BOT1DBSERVER'), getenv('BOT1DBUSERNAME'), getenv('BOT1DBPASSWORD'), getenv('BOT1DBTABLE'), '3307');
    if(!$connection) {
        echo "Database connection failed. shittt!";
    }