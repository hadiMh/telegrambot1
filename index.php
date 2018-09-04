<?php
    include "db.php";
    include "buttoms.php";
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


    switch ($message) {
     
        case "/start":
            sendMessage($chatId, "سلام. به ربات ارسال پیام خوش آمدید.\nهر پیامی که به من بفرستید مستقیم به برنامه نویس منتقل میشود و ایشون در اولین فرصت پاسخ شما را میدهند.\nپیام های هود را بفرستید:", $encodedMarkup);
            break;
        case "salam":
            sendMessage($chatId, "salam be ruye mahet", $encodedMarkup);
            break;
        case "/myid":
            sendMessage($chatId, "chatId: $chatId,  userId: $userId", $encodedMarkup);
        case "شروع":
            sendMessage($chatId, "سوال 1:", $q1em);
            break;
        case "1":
            sendMessage($chatId, "سوال اول:", returnEM($buttoms[1]));
            sendMessage($chatId, $questions[1], returnEM($buttoms[1]));
            break;
        default:
            sendMessage(684295622, "@$username:\n\n$message", $encodedMarkup);
            sendMessage($chatId, "پیام شما با موفقیت ارسال شد. شما میتوانید باز هم پیام ارسال کنید:", $encodedMarkup);
     
    }