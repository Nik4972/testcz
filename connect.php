<?php

function connect_db() {
    $host     = "localhost";
    $db       = "testcz";
    $user     = "***";
    $password = "***";
    try {
        $link = new mysqli($host, $user, $password, $db);
        return $link;
    }
    catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

?>
