$(document).ready(function(){

	/* Update Number */
	$(document).on('click', ".add", function() {
    	var exec = 0;
    	changeNumber(exec);
    });

	$(document).on('click', ".minus", function() {
    	var exec = 1;
    	changeNumber(exec);
    });

    function changeNumber(exec){
    	var id = event.target.id;

        $.ajax({
		    url: '/ajax/changeNumber.php',
		    type: 'post',
		    data: {
		    	  	"id": id,
		    	  	"exec": exec
		    	  },
		    success: function(response) { 
		    	console.log(response);
		    	$("#" + id + ".number").html(response);
		    	countAnime();
		    }
		});
    };

	/* Autocomplete Search */
	var MIN_LENGTH = 1;
	$("#search").keyup(function() {
		if ($('#search-num').is(':checked')) {
			var searchType = 1;
		} else {
			var searchType = 0;
		}

		var search = $("#search").val();
		
		$('#order-alpha').prop('indeterminate', false);
		$('#order-alpha').prop('checked', true);
		$("#order-num").prop("indeterminate", true);
		$('label[for="order-alpha"] i').removeClass('fa-sort-alpha-asc');
		$('label[for="order-alpha"] i').addClass('fa-sort-alpha-desc');

		var search = (search.length >= MIN_LENGTH) ? search : '';

		$.ajax({
		    url: '/ajax/autocomplete.php',
		    type: 'post',
		    data: { 
		    		"search": search,
		    		"type": searchType
		    	  },
		    success: function(response) { 
		    	console.log(response);
		    	$(".animelist").html(response);
		    }
		});
	});

	/* Order Anime */
	$(document).on('change', "#order-alpha", function() {
		var type = 0; //0 = alpha
		var order = this.checked ? 0 : 1;

		if (order == 0) {
			$('label[for="order-alpha"] i').removeClass('fa-sort-alpha-asc');
			$('label[for="order-alpha"] i').addClass('fa-sort-alpha-desc');
		} else {
			$('label[for="order-alpha"] i').removeClass('fa-sort-alpha-desc');
			$('label[for="order-alpha"] i').addClass('fa-sort-alpha-asc');
		}

		$("#order-num").prop("indeterminate", true);
    	orderAnime(order, type);
    });

    $(document).on('change', "#order-num", function() {
		var type = 1; //0 = num
		var order = this.checked ? 0 : 1;
		if (order == 0) {
			$('label[for="order-num"] i').removeClass('fa-sort-numeric-asc');
			$('label[for="order-num"] i').addClass('fa-sort-numeric-desc');
		} else {
			$('label[for="order-num"] i').removeClass('fa-sort-numeric-desc');
			$('label[for="order-num"] i').addClass('fa-sort-numeric-asc');
		}

		$("#order-alpha").prop("indeterminate", true);
    	orderAnime(order, type);
    });

    function orderAnime(order, type) {
        $.ajax({
		    url: '/ajax/order.php',
		    type: 'post',
		    data: {
		    	  	"order": order,
		    	  	"type": type
		    	  },
		    success: function(response) { 
		    	console.log(response);
		    	$(".animelist").html(response);
		    	$("#search").val('');
		    }
		});
    };

    // Change to 3rd state on page load
   	$("#order-num").prop("indeterminate", true);

   	/* Add Anime to List */
	$(".add-anime").submit(function(e) {
    	$.ajax({
		    url: '/ajax/addAnime.php',
		    type: 'post',
		    data: $(".add-anime").serialize(),
		    success: function(response) {
				$(".animelist").html(response);
				$('.add-anime').trigger("reset");
				countAnime();

				$(".notifications").html('Anime Added!');
				$(".notifications").toggle('slide' , {direction: "up"}, 300);
				setTimeout(function() {
				    $(".notifications").toggle('slide' , {direction: "up"}, 300);
				    $(".notifications").html('');
				}, 2000);
		    }
		});
	    e.preventDefault(); 
	});

	/* Delete Anime */
	$(document).on('click', ".delete", function() {
		var id = event.target.id;
		if (confirm('Delete? YES | NO')) {
			    $.ajax({
			    url: '/ajax/deleteAnime.php',
			    type: 'post',
			    data: { "id": id },
			    success: function(response) { 
			    	console.log(response);
			    	$(".animelist").html(response);
			    	countAnime();

			    	$(".notifications").html('Anime Deleted!');
			    	$(".notifications").toggle('slide' , {direction: "up"}, 300);
					setTimeout(function() {
						$(".notifications").toggle('slide' , {direction: "up"}, 300);
					    $(".notifications").html('');
					}, 2000);
			    }
			});
		} 	
    });

	/* Count Anime */
	function countAnime() {
		$.ajax({
		    url: '/ajax/count.php',
		    type: 'post',
		    success: function(response) { 
		    	$(".count").html(response);
		    }
		});
    };

    countAnime(); // Activate on page load

    $(document).on('click', ".no-folder", function() {
    	var id = event.target.id;

        $.ajax({
		    url: '/ajax/updateFolder.php',
		    type: 'post',
		    data: { "id": id, },
		    success: function(response) { 
		    	console.log(response);
		    	$("#" + id + ".no-folder").remove();

		    	$(".notifications").html('Added to Folder!');
		    	$(".notifications").toggle('slide' , {direction: "up"}, 300);
				setTimeout(function() {
					$(".notifications").toggle('slide' , {direction: "up"}, 300);
				    $(".notifications").html('');
				}, 2000);
		    }
		});
    });







});