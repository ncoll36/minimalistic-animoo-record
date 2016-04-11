<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/session.php');

	$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']);

	if ($path_parts['basename'] == "index.php") {
		if (!isset($_SESSION['login'])) {
			header("location:login.php");
		}
	}
?>
<html>
<head>
	<title>Minimalistic-Animoo</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<script src="js/jquery-1.10.1.min.js"></script>
	<script src="js/jquery-ui-1.10.4.js"></script>
	<script src="js/functions.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>