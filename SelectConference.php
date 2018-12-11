


//NEW CODE
<?php
session_start();
echo "Session id: " . session_id() . "<br>\n";
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Opportunities</title>
</head>

<body>
    <h1>College Internship</h1>
    <h2>Available Opportunities</h2>
    <?php
    
    // if (isset($_REQUEST['internID'])) {
    //     $internID = $_REQUEST['internID'];
    // } else {
    //     $internID = -1;
    // }
    // //debug
    // echo "\$internID: $internID\n";
    if (isset($_COOKIE['LastRequestDate'])) {
        $lastRequestDate =
         urldecode($_COOKIE['LastRequestDate']);
    }
    else {
        $lastRequestDate = "";
    }
    
    $errors = 0;
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "judge-quick-25";
    $DBConnect = false;
    $DBName = "procon1"; 
    if ($errors == 0) {
        $DBConnect = mysqli_connect($hostname, $username, $passwd);
        if (!$DBConnect) {
            ++$errors;
             echo "<p>Unable to connect to database server error code: " . mysqli_connect_error() . "</p>\n";
        }
        else {
            $result = mysqli_select_db($DBConnect, $DBName);
            if (!$result) {
                ++$errors;
            echo "<p>Unable to select the database \"$DBName\" error code: " . mysqli_error($DBConnect) . "</p>\n";
            } 
        }
    }
    $TableName = "clients";
    if ($errors == 0) {
        $SQLstring = "SELECT * FROM $TableName" . " WHERE clientID='" . $_SESSION['clientID'] . "'";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (!$queryResult) {
            ++$errors;
            echo "<p>Unable to execute the query, error code: " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>\n";
        } 
        else {
        if (mysqli_num_rows($queryResult) == 0) {
            ++$errors;
            echo "<p>Invalid client ID!</p>\n";
        }
    }
    }
    if ($errors == 0) {
        $row = mysqli_fetch_assoc($queryResult);
        $ClientName = $row['first'] . " " . $row['last'];  
    }
    else {
        $ClientName = "";
    }
    echo "\$ClientName: $ClientName";
    $TableName = "assigned_conferences";
    
    if ($errors == 0) {
    $SQLstring = "SELECT COUNT(conferenceID)" . " FROM $TableName" . " WHERE clientID='" . $_SESSION['clientID'] . "'" . " AND date_approved IS NOT NULL";
    $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (mysqli_num_rows($queryResult) > 0) {
        $row = mysqli_fetch_row($queryResult);
        $approvedConferences = $row[0];
        mysqli_free_result($queryResult);
    }
    $selectedConferences = array();
        $SQLstring = "SELECT conferenceID FROM $TableName" . " WHERE clientID='". $_SESSION['clientID'] . "'";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
        if (mysqli_num_rows($queryResult) > 0) {
            while (($row = mysqli_fetch_row($queryResult)) != false) {
                $selectedConferences[] = $row[0]; 
            }
            mysqli_free_result($queryResult);
        }
        $assignedConferences = array();
        $SQLstring = "SELECT conferenceID FROM $TableName" . " WHERE date_approved IS NOT NULL";
        $queryResult = mysqli_query($DBConnect, $SQLstring);
    if (mysqli_num_rows($queryResult) > 0) {
            while (($row = mysqli_fetch_row($queryResult)) != false) {
                $assignedConferences[] = $row[0]; 
            }
            mysqli_free_result($queryResult);
        }
    $TableName = "Conferences";
    $opportunities = array();
    $SQLstring = "SELECT conferenceID, company, city," . " event_date, event_end_date, position, description" .
        " FROM $TableName";
    $queryResult = mysqli_query($DBConnect , $SQLstring);
        if (mysqli_num_rows($queryResult) > 0) {
            while (($row = mysqli_fetch_assoc($queryResult)) != false) {
                $Conferences[] = $row; 
            }
            mysqli_free_result($queryResult);
        } 
    }
    if ($DBConnect) {
        echo "<p>Closing database \"$DBName\" connection.</p>\n";
            mysqli_close($DBConnect);
    }
    if (!empty($lastRequestDate)) {
        echo "<p>You last requested a conference" . " on $lastRequestDate.</p>\n";
    }
    echo "<table border='1' width='100%'>\n";
    echo "<tr>\n";
    echo "<th style='background-color: red'>Company</th>\n";
    echo "<th style='background-color: green'>City</th>\n";
    echo "<th style='background-color: red'>State</th>\n";
    echo "<th style='background-color: green'>End Date</th>\n";
    echo "<th style='background-color: red'>Position</th>\n";
    echo "<th style='background-color: green'>Description</th>\n";
    echo "<th style='background-color: red'>Status</th>\n";
    echo "</tr>\n";
    foreach ($Conferences as $conference) {
        if (!in_array($conference['conferenceID'], $assignedConferences)) {
            echo "<tr>\n";
            echo "<td>" . htmlentities($conference['company']) . "</td>\n";
            echo "<td>" . htmlentities($conference['city']) . "</td>\n";
            echo "<td>" . htmlentities($conference['event_date']) . "</td>\n";
            echo "<td>" . htmlentities($conference['event_end_date']) . "</td>\n";
            echo "<td>" . htmlentities($conference['position']) . "</td>\n";
            echo "<td>" . htmlentities($conference['description']) . "</td>\n";
            echo "<td>\n";
            if (in_array($conference['conferenceID'], $selectedConferences)) {
                echo "Selected";
            }
            else if($approvedConferences > 0) {
                echo "Open";
            }
            else {
                echo "<a href='SubmitInfo.php?" . "PHPSESSID=" . session_id() . "&conferenceID=" . $conference['conferenceID'] . "'>Available</a>\n";
            }
            echo "</td>\n";
            echo "</tr>\n";
        }
    }
    echo "</table>\n";
    echo "<p style='text-align: center;'><a href='Done.php?" . "PHPSESSID=" . session_id() . "'>Next Page" . "</a></p>\n";
    echo "<p style='text-align: center;'><a href='home.php'>Log Out</a></p>\n";
    ?>
</body>
</html>