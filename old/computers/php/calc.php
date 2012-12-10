<?session_start();
if (session_is_registered("acc")) {
if ($fun == "add") $acc += $arg;
elseif ($fun == "sub") $acc -= $arg;
} else {
	$acc = 0;
	session_register("acc");
}
?>

<html><head>
<title>Simple Calculator with PHP</title>
</head>
<body bgcolor="white">

<form method="POST" action ="<?=$SCRIPT_NAME;?>">

Your current balance is: <?=$acc?>
<table padding=2><tr>
<td>amount</td><td>
<input type = "text" name="arg" size=4></td>
<td>Function</td>
<td><select name="fun">
  <option value="non">Click me!
  <option value="add">Deposit
  <option value="sub">Withdraw
</select></td></tr></table>

<input type="submit" value="New Balance"><p>

</form></body></html> 
