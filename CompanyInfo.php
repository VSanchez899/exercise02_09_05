<?php
session_start();
    $body = "";
    $errors = 0;
    $email = "";
    $hostname = "localhost";
    $username = "adminer";
    $passwd = "judge-quick-25";
    $DBConnect = false;
    $DBName = "procon1";
    
    if (empty($_POST['email'])) {
        ++$errors;
        echo "<p style='text-align: center;'>You need to enter an e-mail address</p>\n";
    }
    else{
        $email = stripslashes($_POST['email']);
        if (preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[w-]+)*(\.[A-Za-z]{2,})$/i", $email) == 0) {
            ++$errors;
            $body .= "<p style='text-align: center;'>You need to enter a valid e-mail address.</p>\n";
            $email = "";
        }
        
    }
    if (empty($_POST['password'])) {
        ++$errors;
        $body .= "<p style='text-align: center;'>You need to enter a password</p>\n";
    }
    else{
        $password = stripslashes($_POST['password']);
        }
        
    if (empty($_POST['password2'])) {
        ++$errors;
        $body .= "<p style='text-align: center;'>You need to Confirm password</p>\n";
        }
    else{
        $password2 = stripslashes($_POST['password2']);
        }
        if (!empty($password) && !empty($password2)) {
            if (strlen($password) < 6) {
                ++$errors;
                $body .= "<p style='text-align: center;'>The password is too short</p>\n";
                $password = "";
                $password2 = "";
            }
            if ($password <> $password2) {
                ++$errors;
                $body .= "<p style='text-align: center;'>The password do not match</p>\n";
                $password = "";
                $password2 = "";
            }
        }
        
        if ($errors == 0) {
            $DBConnect = mysqli_connect($hostname, $username, $passwd);
            if (!$DBConnect) {
                ++$errors;
                $body .= "<p style='text-align: center;'>unable to connect to database server error code: " . mysqli_connect_error() . "</p>\n";
            }
            else {
                $result = mysqli_select_db($DBConnect, $DBName);
                if (!$result) {
                    ++$errors;
                    $body .= "<p style='text-align: center;'>unable to select the database \"$DBName\" error code: " . mysqli_connect_error() . "</p>\n";
                } else {
                    
                }
                
                
            }
            $TableName = "clients";
            if ($errors == 0) {
                $SQLstring = "SELECT count(*) FROM $TableName" . 
                " WHERE email='$email'";
                $queryResult = mysqli_query($DBConnect, $SQLstring);
                if ($queryResult) {
                    $row = mysqli_fetch_row($queryResult);
                    if ($row[0] > 0) {
                        ++$errors;
                        $body .= "<p style='text-align: center;'>The e-mail address entered (" . htmlentities($email) . ") is already registered.</p>\n";
                    }
                }
            }
            if ($errors == 0) {
                $first = stripslashes($_POST['first']);
                $last = stripslashes($_POST['last']);
                $company = stripslashes($_POST['company']);
                $SQLstring = "INSERT INTO $TableName" .
                " (first, last, email, Company_name, password_md5,)" .
                " VALUES('$first', '$last', '$email', '$company', " . 
                "'" . md5($password) . "')";
                $queryResult = mysqli_query($DBConnect, $SQLstring);
                if (!$queryResult) {
                    ++$errors;
                    $body .= "<p style='text-align: center;'>unable to save your registration error code: " . mysqli_error($DBConnect) . "</p>\n";
                }
                else {
                  //  $clientID = mysqli_insert_id($DBConnect);
                  $_SESSION['clientID'] = mysqli_insert_id($DBConnect);
                }
            }
        }
        if ($errors == 0) {
            $clientName = $first . " " . $last;
            $body .= "<p style='text-align: center;'>Thank you, $clientName. " . "Your new Client ID is <strong>" . 
                $_SESSION['clientID'] . "</strong>.</p>\n";
        }
        if ($DBConnect) {
            //setcookie("clientID", $clientID);
            setcookie("clientID", $_SESSION['clientID']);
            $body .= "<p style='text-align: center;'>closing Database \"$DBName\" connection.</p>\n";
            $body .= "<p><a href='SelectConference.php?" . "PHPSESSID=" . session_id() . "'>" . "View Conferences</a></p>\n";
            mysqli_close($DBConnect);
            // $body .= "<form action='AvailableOpportunities.php' method='post'>\n";
            // $body .= "<input type='hidden' name='clientID' value='$clientID'>\n";
            // $body .= "<p style='text-align: center;'><input type='submit' name='submit' value='View Available Opportunities'></p>";
            // $body .= "</form>\n";
        }
        if ($errors > 0) {
            $body .= "<p style='text-align: center;'>Please use your browser's BACK button to return to the form and fix the errors indicated</p>";
        }
    ?>
<!DOCTYPE html>
<html lang="en" style="background-color: grey;">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <h1 style="text-align: center;">Client Conferences</h1>
    <h2 style="text-align: center;">Client Registration</h2>
    <?php
    echo "$body";
    ?>
    //register intern
    </body>
</html>