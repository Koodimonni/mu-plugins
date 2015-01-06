<?php
/*
Plugin Name: Koodimonni Hosting tweaks
Version: 0.1
Description: Contains small tweaks which make default wordpress behaviour little better
Author: Onni Hakala / Koodimonni
Author URI: http://koodimonni.fi
*/

/*
 * Replace @localhost with siteurl hostname as email sender
 * Some environments put localhost as hostname and this is easy fix
 */
add_filter( 'wp_mail_from', 'koodimonni_mail_from', 10000 );
function koodimonni_mail_from( $email ) {
  if (endsWith($email,'@localhost') || empty($email)) {
    $parsed = parse_url(get_site_url());
    $hostname = removeWWW($parsed['host']);
    return "no-reply@{$hostname}";
  }
}

/*
 * Use 403 forbidden status code after unsuccesful login.
 * This helps monitoring login attempts and to integrate fail2ban
 * Source: http://kovshenin.com/2014/fail2ban-wordpress-nginx/
 */
function koodimonni_login_failed_403() {
    status_header( 403 );
}
add_action( 'wp_login_failed', 'koodimonni_login_failed_403' );


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