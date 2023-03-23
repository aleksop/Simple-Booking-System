<?php
include_once "header.php";
?>

<div class="content home">
	<h2>Reviews</h2>
	<p>Check out the below reviews for our website.</p>

	<div class="reviews"></div>
	<script>
		var userName = "";
		fetch("incl/get_reviews.php").then(response => response.text()).then(data => {
			document.querySelector(".reviews").innerHTML = data;
			document.querySelector(".reviews .write_review_btn").onclick = event => {
				event.preventDefault();
				document.querySelector(".reviews .write_review").style.display = 'block';
				document.querySelector(".reviews .write_review input[name='name']").focus();
			};
			document.querySelector(".reviews .write_review form").onsubmit = event => {
				event.preventDefault();
				fetch("incl/get_reviews.php", {
					method: 'POST',
					body: new FormData(document.querySelector(".reviews .write_review form"))
				}).then(response => response.text()).then(data => {
					document.querySelector(".reviews .write_review").innerHTML = data;
				});
			};
		});
		// if user is logged in
		fetch("incl/session-storage.php", ).then(function(response) {
			return response.json();
		}).then(function(userData) {
			userName = userData['name'];
			hName = document.getElementById("userName");
			hName.value = userName;
		}).catch(function(err) {
			console.log('Fetch Error :-S', err);
		});
	</script>
	<?php
	require "footer.php";
	?>