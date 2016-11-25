<?php
$result = ['error' => 'No path parameter supplied'];
if (isset($_GET['path'])) {
	list($section, $item) = explode('/', $_GET['path']);
	if (!$section || !$item) {
		$result = ['error' => "Illegal arguments: section: [$section], item: [$item]"];
	} else {
		if (!file_exists('inspire.db')) {
			include('seed.php');
		}
		$db = new SQLite3('inspire.db');
		if (!$db) {
			$result = ['error' => "Unable to open database inspire.db"];
		} else {
			$section = SQLite3::escapeString($section);
			$item = SQLite3::escapeString($item);
			$sql = "SELECT * FROM items WHERE section='$section' AND item='$item'";
			$dbResult = $db->querySingle($sql, true);
			if (!$dbResult) {
				$result = ['error' => "No record found for arguments section: [$section], item: [$item]"];
			} else {
				$result = $dbResult;
			}			
		}
	}
}

print(json_encode($result));