<?php
//подключение к бд
$servername = "localhost";
$username = "root";
$password = "";
$db = "project_db";
//подключение, где $conn - текущее подключение 
$conn = new mysqli($servername,$username,$password,$db);
?>
