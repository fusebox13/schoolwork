<?php

session_start();
$_SESSION['oldnumbers'] = array();
session_write_close();
header("Location: luhnform.php");

