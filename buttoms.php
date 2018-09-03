<?php
    // answer 1
    $option = array(array("salam", "Key1"), array("key2", "key3"));
    $replyMarkup = array(
    'keyboard' => $option,
    'one_time_keyboard' => false,
    'resize_keyboard' => true,
    'selective' => true
    );
    $encodedMarkup = json_encode($replyMarkup, true);