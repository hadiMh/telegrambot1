<?php
    include "db.php";
    include "buttoms.php";
    include "functions.php";
	ini_set('error_reporting', 'E_ALL');
 
    $botToken = getenv('BOT1TOKEN');
    $webSite = "https://api.telegram.org/bot" . $botToken;
     
    $update = file_get_contents("php://input");
    $update = json_decode($update, TRUE);
     
    $name = $update['message']['from']['first_name'];
    $userId = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    $query = "INSERT INTO table1 (name, from_id, from_firstname, from_username, chat_id, data)";
    $query .=" VALUES ('$name', '$userId', '$username', '$chatId', '$message')";
    $result = mysqli_query($connection, $query);
    if(!$result) {
        sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- ".$query, returnEM($buttoms[0]));
    } else {
        sendMessage($chatId, "RECORD UPDATED!", returnEM($buttoms[0]));
    }

    switch ($message) {
     
        case "/start":
            sendMessage($chatId, "سلام\nبه ربات کاملا رایگان تست شخصیت خوش آمدین\nما اینجا یه تست استاندارد به روز و جدید از شما میگیریم و به شما میگیم که چه نوع شخصیتی دارید. این تست بیش از چند دقیقه وقت نمیخواد.\nیادت باشه هیچ دکمه ای رو دوبار نزنی وگرنه نتیجه اشتباه حساب میشه\nپس بزن بریم. روی دکمه شروع کلیک کن", returnEM(array(array("شروع"))));
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