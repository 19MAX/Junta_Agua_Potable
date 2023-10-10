<?php 

const FLASH = "flash";
function create_flash_message(string $message, string $type): void
{
    session_start();
    // remove existing message with the name
    if (isset($_SESSION[FLASH])) {
        unset($_SESSION[FLASH]);
    }
    // add the message to the session
    $_SESSION[FLASH] = ['message' => $message, 'type' => $type];
}


function display_flash_message()
{
    session_start();
    if (!isset($_SESSION[FLASH])) {
        return null;
    }

    // get message from the session
    $flash_message = $_SESSION[FLASH];

    // delete the flash message
    unset($_SESSION[FLASH]);

    // display the flash message
    return $flash_message;
}
?>