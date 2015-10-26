<?php
session_start();
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PNC Response</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
</head>
<body>
<h1>PNC Response</h1>

<?php
if (isset($_SESSION['message'])) {
	print('<div class="alert alert-info">'.$_SESSION['message'].'</div>');
	unset($_SESSION['message']);
}
?>

<div class="container">
	<form action="/pnc/submit.php" method="post" id="email-form">
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="name" name="name" placeholder="Name">
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="form-control" id="email" name="email" placeholder="Email">
	</div>
	<div class="form-group">
		<label for="type">Type</label>
		<select class="form-control" id="type" name="type">
			<option>Match</option>
			<option>Referral</option>
		</select>
	</div>
	<button type="submit" class="btn btn-default">Send Mail</button>
	</form>
</div>

</body>
<script type="text/javascript">

document.getElementById('email-form').onsubmit = function(e) {
	var name = document.getElementById('name').value,
		email = document.getElementById('email').value,
		typefield = document.getElementById('type'),
		type = typefield.options[typefield.selectedIndex].text;
	if (name == '') {
		alert('Please supply a name');
		return false;
	}
	if (email == '') {
		alert('Please supply an email');
		return false;
	}	
	return confirm('Really email '+name+ ' ('+email+') with '+type+' template?');
}
</script>
</html>