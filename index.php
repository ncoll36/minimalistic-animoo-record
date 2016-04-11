<?php
	require_once("includes/header.php");
?>

<html>

	<div class="notifications"></div>

	<div class="wrapper">
		<div class="tools">
			<div class="left">
				<form class="add-anime">
					<input type="text" value="" name="name" placeholder="New Anime" id="add-anime" required>
					<input type="text" value="" name="number" placeholder="#" id="add-anime" required>
					<input type="checkbox" value="true" name="folder" id="folder">
					<label for="folder"><span></span></label>
					<input type="submit" value="+">
				</form>

				<div class="search">
					<input type="text" value="" placeholder="Search" id="search">
					<input type="checkbox" id="search-num">
					<label for="search-num"><span></span></label>
				</div>
			</div>
			<div class="right">
				<i class="count-title fa fa-hashtag"></i><div class="count"></div>

				<div class="order">
					<label for="order-alpha">
				    	<input type="checkbox" value="" name="order-alpha" id="order-alpha" checked><i class="fa fa-sort-alpha-desc"></i>
				  	</label>
					<label for="order-num">
					    <input type="checkbox" value="" id="order-num"><i class="fa fa-sort-numeric-asc"></i>
					 </label>
				</div>
			</div>
		</div>

		<div class="animelistcontainer">
			<div class="row row-heading">
				<div class="name">Anime</div>
				<div class="number">#</div>
				<div class="add-head"></div>
				<div class="minus-head"></div>
				<div class="delete-head"></div>
			</div>
			<div class="animelist"><?php $general->getAnime(SORT_ASC, 'name'); ?></div>
		</div>
	</div>

</body>
</html>