<?php
class RSS {
	var $feed;
	var $url;
	var $id;
	var $comment;
	var $loaded = false;
	var $links = array();

 	function __construct($url, $id, $comment="") {
		global $h;

		$this->id = $id;
		$this->url = $url;
		//libxml_use_internal_errors(true);
		//libxml_clear_errors();
		try {
	//		$this->feed=simplexml_load_file($url);
			//$file = file($url);
			//$h->pa($file);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml = curl_exec($ch);
			curl_close($ch);
			$this->feed = $this->produce_XML_object_tree($xml);
			//echo $xml;

/*
//			print_r($this->feed);
			if (count(libxml_get_errors()) > 0) {
//			if(!true) {
			    //trigger_error('Error reading XML file',E_WARNING);
				$h->pa(libxml_get_errors());
				$this->loaded = false;
			} else {
				$this->loaded = true;
			}
*/
		} catch (Exception $e) {
			$this->loaded = false;
			echo 'CAUGHT!';
		}
	}



	function display() {
		global $h;
//		echo 'here i am';
		if (!$this->loaded) {
			$h->tbr("Feed failed to load");
			return;
		}
		$atom = !($this->feed->channel);
		$root = ($atom) ? $this->feed : $this->feed->channel;
		////Title
		$this->title = $root->title;
		//$h->odiv('id="rss-feed'.$this->id.'"');

		$title = (strlen($root->title) > 25) ? substr($root->title, 0, 21) . " ..." : $root->title;
		$h->span($title . " ", 'class="rss-header" title="'.$root->title.'"');
		////Actions
		$this->link = ($atom) ? $root->link['href'] : $root->link;
		$h->a($this->link, "site", 'class="rss-action" title="site" target="_blank"');
		$h->tnl(" ");
		$h->a("#", "expand all", 'class="rss-action rss-toggleall" title="expand all" id="rss-expandall_'.$this->id.'"');
//		$h->tnl(" ");
		$h->br();
		////links
		$i = 0;
		$items = ($atom) ? $root->entry : $root->item;
		foreach ($items as $item) {
			$this->links[] = array();
			$this->links['title'] = $item->title;
			$title = (strlen($item->title) > 50) ? substr($item->title, 0, 46) . " ..." : $item->title;
			$link = ($item->link != "") ? $item->link : $item->link['href'];
						
			$h->a($link, $title, 
				'class="rss-links rss-links_'.$this->id.'" id="rss-link'.$this->id.'_'.$i.'" rel="'.$item->title.'"' .
				' target="_blank"');
			$description = ($atom) ? $item->content : $item->description;
			$h->div($description, 'class="rss-descriptions rss-descriptions_'.$this->id.'" id="rss-description'.$this->id.'_'.$i.'"');
			$h->br();

			$i++;
			if ($i > 10) break;
		}
		//$h->cdiv();
	}

	function produce_XML_object_tree($raw_XML) {
//	    echo 'here';
	    libxml_use_internal_errors(true);
	    try {
	        $xmlTree = new SimpleXMLElement($raw_XML);
		$this->loaded = true;
	    } catch (Exception $e) {
//		echo 'here';
	        // Something went wrong.
	        $error_message = 'SimpleXMLElement threw an exception.';
	        foreach(libxml_get_errors() as $error_line) {
	            $error_message .= "\t" . $error_line->message;
	        }
	        trigger_error($error_message);
	        return false;
	    }
	    return $xmlTree;
	}


}
?>
