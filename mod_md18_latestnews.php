<?php

defined('_JEXEC') or die;
require_once dirname(__FILE__).'/helper.php';

$catid   = $params->get( 'catid', 0 );
$maxlimit  	= 	$params->get( 'items_maxlimit', 10 );

$layout = JModuleHelper::getLayoutPath('mod_md18_latestnews');
$options = modMD18LastNewsHelper::getMD18LastNewsOptions($catid, $maxlimit);

require($layout);

?>
