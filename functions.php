<?php
    function sendMessage($chatId, $message, $r)
    {
        $url = $GLOBALS['webSite'] . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($message) . "&reply_markup=" . $r;
        file_get_contents($url);
    }