<?php
// testing github
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();

// 1. Including Google Analytics SDK
require_once 'src/Google_Client.php';
//require_once 'src/contrib/Google_AnalyticsService.php';
require_once 'src/contrib/Google_CalendarService.php';

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");
//$client->setAccessType('online');
$client->setAccessType('offline'); // default: offline
$client->setUseObjects(true);

$client->setClientId('317756038178-qso1cv3tjr74it3hsgo8u10vlfcbbm6p.apps.googleusercontent.com');
$client->setClientSecret('Lzd6shLUlBAoN041o_9EybEx');
$client->setDeveloperKey('AIzaSyAy4XyBfWc5hcLKaoQKIfbkOkko0nS2SWs');
//$client->setRedirectUri('http://localhost/gcal/connect111.php');
$client->setRedirectUri($scriptUri);

$cal = new Google_CalendarService($client);

if (isset($_GET['logout']))
{
  unset($_SESSION['token']);
}

if(isset($_GET['code']))
{
	$client->authenticate($_GET['code']);
 	$_SESSION['token'] = $client->getAccessToken();
  	header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
  	exit;
}
/*
if ($client->isAccessTokenExpired())
{
	session_destroy();
    header('Location: login.php');
}
*/
if(isset($_SESSION['token']))
{
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken())
{
	//$calList = $cal->calendarList->listCalendarList();
	//print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";
	//die;
	
	$start = date(DATE_ATOM,strtotime('now'));
	$end = date(DATE_ATOM,strtotime('+1 month'));
	
	$params = array(
	'singleEvents' => 'true',
	'timeMax' => $end,
	'timeMin' => $start,
	'orderBy' => 'startTime');
	
	$calList = $cal->calendarList->listCalendarList();
	
	//print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";

	foreach($calList->getItems()as $calendarListEntry)
	{
		 $arrcalids[] = $calendarListEntry->id;
	}
	//print "<pre>" . print_r($arrcalids) . "</pre>";
	//die('..test');
	
	foreach ($arrcalids as $key => $email)
	{
		//echo "<br> email :".$email;
		
		/*
		$event_list = $cal->events->listEvents($email, $params);
		$events = $event_list->getItems();
		echo '<table border="1"><thead>';
		echo '<th>ID</th><th>SAFE</th><th>Start</th><th>End</th></tr></thead>';
		foreach ($events as $event)
		{
			echo '<tr>';
			echo '<td>'.$event->getId().'</td>';
			echo '<td>'.$event->getSummary().'</td>';
			echo '<td>'.$event->getStart()->getDateTime().'</td>';
			echo '<td>'.$event->getEnd()->getDateTime().'</td>';
			echo '</tr>';
		}
		echo '</table>';
		$_SESSION['token'] = $client->getAccessToken();
		 */
		
				
	// add events
	# Create New Event.....
	$event = new Google_Event();
	$event->setSummary('Halloween test');
	$event->setLocation('The Neighbourhood');
	$start = new Google_EventDateTime();
	$start->setDateTime('2014-03-11T10:00:00.000-05:00');
	$event->setStart($start);
	$end = new Google_EventDateTime();
	$end->setDateTime('2014-03-11T10:25:00.000-05:00');
	$event->setEnd($end);
	$createdEvent = $cal->events->insert($email, $event); //Returns array not an object
	
	//echo $createdEvent->id;
	// add events
		
	}

	
}
else
{
	$authUrl = $client->createAuthUrl();
  	print "<a class='login' href='$authUrl'>Connect Me!</a>";
} 
?>