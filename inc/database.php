<?php
$user = "root";
$password = "root";
$host = "localhost";
$base = "ktr-msc-ls1";

$pdo = new PDO("mysql:host=$host;dbname=$base", $user, $password, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));