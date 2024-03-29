<?php

/*============================
//	Enable autoload of classes
//===========================*/
function autoload($aClassName) {

   $classFile = "/src/{$aClassName}/{$aClassName}.php";
   $file1 = SMVC_INSTALL_PATH . $classFile;
   $file2 = SMVC_SITE_PATH . $classFile;
 
 if(is_file($file1)) {
 
 	  require_once($file1);
   
   } elseif(is_file($file2)) {
      
      require_once($file2);
   }
}


/**
* Helper, make clickable links from URLs in text.
*/
function makeClickable($text) {
  return preg_replace_callback(
    '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
    create_function(
      '$matches',
      'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
    ),
    $text
  );
}


/**
* Helper, BBCode formatting converting to HTML.
*
* @param string text The text to be converted.
* @returns string the formatted text.
*/
function bbcode2html($text) {
  $search = array(
    '/\[b\](.*?)\[\/b\]/is',
    '/\[i\](.*?)\[\/i\]/is',
    '/\[u\](.*?)\[\/u\]/is',
    '/\[img\](https?.*?)\[\/img\]/is',
    '/\[url\](https?.*?)\[\/url\]/is',
    '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
    );
  $replace = array(
    '<strong>$1</strong>',
    '<em>$1</em>',
    '<u>$1</u>',
    '<img src="$1" />',
    '<a href="$1">$1</a>',
    '<a href="$1">$2</a>'
    );
  return preg_replace($search, $replace, $text);
}



spl_autoload_register('autoload');

?>