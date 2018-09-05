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
            $query = "INSERT INTO table1 (from_id, from_firstname, from_username, chat_id, user_answers)";
            $query .=" VALUES ('$userId', '$name', '$username', '$chatId', '[]')";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- " . $query. " ". mysqli_error(), returnEM(array(array("worked!"))));
            } else {
                sendMessage($chatId, "USER ADDED!", returnEM(array(array("worked!"))));
            }
        } else {
            sendMessage($chatId, "USER EXISTED!".$row_cnt, returnEM(array(array("worked!"))));
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
        if(!$result) {
            sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- ".$query, returnEM(array(array("worked!"))));
        } else {
            sendMessage($chatId, "RECORD UPDATED! before: $lastPostion -- after: ".getGamePositionFromDb() , returnEM(array(array("worked!"))));
        }
    }

    function hasUserStartedTheGame() {
        $userGamePosition = getGamePositionFromDb();
        if($userGamePosition === 0)
            return 0;
        return 1;
    }

    function hasUserEndedTheGame() {
        global $MAXNUMBER;
        $userGamePosition = getGamePositionFromDb();
        if($userGamePosition >= $MAXNUMBER)
            return 1;
        return 0;
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

    }