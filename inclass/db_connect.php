<?php
//  This is my super duper cereal secret DB connection file
//  !Please show this to everyone
$data = parse_ini_file('/home/d/w/dwilli11/.fuse');
$host = 'mysql:dbname=dwilli11;host=localhost';
$user = $data['user'];
$pass = $data['password'];
$pdo = new PDO($host, $user, $pass);
$data = null;
$host = null;
$user = null;
$pass = null;