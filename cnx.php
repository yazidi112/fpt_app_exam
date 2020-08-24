<?php
// Start the session
session_start();
if(!isset($_SESSION['username'])){
	header("Location: index.php");
}   
$mysqli = new mysqli("localhost","root","","examenspn1920");