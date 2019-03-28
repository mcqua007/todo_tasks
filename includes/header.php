<!DOCTYPE html>
<?php include("config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");
include("includes/classes/User.php");


	$account = new Account($con);

include("includes/handlers/register_handler.php");
include("includes/handlers/login_handler.php");

?>


<html>
  <head>
		<link rel="shortcut icon" href="../assets/images/favicons/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="../assets/images/favicons/apple-touch-icon.png" />
		<link rel="apple-touch-icon" sizes="57x57" href="../assets/images/favicons/apple-touch-icon-57x57.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="../assets/images/favicons/apple-touch-icon-72x72.png" />
		<link rel="apple-touch-icon" sizes="76x76" href="../assets/images/favicons/apple-touch-icon-76x76.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="../assets/images/favicons/apple-touch-icon-114x114.png" />
		<link rel="apple-touch-icon" sizes="120x120" href="../assets/images/favicons/apple-touch-icon-120x120.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="../assets/images/favicons/apple-touch-icon-144x144.png" />
		<link rel="apple-touch-icon" sizes="152x152" href="../assets/images/favicons/apple-touch-icon-152x152.png" />
		<link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/apple-touch-icon-180x180.png" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Staqpack</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Leckerli+One|Lobster+Two|Pacifico" rel="stylesheet">
  </head>
