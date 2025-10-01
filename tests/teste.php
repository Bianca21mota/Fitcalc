<?php

$password = '123456';

//Create a hash of the password using PASSWORD_DEFAULT
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo  $hashedPassword;

?>