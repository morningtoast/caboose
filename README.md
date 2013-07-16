# Caboose for Ajax Include Pattern

* 2013, Brian Vaughn, @morningtoast

## Case
I found the Ajax-include Pattern from Filament Group quite handy but I needed a way to 
dynamically create the returning content, rather than just returning a file that
was already rendered with content. Basically, I needed to pass values to my
handler which would then use them to generate markup.

## Inspiration
The Caboose class is a replacement for the [Quickconcat handler][concat] written by the Filament Group.

This repo including a modified version of the [Ajax-include Pattern][repo] from Filament Group.


[repo]: https://github.com/filamentgroup/Ajax-Include-Pattern/
[concat]: https://github.com/filamentgroup/quickconcat

## Dependencies
jQuery 1.8+ is required for the Ajax-include Pattern plugin and is not included


## Frontend
Syntax for your frontend code is the same as the original Ajax-include Pattern which uses data attributes to define where fetched data should be applied: `data-after` `data-before` `data-replace` `data-target` `data-append`

However, the value of the data attribute should NOT be a file path but instead a delimited string
of key:value pairs along with an alias name that is used on the backend.

Example:

    <a href="..." data-replace="gijoe/name:Destro/id:123">Latest Articles</a>

The value is delimited by a foreslash (/) with the first segment being the name of the alias, here `gijoe`

Each segment after the first is seen as a key:value pair and is passed to Caboose as such. In the example, `name` and `id` are the keys.

Caboose is intended for use with a proxy so that all ajax includes are done with just one call. Make sure your proxy option is pointed to where your Caboose handler exists.

    $("[data-append],[data-replace],[data-after],[data-before]").ajaxInclude({proxy:"caboose.php?wrap&files="});

### Reading files
In the case where you just want to read the direct contents of a file and return them, you can use the keyword `file` as the first segment of your attribute value and then all proceeding segments will be treated as a file path relative to the root path you define in the Caboose settings.

Example:

    <a href="..." data-replace="file/content/includes/partial.html">Latest Articles</a>

Here the file located at `content/includes/partial.html` would be read and its contents returned and inserted. No extra handling or processing is done in this case.

## Backend (PHP)
Caboose is primarily a backend handler that works with the Ajax-include Pattern. Rather than simply read and return a file that is already compiled, Caboose takes the key:value data you pass to then do what you need, in theory, pass those values to other methods to generate markup dynamically.

### Defining routes
Caboose runs off routes that you define. Each route should match up to an alias that is named in the key:value pairs you provide on the frontend. 
	class cabooseRoutes extends caboose {
	    function __construct($custom=array()) { parent::__construct($custom); } // DO NOT REMOVE

		function route_gijoe($data) {
			$html = "Name: ".$data["name"]." (".$data["id"].")";
			return($html);
		}
	}

In the above example, the method `route_gijoe` corresponds to the first segment used in the data attribute of the frontend markup (see previous example). Every rule method is passed the key:value pairs as an associative array.

Every rule method should return complete markup. That markup is then used to inserted into the DOM based on the data attribute rules you've defined.

## More reading
You can check out the original [Ajax-include Pattern][repo] for more documentation and options that you can use within your markup. Caboose is a backend handler that works with the Ajax-include Pattern, however the JS included here is slightly amended so be aware that Caboose may not work exactly as expected if using other version of the Javascript.
