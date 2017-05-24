<?php 
/*------------------------------------------------------------------------
# author    Marius Hogas
# copyright Copyright © 2012 hogash.com. All rights reserved.
# @license  Commercial http://themeforest.net/licenses/regular_extended
# Website   http://www.hogash.com
-------------------------------------------------------------------------*/

/* initialize ob_gzhandler to send and compress data */
ob_start ("ob_gzhandler");
/* initialize compress function for whitespace removal */
ob_start("compress");
/* required header info and character set */
header("Content-type: text/css; charset: UTF-8");
/* cache control to process */
header("Cache-Control: must-revalidate");
/* duration of cached content (1 hour) */
$offset = 60 * 60 ;
/* expiration header format */
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
/* send cache expiration header to broswer */
header($ExpStr);
/* Begin function compress */
function compress($buffer) {
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, new lines, etc. */        
	$buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
	/* remove unnecessary spaces */        
	$buffer = str_replace('{ ', '{', $buffer);
	$buffer = str_replace(' }', '}', $buffer);
	$buffer = str_replace('; ', ';', $buffer);
	$buffer = str_replace(', ', ',', $buffer);
	$buffer = str_replace(' {', '{', $buffer);
	$buffer = str_replace('} ', '}', $buffer);
	$buffer = str_replace(': ', ':', $buffer);
	$buffer = str_replace(' ,', ',', $buffer);
	$buffer = str_replace(' ;', ';', $buffer);
	$buffer = str_replace(';}', '}', $buffer);
	$buffer = str_replace('@', ' @', $buffer);
	
	return $buffer;
}


$files = explode('-',$_REQUEST['src']);
foreach($files as $file){
	require($file.'.css');
}
?>