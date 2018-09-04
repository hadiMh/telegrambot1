<?php
// answer 1
    $option = array(array("salam", "Key1"), array("key2", "key3"), array("شروع"));
    $replyMarkup = array(
        'keyboard' => $option,
        'one_time_keyboard' => false,
        'resize_keyboard' => true,
        'selective' => true
    );
    $encodedMarkup = json_encode($replyMarkup, true);



// question 1
    // quersion 1 option
    $q1o = array(array('a)صبح','a)عصر و غروب'), array('a)شب'));
    // question 1 reply markup
    $q1rm = array(
        'keyboard' => $q1o,
        'one_time_keyboard' => false,
        'resize_keyboard' => true,
        'selective' => true
    );
    // question 1 encoded markup
    $q1em = json_encode($q1rm, true);