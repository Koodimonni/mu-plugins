<?php
/*
Plugin Name: Koodimonni Hosting
Version: 0.1
Description: Contains small fixes and optimisations with wordpress
Author: Onni Hakala / Koodimonni
Author URI: http://koodimonni.fi
*/

/*
 * Replace @localhost with siteurl hostname as email sender
 */
add_filter( 'wp_mail_from', 'my_mail_from', 10000 );
function my_mail_from( $email ) {
  if (endsWith($email,'@localhost') || empty($email)) {
    $parsed = parse_url(get_site_url());
    $hostname = removeWWW($parsed['host']);
    return "no-reply@{$hostname}";
  }
}



/*
 * Helper functions
 */
function endsWith($haystack, $needle) {
  // search forward starting from end minus needle length characters
  return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
}

function removeWWW($hostname) {
  return preg_replace('#^www\.(.+\.)#i', '$1', $hostname );
}