<!DOCTYPE html>
<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<html lang="en" style="background-color: grey;">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <h1 style='text-align: center;'>Client Conferences</h1>
    <h2 style='text-align: center;'>Register / Login</h2>
    <p style='text-align: center;'>new Clients, please complete the top form to register as a user. Returning users, please complete the second form to login.</p>
    <h3 style='text-align: center;'>New Client Registration</h3>
    <form action="CompanyInfo.php?PHPSESSID=<?php echo session_id(); ?>" method="post">
        <p style='text-align: center;'>Enter your name: First
            <input type="text" name="first">
            Last:
            <input type="text" name="last">
        </p>
        <p style='text-align: center;'>
            Enter your email address:
            <input type="text" name="email">
        </p>
        <p style='text-align: center;'>
            Enter a Company Name for your account:
                <input type="text" name="company">
        </p>
        <p style='text-align: center;'>
            Enter a password for your account:
                <input type="password" name="password">
        </p>
        <p style='text-align: center;'>
            Confirm your password
                <input type="password" name="password2">
        </p>
        <p style='text-align: center;'><em>(Passwords are case-sensitive and must be at least 6 charaters long.)</em></p>
        <p style='text-align: center;'><input  style='text-align: center;' type="reset" name="reset" value="Reset Registration Form"></p>
        <p style='text-align: center;'><input  type="submit" name="register" value="Register"></p>
    </form>


    <h3 style='text-align: center;'>Returning client Login</h3>
    <form action="verifyInfo.php?PHPSESSID=<?php echo session_id() ?>" method="post">
        <p style='text-align: center;'>
            Enter your email address:
            <input type="text" name="email">
        </p>
        <p style='text-align: center;'>
            Enter your password for your account:
                <input type="password" name="password">
        </p>
        <p style='text-align: center;'><em>(Passwords are case-sensitive and must be at least 6 charaters long.)</em></p>
        <p style='text-align: center;'><input type="reset" name="reset" value="Reset Login"></p>
        <p style='text-align: center;'><input type="submit" name="register" value="Login"></p>
    </form>
//internLogin
    </body>
</html>