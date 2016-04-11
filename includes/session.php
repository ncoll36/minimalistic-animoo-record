<?php
   
    session_start();
    date_default_timezone_set("Australia/Brisbane");

    try {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/includes/conn.php')) { // Check if files are available
            throw new Exception('One or more files are invalid. Please contact the system admin to report this issue');
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/conn.php'); // Include files
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }

    try {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/includes/class/class.general.php')) { // Check if files are available
            throw new Exception('One or more files are invalid. Please contact the system admin to report this issue');
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/class/class.general.php'); // Include files
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }

    $datetime = date("Y-m-d H:i:s", time());

    $general = new General();

?>