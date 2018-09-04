<?php
    include "db.php";
    include "functions.php";
	ini_set('error_reporting', 'E_ALL');
 
    $botToken = getenv('BOT1TOKEN');
    $webSite = "https://api.telegram.org/bot" . $botToken;
     
    $update = file_get_contents("php://input");
    $update = json_decode($update, TRUE);
     
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $userId = $update["message"]["chat"]["id"];
    $username = $update["message"]["from"]["username"];

    //CustomKeyBord
    include "buttoms.php";

    switch ($message) {
     
        case "/start":
            sendMessage($chatId, "سلام. به ربات ارسال پیام خوش آمدید.\nهر پیامی که به من بفرستید مستقیم به برنامه نویس منتقل میشود و ایشون در اولین فرصت پاسخ شما را میدهند.\nپیام های هود را بفرستید:", $encodedMarkup);
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
        case "/myid":
            sendMessage($chatId, "chatId: $chatId,  userId: $userId", $encodedMarkup);
        default:
            sendMessage(684295622, "@$username:\n\n$message", $encodedMarkup);
            sendMessage($chatId, "پیام شما به موفقیت ارسال شد. شما میتوانید باز هم پیام ارسال کنید:", $encodedMarkup);
     
    }