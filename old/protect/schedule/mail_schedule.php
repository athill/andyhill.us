
<?php
//connect to db
$dbh=mysql_connect ("localhost", "andyhil_andy", "h0p313ss") or die ('I cannot connect to the database because:');

mysql_select_db ("andyhil_music") or die("Couldn't select db"); 

$mo = date("n") - 1;
if ($mo == 0) $mo = 12;
$lastmonth = mktime(0, 0, 0, $mo , 1,  date("Y"));
$lastmonth = date("F, Y", $lastmonth);


$to = 'cjbonk@courseshare.com,mary@courseshare.com,andyhil@courseshare.com';

$subject = "Timesheet for Andy Hill for $lastmonth";
$headers = 'From: andyhil@surveyshare.com';

$tot_hours = 0;
$message = "";
$year = date("Y");
$month = date("m") - 1;
if ($month < 10) $month = "0" . $month;
$query = "SELECT * FROM schedule WHERE shift_date LIKE '$year-$month%'";
print($query . "<br />\n");
$result = mysql_query($query) or die("query failed");
while ($line = mysql_fetch_array($result)) {
	$message .= $line['shift_date'] . "\n";
	$message .= "Hours worked: " . $line['hours_worked'] . "\n";
	$message .= $line['description'] . "\n\n";
	$tot_hours += $line['hours_worked'];
}

$message .= "Total hours: " . $tot_hours . "\n";
print($message);

mail($to, $subject, $message, $headers) or die("screwed");

?>
