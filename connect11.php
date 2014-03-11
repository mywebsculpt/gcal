<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();

// 1. Including Google Analytics SDK
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_AnalyticsService.php';

//$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

// 2. Creating Client Object
$client = new Google_Client();
$client->setApplicationName('Google Analytics API Demo');
$client->setAccessType('offline');
$client->setUseObjects(true);

// 3. Client ID, secret and key is taken from API Console
$client->setClientId('317756038178.apps.googleusercontent.com');
$client->setClientSecret('Ci0oomBUEiudY1zve-KZHTcD');
$client->setDeveloperKey('AIzaSyAuR3FsCy37vPx_ad4zxiGGD5OiKSKpqZI');
$client->setRedirectUri('http://localhost/gcal/connect11.php');

// 4. Create analytics object
$service = new Google_AnalyticsService($client);

// 5. If url contains logout query string, clear session
if (isset($_GET['logout']))
{
  unset($_SESSION['token']);
  die('Logged out.');
}

/*if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
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
}*/

// 6. Reading code to authenticate
if (isset($_GET['code'])) {
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://localhost/google-analytics/connect11.php';
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

// 7. Setting Access Token
if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}


/*
//session_start();

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
 
// 1. Including Google Analytics SDK
require_once 'src/Google_Client.php';
//require_once 'src/contrib/Google_AnalyticsService.php';
require_once 'src/contrib/Google_CalendarService.php';
 
$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");
$client->setAccessType('offline'); // default: offline
// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('444875790893.apps.googleusercontent.com');
$client->setClientSecret('vEZJppTkBekMeuyRNZE2uZSj');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyB6um81kinozzNTDQuDY9CM7Uy2FpToImw');

$cal = new Google_CalendarService($client);
if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	exit;
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $calList = $cal->calendarList->listCalendarList();
  print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";


$_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
*/

############################################################################
/*--------------------------------------------------------------------------
$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
// $scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'];

// 1. Including Google Analytics SDK
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_CalendarService.php';

$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");

$client->setAccessType('offline'); // default: offline

$client->setClientId('444875790893.apps.googleusercontent.com');
$client->setClientSecret('vEZJppTkBekMeuyRNZE2uZSj');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyB6um81kinozzNTDQuDY9CM7Uy2FpToImw');

$cal = new Google_CalendarService($client);

if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
  exit;
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken())
{
	$calList = $cal->calendarList->listCalendarList();
  	print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";
	$_SESSION['token'] = $client->getAccessToken();
}
else
{
	$authUrl = $client->createAuthUrl();
  	print "<a class='login' href='$authUrl'>Connect Me!</a>";
} 
-------------------------------------------------------*/
?>