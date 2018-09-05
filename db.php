<?php
    /* connect to the database. (Note: using the enviromental variables) */
    $connection = mysqli_connect('www.db4free.net', 'hadimh', 'mhdh1999', 'hadidb', '3306');
    if(!$connection) {
        echo "Database connection failed. shittt!";
    }