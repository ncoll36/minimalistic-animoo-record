<?php 
	require_once("includes/header.php"); 

	if (isset($_POST['username'], $_POST['password'])
		&& !empty($_POST['username'] . $_POST['password'])) {
		
		$general->login($_POST['username'], $_POST['password']);

	} else { ?>

<html>

	<form class="login" method="post" action="">
		<input type="text" value="" name="username" placeholder="Username" required>
		<input type="password" value="" name="password" placeholder="Password" required>
		<input type="submit" value="Login">
	</form>
</body>
</html>

<?php } ?>