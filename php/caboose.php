<?php
/*
	Caboose for Ajax-include Pattern
	2013, Brian Vaughn, @morningtoast
	https://github.com/morningtoast/caboose
*/


// Include Caboose class
include_once("./class_caboose.php");

/*
	Define the actions for each alias
	Method names should correspond to the names used in the data attributes

	This class is basically a router for your Caboose calls

	Ideally, you should call other classes/functions within each method rather 
	than doing data handling within the object itself. 
*/



// This represents an external method that you would call (probably a model)
function createContent($name, $id) {
	return($name." (".$id.")");
}



// Extend the core object to define route actions for aliases
// Function names must have the same prefix defined in settings, default is "route_"
// The name after the prefix is what you'll use in your HTML data attributes (see demo.html)
class cabooseRoutes extends caboose {
    function __construct($custom=array()) { parent::__construct($custom); } // DO NOT REMOVE

    // Define alias handlers as functions below
    // Each handler should return the final markup that will get added to the DOM

	function route_beforeit($data) {
		$html = "Inserting ".createContent($data["name"], $data["id"])." before an element";
		return($html);
	}

	function route_afterit($data) {
		$html = "Inserting ".createContent($data["name"], $data["id"])." after an element";
		return($html);
	}

	function route_appendit($data) {
		$html = " appended with ".createContent($data["name"], $data["id"]);
		return($html);
	}

	function route_replaceit($data) {
		$html = "Replacing an element with ".createContent($data["name"], $data["id"]);
		return($html);
	}
}


// Call your extended Caboose class, passing settings array as optional argument
// $c = new cabooseRoutes(array("root"=>"./","prefix"=>"custom_"));
$c = new cabooseRoutes;

?>