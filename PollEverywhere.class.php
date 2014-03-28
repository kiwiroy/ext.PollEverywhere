<?php

class PollEverywhere {
  private static $polljs =
    'http://www.polleverywhere.com/%s/%s/%s.js?result_count_format=%s&width=%d&height=%d';
  private static $script = 
    '<script>mw.loader.implement("ext.PollEverywhere.js", ["%s/PollEverywhere.javascript.php?data=%s"], {}, {})</script>';
  
  static function setup( $parser ) {
    $parser->setHook('pollev', array(__CLASS__, 'load_poll'));
    return true;
  }
  
  static function load_poll($input, array $args, Parser $parser, PPFrame $frame) {
    global $wgPollEverywhereCommonJS, $wgOut, $wgResourceModules;
    $parser->disableCache();

    $data        = self::encode_data(array("id"     => $input, 
					   "type"   => $args['type'],
					   "format" => "percent",
					   "width"  => $args['width'],
					   "height" => $args['height']));

    $remote_path = $wgResourceModules['ext.PollEverywhere.js']['remoteBasePath'];
    $content     = sprintf(self::$script, $remote_path, $data);
    
    return $content ;
  }
  
  static function encode_data (array $data) {
    $qstring = array();
    foreach ($data as $key => $value) {
      $qstring[] = sprintf("%s=%s", $key, $value);
    }
    $encoded = urlencode(base64_encode(implode("&", $qstring)));
    return $encoded;
  }

  static function decode_data ($data) {
    $request = array();
    $decoded = urldecode(base64_decode($data));
    $parts   = split("&", $decoded);
    foreach ($parts as $kv) {
      list($key, $value) = split("=", $kv, 2);
      $request[$key] = $value;
    }
    return $request;
  }

  static function get_script_contents ($url) {
    global $wgHTTPProxy, $wgHTTPTimeout;
    $ch = curl_init();

    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    if(isset($wgHTTPProxy)) {
      curl_setopt ($ch, CURLOPT_PROXY, $wgHTTPProxy);
    }
    if(isset($wgHTTPTimeout)) {
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $wgHTTPTimeout);
    }
    $string = curl_exec ($ch);
    curl_close ($ch);

    return $string;    
  }

  static function poll_script_url($id, $type, $format, $width, $height) {
    $script = 'web';
    switch ($type) 
      {
      case "ftp":
	$type   = '';
	$script = '';
	break;
      case "mcp":
      case "multiple_choice_polls":
	$type   = 'multiple_choice_polls';
	$script = 'web';
	break;
      case "chart":
	$type   = 'polls';
	$script = 'chart_widget';
	break;
      default:
	$type   = 'multiple_choice_polls';
	$script = 'web';
	break;   
      }

    $poll_url = sprintf(self::$polljs,
			$type, $id, $script, $format, $width, $height);
    return $poll_url;
  }

}
