<?php
  // Lookup and initiate proxy session

  // Setup
  require_once './vendor/autoload.php';
  use SignalWire\LaML;
  $response = new LaML();

  // Load environment variables from .env
  $dotenv = Dotenv\Dotenv::createImmutable('.');
  $dotenv->load();

  // Mapping the to and from numbers
  $proxyNumber = $_REQUEST['To'];
  $leg1 = $_REQUEST['From'];

  // Parse the rest from Request Headers
  if (array_key_exists('MessageSid', $_REQUEST)) {
    $smstype = True;
    $textmsg = $_REQUEST['Body'];
  }
  if (array_key_exists('CallSid', $_REQUEST)) {
    $calltype = True;
  }

  // Getting the proxy session data
  $found = False;
  $sessions = json_decode(file_get_contents("./proxy_sessions.json"),true);
  foreach ($sessions as $session) {
  # Lookup the second session participant, if A is calling
    if ($session["Proxy_Number"] == $proxyNumber && $session["Participant_A_Number"] == $leg1) {
      $leg2 = $session["Participant_B_Number"];
      $found = True;
      break;
    } elseif ($session["Proxy_Number"] == $proxyNumber && $session["Participant_B_Number"] == $leg1) {
      $leg2 = $session["Participant_A_Number"];
      $found = True;
      break;
    }
  }

  // Customize this text string
  $errormsg = "We are sorry but your session could not be connected at this time.";

  // SMS use case
  if ($smstype) {

    // Forwaard text rewriting From
    if ($found == True) {
      $response->message($textmsg,
                         array('from' => $proxyNumber,
                               'to' => $leg2)
                        );
      echo $response;

    // Send back error
    } else {
      $response->message($errormsg,
                         array('from' => $proxyNumber,
                              'to' => $leg1)
                         );
    echo $response;
    }

 // Voice use case
 } elseif ($calltype) {

     // Forward call and rewriter Caller ID
     if ($found == True) {
       $response->dial($leg2, array('callerId' => $proxyNumber));
       echo $response;

     // Give error prompt and hangup
     } else {
       $response->say($errormsg);
       $response->hangup();
       echo $response;
     }

  // Error
  } else {
    echo "This script must be called from a SignalWire Webhook.\n";
  }
?>
