<?php

class Galleria {
	private $data;

	function __construct($category) {
		$datafile = 'data.json';
		$data = json_decode(file_get_contents($datafile), true);
		$this->data = $data[$category];		
	}

	function render() {
		global $h;
		$h->odiv('id="galleria"');
		foreach ($this->data as $image) {
			$h->otag('a', 'href="'.$image['image'].'"');
			$descr = $image['description'];
			$descr = str_replace('\"', '&quot;', $descr);
			$descr = stripcslashes($descr);
			$descr = preg_replace('/.*(\n).*/', '<br />', $descr);
			$h->img($image['image'], $descr, 'class="image" title="'.stripcslashes($image['title']).'"');
			$h->ctag('a');
		}
		$h->cdiv();
	}
}

?>
