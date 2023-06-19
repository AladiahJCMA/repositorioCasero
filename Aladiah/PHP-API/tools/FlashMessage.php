<?php

class FlashMessage {

    static function saveMessage($message) {
        $_SESSION['flashMessage'][] = $message;
    }

    static function printMessage() {
        if (isset($_SESSION['flashMessage'])) {
            foreach ($_SESSION['flashMessage'] as $message)
            {
                print "<div>".$message."</div>";
            }
            unset($_SESSION['flashMessage']);
        }
    }
}