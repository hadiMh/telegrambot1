<?php
	ini_set('error_reporting', 'E_ALL');
 
    $botToken = getenv('BOT1TOKEN');
    $webSite = "https://api.telegram.org/bot" . $botToken;
     
    $update = file_get_contents("php://input");
    $update = json_decode($update, TRUE);
     
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
     
    //CustomKeyBord
    $option = array(array("salam", "Key1"), array("key2", "key3"));
    $replyMarkup = array(
     'keyboard' => $option,
     'one_time_keyboard' => false,
     'resize_keyboard' => true,
     'selective' => true
    );
    $encodedMarkup = json_encode($replyMarkup, true);
     
    function sendMessage($chatId, $message, $r)
    {
     $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
     file_get_contents($url);
    }
     
    switch ($message) {
     
     case "/start":
     sendMessage($chatId, "شروع می کنیم", $encodedMarkup);
     break;
     case "salam":
     sendMessage($chatId, "salam be ruye mahet", $encodedMarkup);
     break;
     default:
     sendMessage($chatId, "chi migi ??", $encodedMarkup);
     
    }