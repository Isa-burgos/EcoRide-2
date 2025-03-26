<?php

$motDePasse = '123';
$hash = password_hash($motDePasse, PASSWORD_DEFAULT);

var_dump($hash);
