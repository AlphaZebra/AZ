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
define('PZ_UNDER_DIR', "UNDER");


$url_list = array();
$seen = array();
array_push($url_list, PZ_WP_URL);


// takes a string of arbitrary text with a link url 
// embedded in it and returns just the url
// if no url, returns null
function get_clean_url($chunk) {
    $pos1 = $pos2 = 0;
    // if not a link to another domain
    $upstr = strtoupper($chunk);
    // if( strpos( $chunk, PZ_UNDER_DIR ) < 1) return null;
    // else {
        // get position of HREF= and of closing quotation of URL that follows HREF=
        $startpos = strpos($chunk, "HREF=");
        $endpos = strpos($chunk, ">", $pos1);
        $cleanurl = substr($chunk, $pos1+5, $pos2-1);
        return $cleanurl;
    // }
    //      return the url
    // else return null

}

function write_static_file($url) {
    global $url_list;
    $out_html = '';

    $html = file_get_contents($url);
        $cnt = strlen($html);
        $pieces = explode("<a", $html); // explode is cool.
       
        foreach($pieces as $piece) {
            // store the url from each link for later processing as its own page
            // get_clean_url will only return relevant urls
            $oldurl = get_clean_url($piece);
            if( $oldurl) {
                // if we've seen this url before, do nothing
                // else add to "seen" list and push onto the url array
                array_push( $url_list, $oldurl );
            }
            // if it's not 
            // change the url within the piece of text if we need to
            // if it's not a comment url

            // the pieces are reassembled one by one so we have changed-out full page text
            $out_html = $out_html . $piece . '<a';
        }
        // last loop has left '<a' on end of file, this clips those two characters off.
        $out_html = substr($out_html, 0, -2);
        
        file_put_contents("bobby.html", $out_html);
}

function write_static_site () {
    global $url_list;
    while( $url = array_pop($url_list)) {
        write_static_file($url);
    }
}


write_static_site();


   

   





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