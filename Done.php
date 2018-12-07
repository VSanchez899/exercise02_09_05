<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Information</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <h1>Information</h1>
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
      
      echo"$first";
      echo"$last";
      echo"$email";
      echo"$company";
      }
}



    ?>
    </body>
</html>