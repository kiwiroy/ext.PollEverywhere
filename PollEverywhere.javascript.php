<?php

  // Some settings to use... 
  // Sadly we have to set here as LocalSettings.php isn't loaded :(
  //
  // wgHTTPProxy - makes proxy traversal possible
  //               set to proxy.host.tld:port
  // wgHTTPTimeout - makes the connection timeout after x seconds

$wgHTTPProxy   = NULL; // "proxy.host.com:8080"
$wgHTTPTimeout = 2;


// load the class
require_once(dirname(__FILE__) . '/PollEverywhere.class.php');

// decode the quest string - we have to pass a single parameter :(
$data = PollEverywhere::decode_data($_GET['data']);

// set some defaults
$id       = $data['id'];
$type     = $data['type']   ? $data['type']   : 'normal';
$format   = $data['format'] ? $data['format'] : 'percent';
$width    = $data['width']  ? $data['width']  : 300;
$height   = $data['height'] ? $data['height'] : 250;

// produce the URL of the script
$poll_url = PollEverywhere::poll_script_url($id, $type, $format, $width, $height);
// download the script
$content  = PollEverywhere::get_script_contents( $poll_url );
// need to change http for just //
$content  = preg_replace("/http:/", "", $content);
// fix for multi-voting not showing chart...
$content  = preg_replace("/(notice\(this.errors.pop\(\)\);)/", "widgetController.action('chart'); $1", $content);

// display the script...
echo $content;
