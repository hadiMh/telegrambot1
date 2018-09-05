<?php
    $connection = mysqli_connect('db4free.net', 'root', 'hadimh', 'hadidb', '3306'/* getenv('BOT1DBSERVER'), getenv('BOT1DBUSERNAME'), getenv('BOT1DBPASSWORD') '', getenv('BOT1DBTABLE'), '3306' */);
    // var_dump(function_exists('mysqli_connect'));
    if(!$connection) {
        echo "Database connection failed. shittt!";
        echo "\nDebugging error: " . mysqli_connect_error();
    }