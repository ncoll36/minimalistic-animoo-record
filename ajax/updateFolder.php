<?php
	try {
	    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/includes/session.php')) { // Check if files are available
	        throw new Exception('One or more files are invalid. Please contact the system admin to report this issue');
	    } else {
	        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.php'); // Include files
	    }
	} catch (Exception $e) {
	    die($e->getMessage());
	}

	$general->updateFolder($_POST['id']);

?>