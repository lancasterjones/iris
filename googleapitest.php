<?php

 
/*

  $client = new Google_Client();
$client->setClientId(421555446319-0h80flbkju1vqagjkbsc9jl7ahjoubug.apps.googleusercontent.com);
$client->setClientSecret(JqHvAtOgzkbM_CqrxGL1MhU0);
$client->setRedirectUri($redirect_uri);

  $service = new Google_Service_Books($client);
  $optParams = array('filter' => 'free-ebooks');
  $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

  foreach ($results as $item) {
    echo $item['volumeInfo']['title'], "<br /> \n";
  }

echo "Hello World";

*/

/*
 * Copyright 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once "templates/base.php";
echo pageHeader("Simple API Access");
/************************************************
  Make a simple API request using a key. In this
  example we're not making a request as a
  specific user, but simply indicating that the
  request comes from our application, and hence
  should use our quota, which is higher than the
  anonymous quota (which is limited per IP).
 ************************************************/
require_once '/libraries/GoogleClientAPI/src/Google/autoload.php'; // or wherever autoload.php is located
/************************************************
  We create the client and set the simple API
  access key. If you comment out the call to
  setDeveloperKey, the request may still succeed
  using the anonymous quota.
 ************************************************/
$client = new Google_Client();
$client->setApplicationName("Client_Library_Examples");
$apiKey = "AIzaSyDfOXaHjoTSQbIOHX-p6HROTOZmIS4QIEA"; // Change this line.
// Warn if the API key isn't changed.
if (strpos($apiKey, "<") !== false) {
  echo missingApiKeyWarning();
  exit;
}
$client->setDeveloperKey($apiKey);
$service = new Google_Service_Books($client);
/************************************************
  We make a call to our service, which will
  normally map to the structure of the API.
  In this case $service is Books API, the
  resource is volumes, and the method is
  listVolumes. We pass it a required parameters
  (the query), and an array of named optional
  parameters.
 ************************************************/
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
/************************************************
  This call returns a list of volumes, so we
  can iterate over them as normal with any
  array.
  Some calls will return a single item which we
  can immediately use. The individual responses
  are typed as Google_Service_Books_Volume, but
  can be treated as an array.
 ***********************************************/
echo "<h3>Results Of Call:</h3>";
foreach ($results as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}
/************************************************
  This is an example of deferring a call.
 ***********************************************/
$client->setDefer(true);
$optParams = array('filter' => 'free-ebooks');
$request = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
$results = $client->execute($request);
echo "<h3>Results Of Deferred Call:</h3>";
foreach ($results as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}
echo pageFooter(__FILE__);
/*
require_once ('/libraries/GoogleClientAPI/src/Google/Client.php');
require_once ('/libraries/GoogleClientAPI/src/Google/Service/Analytics.php');


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

echo 'Hello, world.';

?>