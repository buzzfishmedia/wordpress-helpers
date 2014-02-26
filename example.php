<?php

if( file_exists('vendor/autoload.php')) {
	$define = true;
} else {
	$define = false;
}
define('COMPOSERED', $define );

if( COMPOSERED != true ){
	echo "Composer Not Defined";
	return;
} 

require_once( 'vendor/autoload.php');

$theme = new WordPress\Theme("grout");
$cpt = new WordPress\CustomPostType("customer");

echo "<pre>";
print_r($theme);
print_r($cpt);
echo "</pre>";