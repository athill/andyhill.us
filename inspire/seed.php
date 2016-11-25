<?php
$db = new SQLite3('inspire.db') or die('Unable to open database');

$sql = <<<EOD
  CREATE TABLE IF NOT EXISTS items (
    item STRING PRIMARY KEY,
    section STRING,
    content STRING,
    credits STRING)
EOD;
$db->exec($sql) or die('Create db failed');

$sections = scandir('content');
foreach ($sections as $section) {
	if (!in_array($section, ['.', '..'])) {
		$items = scandir('content/'.$section);
		foreach ($items as $item) {
			if (!in_array($item, ['.', '..'])) {
				$itemname = preg_replace("/\.txt$/", "", $item);
				$lines = file('content/'.$section.'/'.$item);
				$content = '';
				$credits = '';
				$inCredits = false;
				foreach ($lines as $line) {
					if (trim($line) === "CREDITS") {
						$inCredits = true;
						continue;
					}
					if ($inCredits) {
						$credits .= $line;
					} else {
						$content .= $line;
					}
				}
				$content = SQLite3::escapeString($content);
				$credits = SQLite3::escapeString($credits);
				$sql = "INSERT INTO items VALUES('$itemname', '$section', '$content', '$credits')";
				$db->exec($sql) or die("Unable to add item $sql");
			}
		}
	}
}

$result = $db->query('SELECT * FROM items') or die('Query failed');
while ($row = $result->fetchArray()) {
  var_dump($result);
}