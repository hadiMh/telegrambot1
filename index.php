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

    /* Check if the user exists. if not add it to the database */
    addUserIfDoesntExist();


    /* TASK: Get the id of the inviter if it is an invited user or say hi if it is a normal link. */
    if (strpos($message, '/start') !== false) {
        if(strlen($message)>6) {
            preg_match('(\d+)', $message, $matches);
            addInvitedUserIdToInviterList($matches[0]);
        }
        sendMessage($chatId, "سلام\nبه ربات کاملا رایگان تست شخصیت خوش آمدین\nما اینجا یه تست استاندارد به روز و جدید از شما میگیریم و به شما میگیم که چه نوع شخصیتی دارید. این تست بیش از چند دقیقه وقت نمیخواد.\nیادت باشه هیچ دکمه ای رو دوبار نزنی وگرنه نتیجه اشتباه حساب میشه\nپس بزن بریم. روی دکمه شروع کلیک کن", returnEMt(array(array("شروع"))));
    }
    
    /* TASK: if user wants to start the exam. */
    if( $message === "شروع" ) {
        if(hasUserStartedTheGame() and canUserContinueGame()){
            addGamePostionInDb();
            sendQuestion();
        } else {
            sendMessage($chatId, "شما قبلا این آزمون رو تمام کرده اید.", returnEMt($btn_finishedExam));
        }
    }

    /* TASK: Ask questions if user is in the exam stage. */
    else if(hasUserStartedTheGame() and canUserContinueGame()){
        addGamePostionInDb();
        sendQuestion();
    }
    
    /* Check if user's answer is valid. */
    $userAnswer = isItAValidChoise(faNumToEn($message));

    /* TASK: If user has completed the exam. */
    if(getGamePositionFromDb()==$MAXNUMBER+2){
        // sendMessage($chatId, "شما قبلا این آزمون را پاسخ داده اید. امتیاز شما ".calculateUserScore()." شده است.", returnEMhide());
        switch ($message) {
            case "charac":
                if(!checkInvitesAreEnough()){
                    sendMessage($chatId, " برای دیدن نتیجه آزمون باید برای سه نفر لینک زیر را بفرستید. زمانی که سه نفر از طریق لینک زیر وارد ربات شوند نتیجه آزمون با تمام توضیحات مهم روانشناسی برای شما ارسال میشود. \nنکته جالب این است که هر زمان کسی با لینک شما وارد ربات شود، ربات به شما پیامی ارسال میکند و شما را مطلع میکند", returnEMhide());
                }
                break;
            case "امتیاز من":
                sendMessage($chatId, "امتیاز شما:  ".calculateUserScore(), returnEMt($btn_finishedExam));
                break;
            case "دعوت دیگران":
                sendMessage($chatId, "ربات تست شخصیت:\nبیا توی این ربات و ببین شخصیتت چیه. این یکی از آخرین و بروزترین تست های شخصیت اروپاست.\nپس منتظر چی هستی؟ روی لینک زیر کلیک کن و توی کمتر از یک دقیقه ببین چه شخصیتی داری\n https://t.me/hadiprobot?start=".$userId, returnEMt($btn_finishedExam));
                sendMessage($chatId, "لینک بالا رو برای دیگران بفرست. هروقت کسی با این لینک وارد ربات بشه بهت اطلاع میدم. وقتی 3 تا عضو جدید از طریق این لینک وارد ربات بشن میگم چه شخصیتی داری. پس منتظر چی هستی؟ بفرست تا ببینی چه شخصیتی داری.", returnEMt($btn_finishedExam));
                break;
        }
    }
    /* TASK: If the user sent an answer to a question. */
    else if (hasUserStartedTheGame() and isItAValidChoise(faNumToEn($message))){    
        if(getGamePositionFromDb()<=$MAXNUMBER+1){
            saveUserAnswer($userAnswer);
        }
        /* TASK: if user has finished the exam. */
        if(getGamePositionFromDb()==$MAXNUMBER+1) 
        {
            sendMessage($chatId, "hihihihhh", returnEMhide());
            sendMessage($chatId, "تبریک. شما به همه سوالای این آزمون جواب دادین. امتیاز شما ".calculateUserScore()." می باشد.", returnEMt($btn_finishedExam));
            addGamePostionInDb();
            // showTheCharacteristic();
        }
    }
