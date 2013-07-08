<?php

// Include Caboose class
include_once("./class_caboose.php");

/*
	Define the rules for each alias
	Method names should correspond to the names used in the data attributes

	This class is basically a router for your Caboose calls

	Ideally, you should call other classes/functions within each rule method rather 
	than doing data handling within the rule object. 
*/



// This represents an external method that you would call (probably a model)
function createContent($name, $id) {
	return($name." (".$id.")");
}



// Rules object
class cabooseRules {
	function beforeit($data) {
		$html = "Inserting ".createContent($data["name"], $data["id"])." before an element";
		return($html);
	}

	function afterit($data) {
		$html = "Inserting ".createContent($data["name"], $data["id"])." after an element";
		return($html);
	}

	function appendit($data) {
		$html = " appended with ".createContent($data["name"], $data["id"]);
		return($html);
	}

	function replaceit($data) {
		$html = "Replacing an element with ".createContent($data["name"], $data["id"]);
		return($html);
	}
}


// Call Caboose and return markup
// Pass rules object as first argument. Required.
// Pass settings array as second argument. Optional.
new caboose(new cabooseRules, array("root"=>"../"));

?>