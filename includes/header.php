<?php
    
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/CategoryContainers.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMsg.php");
require_once("includes/classes/SeasonsProvider.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoProvider.php");





if(!isset($_SESSION["userSignedIn"])){

    header("Location:register.php");

  }

$usersignin = $_SESSION["userSignedIn"];

?>

<!DOCTYPE html>
<html>
  <head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src = "assets\js\script.js"></script>
    <title>Welcome to MatFlix</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    <script src="https://kit.fontawesome.com/6f309ba809.js" crossorigin="anonymous"></script>
  </head>
  <body>
      <div class= "wrapper">

<?php

if (!isset($hideNav)){
  include_once("includes/navBar.php");
}

?>