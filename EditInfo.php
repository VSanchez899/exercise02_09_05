<?php
session_start();
echo "Session id: " . session_id() . "<br>\n";

?>

<!DOCTYPE html>
<html lang="en" style="background-color: turquoise;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 style="text-align: center;">Want to Edit Anything?</h1>
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
    $SQLstrg = "SELECT clientID, email, first, last, Company_name" . " FROM $TableName";
    $qResult = mysqli_query($DBConnect, $SQLstrg);

    if(!$qResult) {
        ++$errors;
    }

    if($errors == 0) {
        $it = mysqli_fetch_assoc($qResult);
        if ($it["company"] = false) {
            $company = "N/A";
        }
        $first = $_SESSION['first'];
        $last = $_SESSION['last'];
        $email = $_SESSION['email'];
        $company = $_SESSION['company'];
        $client = $_SESSION['clientID'];

        

        //displays Information already in data base
        echo"<p style='text-align: center; text-decoration: underline;'>Client Name:</p>";
        echo"<p style='text-align: center;'>$client</p>";
        echo"<p style='text-align: center; text-decoration: underline;'>First Name:</p>";
        echo"<p style='text-align: center;'>$first</p>";
        echo"<p style='text-align: center; text-decoration: underline;'>Last Name:</p>";
        echo"<p style='text-align: center;'>$last</p>";
        echo"<p style='text-align: center; text-decoration: underline;'>Email:</p>";
        echo"<p style='text-align: center;'>$email</p>";
        echo"<p style='text-align: center; text-decoration: underline;'>Company Name(if Given)</p>";
        echo"<p style='text-align: center;'>$company</p>";
        //Form that writes over previous data in data base if submitted

        echo"<h2 style='text-align: center;'>Enter changes needed in the forum</h2>";

        //form to change stuff
        echo"<form action='submitComplete.php' method='post'>";
        echo"<p style='text-align: center; text-decoration: underline;'>Enter your First Name: <br>";
        echo"<input type='text' name='Efirst' value='' required\n>";
        echo"<p style='text-align: center; text-decoration: underline;'>Enter your Last name: <br>";
        echo"<input type='text' name='Elast' value='' required\n>";
        echo"<p style='text-align: center; text-decoration: underline;'>Enter your Email: <br>";
        echo"<input type='text' name='Eemail' value='' required\n>";
        echo"<p style='text-align: center; text-decoration: underline;'>Enter your Company Name: <br>";
        echo"<input type='text' name='Ecompany' value='' required\n>";
        echo"<p style='text-align: center;'><input  type='submit' name='register' value='Change information'></p>";
        echo"</form>";
        }
  }
  
  
  if ($DBConnect) {
    echo "<p>Closing database \"$DBName\" connection.</p>\n";
    mysqli_close($DBConnect); 
  }


    //Hyper links at the end of the file
    echo "<h3 style='text-align: center;'>No Changes</h3>";
    echo "<p style='text-align: center;'><a href='Done.php?" . "PHPSESSID=" . session_id() . "'>Next Page" . "</a></p>\n";
    echo "<p style='text-align: center;'><a href='home.php'>Log Out</a></p>\n";
    ?>
</body>
</html>