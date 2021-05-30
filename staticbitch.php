<?php
/**
 * @package StaticBitch
 * @version 0.0.1
 */
/*
Plugin Name: StaticBitch
Plugin URI: 
Description: 
Author: 
Version: 
Author URI: 
*/

define('PZ_WP_URL', "http://peakzebra.link/");


$url_list = array();
array_push($url_list, PZ_WP_URL);
$out_html = '';

while( $url = array_pop($url_list)) {
    $html = file_get_contents($url);
    $cnt = strlen($html);
    $pieces = explode("<a", $html);
    foreach($pieces as $piece) {
        $out_html = $out_html . $piece . '<a';
    }

$out_html = substr($out_html, 0, -2);
file_put_contents("bobby.html", $out_html);


$perfect = strcmp( $html, $out_html);
   

   


}

$other = $html;

/*
function crawl_page($url, $depth = 5) {
    if($depth > 0) {
        $html = file_get_contents($url);

        preg_match_all('~<a.*?href="(.*?)".*?>~', $html, $matches);

        foreach($matches[1] as $newurl) {
            crawl_page($newurl, $depth - 1);
        }

        file_put_contents('results.txt', $newurl."\n\n".$html."\n\n", FILE_APPEND);
    }
}

crawl_page('http://www.domain.com/index.php', 5);
*/