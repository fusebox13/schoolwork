<?php
session_start();
//  http://php.net/manual/en/function.session-destroy.php
session_destroy();
header('Location: index.php');
?>
