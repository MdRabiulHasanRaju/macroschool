<?php

$clientID = '1086024641552-094kab0a69dmi6mal4iaf7vtdb00fega.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://macroschool.academy/dashboard';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
?>