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
    <h1 style="text-align: center;">Want to Edit Anything?</h1>
    <!-- <form action="EditInfo.php" method="post">
    <p style='text-align: center;'>Enter your name: First
            <input type="text" name="Efirst" value="">
            Last:
            <input type="text" name="Elast" value="">
        </p>
        <p style='text-align: center;'>
            Enter your email address:
            <input type="text" name="Eemail" value="">
        </p>
        <p style='text-align: center;'>
            Enter a Company Name for your account:
                <input type="text" name="Ecompany" value="">
        </p>
        <p style='text-align: center;'>
            Enter a password for your account:
                <input type="password" name="Epassword" value="">
        </p>
        <p style='text-align: center;'>
            Confirm your password
                <input type="password" name="Epassword2" value="">
        </p>
        <p style='text-align: center;'><em>(Passwords are case-sensitive and must be at least 6 charaters long.)</em></p>
        <p style='text-align: center;'><input  style='text-align: center;' type="reset" name="reset" value="Reset Registration Form"></p>
        <p style='text-align: center;'><input  type="submit" name="register" value="Register"></p>
    </form> -->
    <?php
//Connection to database
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





    //new code to fetch old data
    $TableName = "clients";
  if ($errors == 0) {
    $SQLstring = "SELECT clientID, email, first, last, Company_name" . " FROM $TableName";
    $queryResult = mysqli_query($DBConnect, $SQLstring);
    // how many rows are in the query result and if there are no rows returned then we will increment our error and indicate an error that the password and/or username combination is not correct
    
    // this tells it to get a row from the query result (clientID row and first/last name row)
    if(!$queryResult) {
        ++$errors;
    //   $row = mysqli_fetch_assoc($queryResult);
    //   $_SESSION['clientID'] = $row['clientID'];
    //   $clientName = $row['first'] . " " . $row['last'];
    //   //Fetch rows from a result-set, then free the memory associated with the result
    //   mysqli_free_result($queryResult);
    //   echo "<p>Welcome back, $clientName!</p>\n";
    }
    if($errors == 0) {
        $it = mysqli_fetch_assoc($queryResult);
        if ($it["company"] = false) {
            $company = "N/A";
        }
        $first = $it['first'];
        $last = $it['last'];
        $email = $it['email'];
        $company = $it['company'];
        
        echo"<form action='EditInfo.php' method='post'>";
        echo"<p style='text-align: center;'>Enter your First Name: <br>";
        echo"<input type='text' name='Efirst' value='$first'\n>";
        echo"<p style='text-align: center;'>Enter your Last name: <br>";
        echo"<input type='text' name='Elast' value='$last'\n>";
        echo"<p style='text-align: center;'>Enter your Email: <br>";
        echo"<input type='text' name='Eemail' value='$email'\n>";
        echo"<p style='text-align: center;'>Enter your Company Name: <br>";
        echo"<input type='text' name='Ecompany' value='$company'\n>";
        echo"<p style='text-align: center;'><input  type='submit' name='register' value='Change information'></p>";
        echo"</form>";
        
        }
  }
  $first_new = $_POST['Efirst'];
  $last_new = $_POST['Elast'];
  $email_new = $_POST['Eemail'];
  $company_new = $_POST['Ecompany'];


  if (isset($_POST['Efirst'])) {
      //
      $SQLstring = "UPDATE 'Conferences' SET 'event_date' = '2019-03-26' WHERE 'Conferences'.'conferenceID' = 4;";
  $SQLstring = "INSERT INTO $TableName" .
                " (first, last, email, Company_name,)" .
                " VALUES('$first_new', '$last_new', '$email_new', '$company_new',)";
                $queryResult = mysqli_query($DBConnect, $SQLstring);
}
    //separate code
    echo "<p><a href='Done.php?" . "PHPSESSID=" . session_id() . "'>No changes, Next Page" . "</a></p>\n";
    echo "<p style='text-align: center;'><a href='home.php'>Log Out</a></p>\n";
    ?>
</body>
</html>