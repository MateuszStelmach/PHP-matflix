<?php
ob_start(); //output buffering
session_start();

date_default_timezone_set("Europe/Warsaw");

try {
  $con = new PDO("mysql:dbname=matflix; host=localhost","root","");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
  exit("Connection failed : " . $e->getMessage());
}

?>
