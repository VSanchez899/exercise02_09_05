<?php
session_start();
$body = "";
$errors = "0";
$clientID = "0";
// if (isset($_GET['internID'])) {
//     $clientID = $_GET['internID'];
// }
if (!isset($_SESSION['clientID'])) {
    ++$errors;
    $body .= "<p>You have not logged in or registered</p>" . 
    " please return to the  " . 
    "<a href='home.php'>" . 
    "Registration / Login Page</a></p>";
}
if ($errors == 0) {
    if (isset($_GET['conferenceID'])) {
        $conferenceID = $_GET['conferenceID'];
    } else {
        ++$errors;
        $body .= "<p>You have not selected a conference</p>" . 
        " please return to the  " . 
        "<a href='SelectConference.php?" . 
        "PHPSESSID=" . session_id() . "'>" . 
        "Select Conference Page</a></p>";
    }
}
$hostname = "localhost";
  $username = "adminer";
  $passwd = "judge-quick-25";
  $DBConnect = false;
  $DBName = "procon1"; 
  // if there are no errors then it will connect
  if ($errors == 0) {
    $DBConnect = mysqli_connect($hostname, $username, $passwd);
    // if there is no connection to the server then it will display an error 
    if (!$DBConnect) {
      ++$errors;
      $body .= "<p>Unable to connect to database server error code: " . mysqli_connect_error() . "</p>\n";
    }
    else {
      // this will select the database that we want to work on
      $result = mysqli_select_db($DBConnect, $DBName);
      // if there is no result to selecting the database then it will display an error
      if (!$result) {
        ++$errors;
        $body .= "<p>Unable to select the database \"$DBName\" error code: " . mysqli_error($DBConnect) . "</p>\n";
      } 
    }
  }
  $displayDate = date("l, F j, Y, g:i A");
  $body .= "\$displayDate: $displayDate<br>";
  $dbDate = date("Y-m-d H:i:s");
  $body .= "\$dbDate: $dbDate<br>";
  if ($errors == 0) {
      $tableName = "assigned_opportunities";
      $SQLstring = "INSERT INTO $tableName" . 
      " (conferenceID, internID, dateSelected)" . 
      " VALUES($conferenceID, " . 
      $_SESSION['internID'] . ", '$dbDate')";
      $queryResult = mysqli_query($DBConnect, $SQLstring);
      if (!$queryResult) {
          ++$errors;
          $body .= "<p>Unable to execute the query, " . 
          "error code: " . mysqli_errno($DBConnect) . ": " .
          mysqli_error($DBConnect) .
          "</p>\n";
      }
      else {
          $body .= "<p>Your results for opportunity #" . 
          " $conferenceID have been entered on" . 
          " $displayDate" . "</p>\n";
      }
  }
  if ($DBConnect) {
    $body .= "<p>Closing database \"$DBName\" connection.</p>\n";
    mysqli_close($DBConnect);
  }
  if ($_SESSION['internID'] > 0) {
      $body .= "<p>return to the " . 
      "<a href='SelectConference.php?" . 
      "PHPSESSID=" . session_id() . "'>Select Conference" . 
      "</a> page.</p>\n";
  }
  else {
      $body .= "<p>Please" .
      "<a href='InternLogin.php'>" .
      "Register or Log in" . 
      "</a> to use this page.</p>\n";
  }
  if ($errors == 0) {
      echo "Setting Cookie<br>";
      setcookie("LastRequestDate", urlencode($displayDate), time()+60*60*24*7);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>College Intern</h1>
    <h2>Opportunity Requested</h2>
    <?php
    echo $body;
    ?>
    //request opportunity
</body>
</html>