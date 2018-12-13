<?php
session_start();
echo "Session id: " . session_id() . "<br>\n";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $errors = 0;
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
         echo "<p>Unable to connect to database server error code: " . mysqli_connect_error() . "</p>\n";
      }
      else {
        // this will select the database that we want to work on
        $result = mysqli_select_db($DBConnect, $DBName);
        // if there is no result to selecting the database then it will display an error
        if (!$result) {
          ++$errors;
        echo "<p>Unable to select the database \"$DBName\" error code: " . mysqli_error($DBConnect) . "</p>\n";
        } 
      }
    }


    $TableName = "clients";
    if (isset($_POST['Efirst'])) {

        $first_new = $_POST['Efirst'];

        echo"<p>$first_new</p>";

        $last_new = $_POST['Elast'];

        echo"<p>$last_new</p>";

        $email_new = $_POST['Eemail'];

        echo"<p>$email_new</p>";

        $company_new = $_POST['Ecompany'];

        echo"<p>$company_new</p>";

        

        //
        
        //code for client ID
                $client = $_SESSION['clientID'];
            //This updates the information
            // $SQLstrings = "UPDATE clients SET email = '$email_new',
            //  first = '$first_new',
            //   last = '$last_new',
            //    Company_name = '$company_new',
            //     WHERE clients . clientID = $client;";
            $SQLstrings = "UPDATE clients SET email = '$email_new', first = '$first_new', last = '$last_new', Company_name = '$company_new' WHERE clients.clientID = $client;";
            $qsResults = mysqli_query($DBConnect, $SQLstrings);
            if (isset($qsResults)) {
                echo"Your new information is saved";
            }
        }

        echo "<p style='text-align: center;'><a href='Done.php?" . "PHPSESSID=" . session_id() . "'>Next Page" . "</a></p>\n";
    ?>
</body>
</html>