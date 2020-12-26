<?php 
foreach (getallheaders() as $name => $value) { 
	//echo ;
	print_r("<pre>"); print_r($name); print_r("</pre>"); 
}
?>