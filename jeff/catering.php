<?php
include("inc/application.php");


$text = <<<EOT
We offer our full menu for parties and meetings of any size
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
Group sized bowls of salad and pasta, along with sandwich trays, 
are available for larger groups.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
Of course, our high quality pizza and breadsticks are available for any 
number of guests or coworkers.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
Cookie trays are also available for pre-orders only.
EOT;
$h->tag('p', '', $text);

$text = <<<EOT
We always look forward to delaing with each customer, insuring their catering 
needs are being met. We want each party, meeting, or event to be a "royal" 
hit with Pizza King of Carmel. 
EOT;
$h->tag('p', '', $text);


if ($footer != "") {
	include_once($GLOBALS['fileroot'] . $footer);
}
?>
