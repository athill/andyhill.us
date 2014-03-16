<?php
/*
include_once($GLOBALS['incroot']."/html.class.php");
$h = html::singleton();

class Render {
	private $UFT; 

	function __construct($options=array()) {
		

		$defaults = array(
			'layout'=>'basic',
			'uft'=>'',
			'form'=>'',
			'view'=>'',		
		);
		$this->opts = $this->extend($defaults, $options);
		$objects = explode(",", "UFT,Form,View");
		foreach ($objects as $object) {
			if (!is_object($this->opts['object'])) {			
				include_once($object.'.class.php');
				$this->{$object} = new $object(
			}
		}
	}
}
*/
?>
