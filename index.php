<?php
    $connection = mysqli_connect(getenv('BOT1DBSERVER')+"/hadidb", getenv('BOT1DBUSERNAME'), getenv('BOT1DBPASSWORD'), getenv('BOT1DBTABLE'));
    // var_dump(function_exists('mysqli_connect'));
    if(!$connection) {
        echo "Database connection failed. shittt!";
    }
	ini_set('error_reporting', 'E_ALL');
 
    $botToken = getenv('BOT1TOKEN');
    $webSite = "https://api.telegram.org/bot" . $botToken;
     
    $update = file_get_contents("php://input");
    $update = json_decode($update, TRUE);
     
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
     
    //CustomKeyBord
    // answer 1
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
     $query = "INSERT INTO `table1`(`name`, `from_id`, `from_firstname`, `from_username`, `chat_id`, `data`) VALUES ('111','222','333','444','555','666')";

     $result = mysqli_query($connection, $query);
     if($result) {
        echo "Record Created";
     } else {
        die('Query Failed!');
     }
     sendMessage($chatId, "salam be ruye mahet", $encodedMarkup);
     break;
     default:
     sendMessage($chatId, "chi migi ??", $encodedMarkup);
     
    }