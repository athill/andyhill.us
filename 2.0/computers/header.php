<form action="">
<textarea cols="95" rows="40" readonly="readonly">
<?php
$file = file($GLOBALS['fileroot'] . "/includes/header.php");
foreach ($file as $line) print($line);
?>
</textarea>
</form>