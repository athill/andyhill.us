<?php
include_once("Module.php");


class PopupMenu extends Module {
	var $jsfiles = '/js/menu.js';
	var $cssfiles = "/css/menu.css";
	var $name = "PopupMenu";

	function __construct() {
		parent::__construct($this->name, $this->jsfiles, $this->cssfiles);
	}
}
?>
