<?php
class JavaScript {
	function js2php_array($jsarraystring) {
		$str = $jsarraystring;
		$str = str_replace("{", "array(", $str);
		$str = str_replace("[", "array(", $str);
		$str = str_replace("]", ")", $str);
		$str = str_replace("}", ")", $str);
		$str = preg_replace("/['\"]?(\w+)['\"]?: ?/", "'$1' => ");		
		return $str;
	}
	
	function php2js_array($phparraystring) {
		try {
			$array = exec($phparraystring);		
		} catch (any $e) {
			//handle
		}
		$arrays = $this->js2php_array_recur($array);
		////loop through preg match array (needs to be implemented) (nearest closing paren?) correlate with $arrays
		////replace with [ ] or { } accordingly and replace => with :, etc.
	}
}
?>