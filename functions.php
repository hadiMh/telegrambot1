<?php
    function sendMessage($chatId, $message, $r)
    {
        $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
        file_get_contents($url);
    }

    function enNumToFa($string) {
        return strtr($string, array('0'=>'۰', '1'=>'۱', '2'=>'۲', '3'=>'۳', '4'=>'۴', '5'=>'۵', '6'=>'۶', '7'=>'۷', '8'=>'۸', '9'=>'۹'));
    }

    function addNumbers($buttomArray) {
        $num = 1;
        for($i = 0; $i < count($buttomArray); $i++) {
            for($j = 0; $j < count($buttomArray[$i]); $j++) {
                $buttomArray[$i][$j] = enNumToFa($num)." - " . $buttomArray[$i][$j];
                $num++;
            }
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
        // question 1 encoded markup
        return json_encode($rm, true);
    }
    
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

    function addUserIfDoesntExist() {
        global $connection;
        global $userId;
        global $chatId;
        global $name;
        global $username;

        $query = "SELECT * FROM table1 WHERE from_id = $userId ";
        $result = mysqli_query($connection, $query);
        $row_cnt = mysqli_num_rows($result);
        if($row_cnt === 0){
            $query = "INSERT INTO table1 (from_id, from_firstname, from_username, chat_id)";
            $query .=" VALUES ('$userId', '$name', '$username', '$chatId')";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                sendMessage($chatId, "QUERY FAILED: " . mysqli_error($connection) ."\n-- " . $query, returnEM(array(array("worked!"))));
            } else {
                sendMessage($chatId, "USER ADDED!", returnEM(array(array("worked!"))));
            }
        } else {
            sendMessage($chatId, "USER EXISTED!", returnEM(array(array("worked!"))));
        }
    }