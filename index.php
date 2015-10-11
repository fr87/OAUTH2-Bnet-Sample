<?php

// include libs

require('OAuth2/Client.php');
require('OAuth2/GrantType/IGrantType.php');
require('OAuth2/GrantType/AuthorizationCode.php');

// Set URL parameter

$client_id = ''; // Key from https://dev.battle.net
$client_secret = ''; // Secret from https://dev.battle.net
$state = 'test'; // this state will be shown in the address bar

$scope = 'wow.profile'; // fetch wow data (sc2.profile for STARCRAFT II)

$redirect_uri = 'https://yourdomain.de'; // Enter your domain - IMPORTANT! HTTPS
$authorize_uri = 'https://eu.battle.net/oauth/authorize'; // Should be fine (watch the region)
$token_uri = 'https://eu.battle.net/oauth/token'; // Should be fine (watch the region)

// Create new oauth2

$client = new OAuth2\Client($client_id, $client_secret);

// if no code parameter request token

if (!isset($_GET['code'])) {

 $auth_url = $authorize_uri.'?client_id='.$client_id.'&scope='.$scope.'&state='.$state.'&redirect_uri='.$redirect_uri.'&response_type=code';
 header('Location: ' . $auth_url);

 die('Redirect');  // LOOP DIE
}
else {

 // else get token and access data

 $params = array('code' => $_GET['code'], 'redirect_uri' => $redirect_uri);
 $response = $client->getAccessToken($token_uri, 'authorization_code', $params);
 $info = $response['result'];
 $client->setAccessToken($info['access_token']);
 $response = $client->fetch('https://eu.api.battle.net/wow/user/characters'); // edit region
 
 var_dump($response); // output
}
?>
