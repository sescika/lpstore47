<?php
    ob_start();
    function redirect($url) {
 
        header("Location: " . $url);
        ob_start();
        ob_end_flush();
    }
?>