<?php
/*
	Caboose for Ajax-include Pattern
	2013, Brian Vaughn, @morningtoast
	https://github.com/morningtoast/caboose
*/

class caboose {
	var $version = "1.1";

	function __construct($custom=array()) { 
		$this->settings = array(
			"root"      => "../",
			"mime"      => "text/html",
			"statickey" => "file",
			"prefix"    => "route_",
			"notfound"  => "Content not found"
		);

		$this->settings = array_merge($this->settings, $custom);
		$this->list     = $_REQUEST["files"];
		$this->wrapper  = isset($_REQUEST[ "wrap" ]);
		$this->data     = array();

		$this->settings["statickey"] = $this->settings["prefix"].$this->settings["statickey"];

		if ($this->list) {
			$this->sources = explode(",", $this->list);
			$this->fetch();
		}
	}


	function fetch() {
		$a_blocks = array();

		foreach ($this->sources as $source) {
			$a_args     = explode("/", $source);
			$alias      = $this->settings["prefix"].array_shift($a_args);
			$a_this     = array("id"=>$source, "html"=>$this->settings->notfound);
			$partial    = false;

			if (method_exists($this, $alias)) {
				foreach ($a_args as $pair) {
					$a_set             = explode(":", $pair);
					$a_data[$a_set[0]] = $a_set[1];
				}

				$a_this["html"] = $this->$alias($a_data);
			} else {
				if ($alias == $this->settings["statickey"]) {
					
					$filepath = $this->settings["root"].implode("/",$a_args);

					if (file_exists($filepath)) {
						$a_this["html"] = file_get_contents($filepath);
					}
				}
			}

			$a_blocks[] = $a_this;
		}

		$this->deliver($a_blocks);
	}

	function source($alias, $a_args, $json=false) {
		$s = $alias."/";
		$a = array();

		if ($json) {
			$a_args = json_decode($json, true);
		}


		foreach ($a_args as $k => $v) {
			$a[] = $k.":".$v;
		}

		$s .= implode("/", $a);
		return($s);
	}

	function deliver($a_data) {
		$payload = "";

		foreach ($a_data as $a_item) {
			$open  = $this->wrapper ? "<entry url=\"". $a_item["id"] . "\">\n" : "";
			$close = $this->wrapper ? "</entry>\n" : "";

			$payload .= $open.$a_item["html"].$close;
		}

		// Set the content type and filesize headers
		header('Content-Type: ' . $type);
		header('Content-Length: ' . strlen($payload));

		// Deliver the file
		echo $payload;
	}
}

?>