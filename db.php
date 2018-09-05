<?php
    $connection = mysqli_connect('sql2.freemysqlhosting.net', 'sql2255051', 'eE1*qG5!', 'sql2255051', '3306');
    // var_dump(function_exists('mysqli_connect'));
    if(!$connection) {
        echo "Database connection failed. shittt!";
    }