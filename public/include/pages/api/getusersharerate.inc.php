<?php

// Make sure we are called from index.php
if (!defined('SECURITY')) die('Hacking attempt');

// Check if the API is activated
$api->isActive();

// Check user token
$user_id = $api->checkAccess($user->checkApiKey($_REQUEST['api_key']), @$_REQUEST['id']);
$username = $user->getUsername($user_id);

// Fetch settings
if ( ! $interval = $setting->getValue('statistics_ajax_data_interval')) $interval = 300;

// Gather un-cached data
$statistics->setGetCache(false);
$sharerate = $statistics->getUserSharerate($username, $user_id, $interval);
$statistics->setGetCache(true);

// Output JSON format
echo $api->get_json($sharerate);

// Supress master template
$supress_master = 1;
?>
