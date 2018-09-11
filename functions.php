<?php
    function sendMessage($chatId, $message, $r)
    {
        $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
        file_get_contents($url);
    }

    /* change the english numbers to the persian numbers */
    function enNumToFa($string) {
        return strtr($string, array('0'=>'۰', '1'=>'۱', '2'=>'۲', '3'=>'۳', '4'=>'۴', '5'=>'۵', '6'=>'۶', '7'=>'۷', '8'=>'۸', '9'=>'۹'));
    }

    /* change the persian numbers to the english numbers */
    function faNumToEn($string) {
        return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9'));
    }

    /* see if the user doesn't exist add he/she to the database */
    function addUserIfDoesntExist() {
        global $connection;
        global $userId;
        global $chatId;
        global $name;
        global $username;

        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row_cnt = mysqli_num_rows($result);
        if(!$row_cnt){
            $query = "INSERT INTO table1 (from_id, from_firstname, from_username, chat_id,game_position, user_answers)";
            $query .=" VALUES ('$userId', '$name', '$username', '$chatId', 0, '{}')";
            $result = mysqli_query($connection, $query);
            /* if(!$result) {
                sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- " . $query. " ". mysqli_error(), returnEM(array(array("worked!"))));
            } else {
                sendMessage($chatId, "USER ADDED!", returnEM(array(array("worked!"))));
            } */
        } else {
            /* sendMessage($chatId, "USER EXISTED!".$row_cnt, returnEM(array(array("worked!")))); */
        }
    }

    /* add a choise number to the begenning of the choises */
    function addNumbers($buttomArray) {
        $num = 1;
        for($i = 0; $i < count($buttomArray); $i++)
            for($j = 0; $j < count($buttomArray[$i]); $j++) {
                $buttomArray[$i][$j] = enNumToFa($num)."- " . $buttomArray[$i][$j];
                $num++;
            }
        return $buttomArray;
    }

    function returnEM($buttomArray) { // create a basic encoded markaup for givven buttoms
        $buttomArray = addNumbers($buttomArray);
        $rm = array(
            'keyboard' => $buttomArray,
            'one_time_keyboard' => false,
            'resize_keyboard' => true,
            'selective' => true
        );
        return json_encode($rm, true);
    }

    function returnEMt($buttomArray) { // create a basic encoded markaup for givven texts
        $rm = array(
            'keyboard' => $buttomArray,
            'one_time_keyboard' => false,
            'resize_keyboard' => true,
            'selective' => true
        );
        return json_encode($rm, true);
    }

    function returnEMhide() { /* hide the buttom keyboard */
        $rm = array(
            'hide_keyboard' => true
        );
        return json_encode($rm, true);
    }

    /* get the user game position from db */
    function getGamePositionFromDb() {
        global $connection;
        global $userId;
        global $chatId;

        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $gamePostion = $row['game_position'];
        return $gamePostion;
    }

    /* get the game position number of the user and increase it by 1 */
    function addGamePostionInDb() {
        global $connection;
        global $userId;
        global $chatId;

        $lastPostion = getGamePositionFromDb();
        $newPostion = $lastPostion+1;
        $query = "UPDATE table1 SET ";
        $query .= "game_position = '$newPostion' ";
        $query .= "WHERE from_id = $userId ";
    
        $result = mysqli_query($connection, $query);
        /* if(!$result) {
            sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- ".$query, returnEM(array(array("worked!"))));
        } else {
            sendMessage($chatId, "RECORD UPDATED! before: $lastPostion -- after: ".getGamePositionFromDb() , returnEM(array(array("worked!"))));
        } */
    }

    function hasUserStartedTheGame() {
        $userGamePosition = getGamePositionFromDb();
        sendMessage($chatId, $userGamePosition, returnEM(array(array("worked!"))));
        if($userGamePosition == 0)
            return 0;
        return 1;
    }

    function canUserContinueGame() {
        global $MAXNUMBER;
        $userGamePosition = getGamePositionFromDb();
        if($userGamePosition > $MAXNUMBER)
            return false;
        return true;
    }

    function hadUserFinishedTheGame() {
        global $MAXNUMBER;
        $userGamePosition = getGamePositionFromDb();
        if($userGamePosition > $MAXNUMBER+1)
            return true;
        return false;
    }

    /* checks if the user send an answer of one of the questions */
    /* 
    * @params  $text : the text that user sent to the robot    
    */
    function isItAValidChoise($text) {
        $matches;
        preg_match('/^[0-9]/', $text, $matches, PREG_OFFSET_CAPTURE);
        $json = json_encode($matches);
        if ($json === "[]") /* invalid answer */
            return 0;
        return $matches[0][0]; /* valid answer */
    }

    function getUserAnswers() {

    }

    function saveUserAnswer($answer) {
        global $buttoms;
        global $connection;
        global $userId;
        global $chatId;
        $gamePosition = getGamePositionFromDb();
        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $answerJson = $row['user_answers'];
        $answerArray = json_decode($answerJson, true);
        // sendMessage($chatId, gettype($answerJson).gettype($answerArray), returnEM($buttoms[0]));
        $answerArray[$gamePosition-1] = $answer;
        // sendMessage($chatId, "111regex captured", returnEM($buttoms[0]));
        $newAnswerJson = json_encode($answerArray);
        // sendMessage($chatId, $newAnswerJson, returnEM($buttoms[0]));
        $query = "UPDATE table1 SET ";
        $query .= "user_answers = '$newAnswerJson' ";
        $query .= "WHERE from_id = $userId ";
    
        $result = mysqli_query($connection, $query);
        /* if(!$result) {
            sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- ".$query."\n-- saveUserAnswer() function", returnEM(array(array("worked!"))));
        } else {
            sendMessage($chatId, "$newAnswerJson\nRECORD UPDATED! before: $lastPostion -- after: ".getGamePositionFromDb() . "\n-- saveUserAnswer() function" , returnEM(array(array("worked!"))));
        } */
    }

    function sendQuestion() {
        global $buttoms;
        global $questions;
        global $connection;
        global $userId;
        global $chatId;
        if(canUserContinueGame()){
            $gamePosition = getGamePositionFromDb();
            sendMessage($chatId, $questions[$gamePosition-1], returnEm($buttoms[$gamePosition-1]));
        }
    }

    function hasScoreCalculated() {
        global $connection;
        global $userId;

        $score = 0;
        
        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $mystring = $row['final_score'];
        if($mystring == 0)
            return false;
        return true;
    }

    function getTheUserScore() {
        global $connection;
        global $userId;

        $score = 0;
        
        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $mystring = $row['final_score'];
        return $mystring;
    }

    function setTheUserScore($score) {
        global $connection;
        global $userId;
        $query = "UPDATE table1 SET ";
        $query .= "final_score = $score ";
        $query .= "WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
    }

    function calculateUserScore() {
        global $choises;
        global $connection;
        global $userId;
        global $chatId;
        global $MAXNUMBER;
        global $marks;
        if(hasScoreCalculated()) {
            return getTheUserScore();
        }
        else {
            $score = 0;
        
            /* calculate the sum of the answers from the user's answers' array in database */
            $query = "SELECT * FROM table1 WHERE from_id = $userId ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $answerJson = $row['user_answers'];
            $answerArray = json_decode($answerJson, true);
            for($i = 0; $i < $MAXNUMBER; $i++) {
                $score = $score + $marks[$i][$answerArray[($i)+1]-1];
            }

            setTheUserScore($score);

            return $score;
        }
    }

    function showTheCharacteristic($userId) {
        global $characters;
        global $connection;
        global $btns;

        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $answer = (int)$row['final_score'];
        $characteristic = "";
        if($answer>=61)
            $characteristic = $characters[61];
        else if($answer>=51)
            $characteristic = $characters[51];
        else if($answer>=41)
            $characteristic = $characters[41];
        else if($answer>=31)
            $characteristic = $characters[31];
        else if($answer>=21)
            $characteristic = $characters[21];
        else if($answer<=20)
            $characteristic = $characters[0];

        sendMessage(getChatIdFromUserId($userId), "شخصیت شما بر اساس این آزمون:\n" . $characteristic, returnEMt(array(array("امتیاز من","دعوت دیگران", "شخصیت من"), array("چند نفر را دعوت کرده ام؟"))));
    }

    function checkInvitesAreEnough($userId) {
        global $connection;
        
        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $invites = (int)$row['invites_count'];

        if($invites >= 3)
            return true;
        return false;
    }
    
    function getInvitesCount($inviterId) {
        global $connection;
        $query = "SELECT * FROM table1 WHERE from_id = $inviterId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $invites_count = (int)$row['invites_count'];
        return $invites_count;
    }

    function addInvitesCountByOne($inviterId, $lastInvitesCount) {
        global $connection;
        $query = "UPDATE table1 SET ";
        $query .= "invites_count = ".($lastInvitesCount+1)." ";
        $query .= "WHERE from_id = $inviterId ";
        $result = mysqli_query($connection, $query);
    }

    function doesInviterIdExist($inviterId) {
        global $connection;
        $query = "SELECT * FROM table1 WHERE from_id = $inviterId ";
        $result = mysqli_query($connection, $query);
        $rowcount = mysqli_num_rows($result);
        if($rowcount===0)
            return false;
        return true;
    }

    function getChatIdFromUserId($userId) {
        global $connection;
        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $chatId = $row['chat_id'];
        return $chatId;
    }

    function sendTheInvitedUsernameToInviter($inviterId) {
        global $username;
        global $chatId;
        sendMessage(getChatIdFromUserId($inviterId), " @$username\n از طریق لینک دعوتنامه شما وارد ربات شد. تا الان شما ".getInvitesCount($inviterId)." نفر را عضو ربات کرده اید.", returnEMt(array(array("امتیاز من","دعوت دیگران", "شخصیت من"), array("چند نفر را دعوت کرده ام؟"))));
        if(checkInvitesAreEnough($inviterId)) {
            sendMessage(getChatIdFromUserId($inviterId), "شما تعداد نفرات کافی را عضو ربات کرده اید.", returnEMt(array(array("امتیاز من","دعوت دیگران"), array("چند نفر را دعوت کرده ام؟"))));
            sendMessage(getChatIdFromUserId($inviterId), showTheCharacteristic($inviterId), returnEMt(array(array("امتیاز من","دعوت دیگران"), array("چند نفر را دعوت کرده ام؟"))));
        }
    }

    function isThisUserAlreadyBeenInvitedByInviter($invitesArray) {
        global $userId;
        if(in_array($userId, $invitesArray))
            return true;
        return false;
    }

    function userClickOnHisInviteLink($inviterId) {
        global $userId;
        if($userId == $inviterId) 
            return true;
        return false;
    }

    /* return false if the hi message shouldn't be shown */
    function addInvitedUserIdToInviterList($inviterId) {
        global $connection;
        global $userId;
        global $chatId;
        if(!doesInviterIdExist($inviterId)) {
            // sendMessage($chatId,"به نظر میرسه لینک کلیک شده ایراد داره.\n شما میتونید با کلیک روی آی دی ربات یعنی @hadiprobot وارد ربات بشین و از امکانات اون استفاده کنید. ", returnEMhide(array(array("امتیاز من","دعوت دیگران"), array("چند نفر را دعوت کرده ام؟"))));
            return true;
        }
        if(userClickOnHisInviteLink($inviterId)) {
            sendMessage($chatId, "نباید روی لینک خودت کلیک کنید. این لینک را برای دوستان خود بفرستید تا آن ها عضو این ربات شوند و از آن استفاده کنند.", returnEMt(array(array("امتیاز من","دعوت دیگران", "شخصیت من"), array("چند نفر را دعوت کرده ام؟"))));
            return false;
        }
        $query = "SELECT * FROM table1 WHERE from_id = $inviterId ";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $invites_list = $row['invites_list'];
        $invites_count = (int)$row['invites_list']; // number of invited people
        $invitesArray = json_decode($invites_list, true);
        // sendMessage($chatId, "--".print_r($invitesArray), returnEMhide());
        if(isThisUserAlreadyBeenInvitedByInviter($invitesArray)) {
            sendMessage($chatId, "شما قبلا در ربات عضو شده اید. فقط کسایی میتونن دعوت بشن که قبلا عضو ربات نشده باشن. لینک دعوت نامه خودتون برای دوستانتون بفرستید", returnEMt($btn_finishedExam));
            return false;
        }
        $invitesArray[count($invitesArray)] = $userId;
        // file_put_contents('log.txt', file_get_contents('log.txt').print_r($invitesArray));
        addInvitesCountByOne($inviterId, getInvitesCount($inviterId));
        sendTheInvitedUsernameToInviter($inviterId);
        $newInviteJson = json_encode($invitesArray);
        $query = "UPDATE table1 SET ";
        $query .= "invites_list = '$newInviteJson' ";
        $query .= "WHERE from_id = $inviterId ";
        $result = mysqli_query($connection, $query);
        return true;
    }
