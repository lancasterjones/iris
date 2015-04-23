<?php
session_start();
/* require_once ('/libraries/GoogleClientApi/Google_Client.php');
require_once ('/libraries/GoogleClientApi/contrib/Google_AnalyticsService.php');

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setApplicationName('Extractor de LOB a Vende');
$client->setClientId('421555446319-0h80flbkju1vqagjkbsc9jl7ahjoubug.apps.googleusercontent.com');
$client->setClientSecret('JqHvAtOgzkbM_CqrxGL1MhU0');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyDfOXaHjoTSQbIOHX-p6HROTOZmIS4QIEA'); // API key

// $service implements the client interface, has to be set before auth call
$service = new Google_AnalyticsService($client);

if (isset($_GET['logout'])) { // logout: destroy token
    unset($_SESSION['token']);
	die('Logged out.');
}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
}

if (isset($_SESSION['token'])) { // extract token from session and configure client
    $token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();
    header("Location: ".$authUrl);
    die;
} 
*/
echo 'Hello, world.';

?>