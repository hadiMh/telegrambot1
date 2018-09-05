<?php

    /* error logging configration */
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', dirname(__FILE__) . '/log.txt');
    ini_set('error_reporting', 'E_ALL');

    include "db.php"; /* connects to the database */
    include "buttoms.php"; /* contains: questions, answers, choises, marks and buttoms */
    include "functions.php";

    $botToken = getenv('BOT1TOKEN');
    $webSite = "https://api.telegram.org/bot" . $botToken;

    /* the json recieves from the telegram api */
    $update = file_get_contents("php://input");
    $update = json_decode($update, TRUE);
     
    /* save the recieved json data seperately */
    $name = $update['message']['from']['first_name'];
    $userId = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];

    /* check if the user exists. if not add it to the database */
    addUserIfDoesntExist();
    if(hasUserStartedTheGame() and canUserContinueGame()){
        addGamePostionInDb();
        sendQuestion();
    }
    $userAnswer = isItAValidChoise(faNumToEn($message));
    if(getGamePositionFromDb()==$MAXNUMBER+2){
        sendMessage($chatId, "شما قبلا این آزمون را پاسخ داده اید. امتیاز شما 80 شده است.", returnEMhide());
    }else if (hasUserStartedTheGame() and isItAValidChoise(faNumToEn($message))){    
        if(getGamePositionFromDb()<=$MAXNUMBER+1){
            saveUserAnswer($userAnswer);
            if(getGamePositionFromDb()==$MAXNUMBER+1) 
            {
                addGamePostionInDb();
                sendMessage($chatId, "تبریک. شما به همه سوالای این آزمون جواب دادین. امتیاز شما 89 می باشد.", returnEMhide());
            }
        }
    } else {
        switch ($message) {
            case "/start":
                sendMessage($chatId, "سلام\nبه ربات کاملا رایگان تست شخصیت خوش آمدین\nما اینجا یه تست استاندارد به روز و جدید از شما میگیریم و به شما میگیم که چه نوع شخصیتی دارید. این تست بیش از چند دقیقه وقت نمیخواد.\nیادت باشه هیچ دکمه ای رو دوبار نزنی وگرنه نتیجه اشتباه حساب میشه\nپس بزن بریم. روی دکمه شروع کلیک کن", returnEMt(array(array("شروع"))));
                break;
            case "شروع":
                addGamePostionInDb();
                sendQuestion();
                break;
            default:
                sendMessage(684295622, "@$username:\nn\n$message");
                sendMessage($chatId, "پیام شما با موفقیت ارسال شد. شما میتوانید باز هم پیام ارسال کنید:");
        }
    }
    