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

	if (!empty($_POST['search'])) {
		if ($_POST['type'] == 0) {
			$general->keywordSeach($_POST['search']);
		} elseif ($_POST['type'] == 1) {
			$general->numberSeach($_POST['search']);
		}
	} else {
		$general->getAnime(SORT_ASC, 'name');
	}
	
?>