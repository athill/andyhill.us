<?php

class Query2xml {
	
	private $sqlResult;
	private $xml;
	
	public function __construct($sqlResult, $rootNodeName="data") {
		$this->sqlResult = $sqlResult;	
		$this->xml = new DOMDocument('1.0');
		$this->xml->formatOutput = true;
		$root = $this->xml->createElement($rootNodeName);
		$root = $this->xml->appendChild($root);
		
		//echo "count: ".count($this->result)."<br />";
		for ($i = 0; $i < count($this->sqlResult); $i++) {
			$row = $this->sqlResult[$i];
			/*
			echo "<pre>";
			print_r($row);
			echo "</pre>";
			*/
			$occ = $this->xml->createElement('record');
			$occ = $root->appendChild($occ);
			
			foreach ($row as $fieldname => $fieldvalue) {
				$child = $this->xml->createElement(strtolower($fieldname));
				$child = $occ->appendChild($child);
				$value = $this->xml->createTextNode($fieldvalue);
				$value = $child->appendChild($value);
			}				
		}
	}
	
	public function getXml() {
		return $this->xml;
	}
	
	
	public function toFile($fileout) {
	   $fp = fopen($fileout, "w") or die("Couldn't open $fileout for writing!");
	   fwrite($fp, $this->xml->saveXML()) or die("Couldn't write values to file!"); 			
	}
}

?>