<?php

if ( ! defined( 'MEDIAWIKI' ) ) {
   die();
}
 
$wgExtensionCredits['parserhook'][] = array(
   'path'           => __FILE__,
   'name'           => 'PollEverywhere',
   'author'         => 'Roy Storey',
   'url'            => 'https://github.com/kiwiroy/ext.PollEverywhere',
   'descriptionmsg' => 'polleverywhere-desc',
);

$dir = dirname( __FILE__ );

$wgHooks['ParserFirstCallInit'][]           = 'PollEverywhere::setup';
$wgAutoloadClasses['PollEverywhere']        = $dir . '/PollEverywhere.class.php';
$wgExtensionMessagesFiles['PollEverywhere'] = $dir . '/PollEverywhere.i18n.php';

$wgResourceModules['ext.PollEverywhere.js'] = array(
   'scripts'        => array('PollEverywhere.javascript.php'),
   'remoteBasePath' => $wgScriptPath . '/extensions/PollEverywhere',
);
