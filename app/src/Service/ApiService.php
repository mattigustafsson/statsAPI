<?php
namespace App\Service\ApiService;

use ErrorException;
use Exception;

$apiKey = getenv('QUICKBUTIK_API_KEY');

function getFromQvickApi($apiUrl) {
  global $apiKey;
  if (!$apiKey) {
    die('QUICKBUTIK_API_KEY saknas.');
  }

  $response = '';
  try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:$apiKey");
    $response = curl_exec($ch);
    curl_close($ch);
  } catch (Exception $e) {
    throw new ErrorException('Fel vid hämtning av data från Quickbutik API.');
    die();
  }

  return json_decode($response);
};
