<?php

$server = "database.jaed.com"; // "service name"
$username = "user";
$password = "password";
$database = "my-app";

$connect = new mysqli($server, $username, $password, $database);

$query = 'SELECT * FROM test';
$result = mysqli_query($connect, $query);

echo '<h1>MYSQL CONTENT</h1>';

while ($res = mysqli_fetch_assoc($result)){
    echo '<h2>'.$res['id'].'</h2> <p>'.$res['name'].'</p><hr>';
}