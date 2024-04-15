<?php 

$connect = mysqli_connect('localhost', 'aplikacja', 'Admin123','bazadanych');

if (mysqli_connect_errno()){
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}