<?php
$access_token = '8I4k0Q1En3A2pfDvdmutUj0BhVqXGqjxi/EohdcFSDLcVgEYiYDvzOkAfcYPL2uEfqv0unrjH60Ka4WSXi7G//ciYEJ1WtLAF4xR02HziTya+cOGzvSk1qh2lFIiGk2PlZuFemi94zswT5WT0MPcWAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;