<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "video_uploader";


// create connection
$con = mysqli_connect($host, $user, $password, $dbname);

// check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
