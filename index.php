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
            sendMessage($chatId, "سلام\nبه ربات کاملا رایگان تست شخصیت خوش آمدین\nما اینجا یه تست استاندارد به روز و جدید از شما میگیریم و به شما میگیم که چه نوع شخصیتی دارید. این تست بیش از چند دقیقه وقت نمیخواد.\nیادت باشه هیچ دکمه ای رو دوبار نزنی وگرنه نتیجه اشتباه حساب میشه\nپس بزن بریم. روی دکمه شروع کلیک کن", returnEM(array("شروع")));
            break;
        case "شروع":
            sendMessage($chatId, "", returnEM(array("شروع")));
            break;
        case "شروع":
        sendMessage($chatId, "سوال اول:"."\n".$questions[0], returnEM($buttoms[0]));
            break;
        case "1":
            sendMessage($chatId, "سوال اول:"."\n".$questions[0], returnEM($buttoms[0]));
            break;
        default:
            sendMessage(684295622, "@$username:\n\n$message", $encodedMarkup);
            sendMessage($chatId, "پیام شما با موفقیت ارسال شد. شما میتوانید باز هم پیام ارسال کنید:", $encodedMarkup);
     
    }