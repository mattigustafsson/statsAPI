<?php
namespace App\Service\stats;

require '/var/www/html/Service/ApiService.php';

use function App\Service\ApiService\getFromQvickApi;

$apiBaseUrl = getenv('QUICKBUTIK_BASE_ULR');
$apiOrderUrl = $apiBaseUrl . getenv('QUICKBUTIK_ORDERS_SLUG');
$apiProductUrl = $apiBaseUrl . getenv('QUICKBUTIK_PRODUCTS_SLUG');

function getAverageOrderValue() {
  global $apiOrderUrl;
  $orders = getFromQvickApi($apiOrderUrl);

  $average = calAverageValueOnOrders($orders);
  return json_encode(['averageOrderValue' => $average]);
};

function getTopThreeProducts() {
  global $apiOrderUrl;
  
  $orders = getFromQvickApi($apiOrderUrl);

  $top3 = getTop3($orders);
  
  return json_encode(['topThreeProducts' => $top3]);
}


function calAverageValueOnOrders($orders) {
  $order_amount = 0;
  $number_of_orders = 0;

  foreach ($orders as $order) {
    $order_amount = $order_amount + $order->total_amount;
    $number_of_orders = $number_of_orders + 1;
  };

  return round($order_amount/$number_of_orders, 2);
}

function getTop3($orders) {
  global $apiOrderUrl;
  global $apiProductUrl;
  $productCounts = [];

  foreach ($orders as $order) {
      $orderId = $order->order_id;
    
      $orderDetails = getFromQvickApi($apiOrderUrl . '?order_id=' . $orderId);

      foreach ($orderDetails[0]->products as $product) {
          $productId = $product->product_id;
          if (isset($productCounts[$productId])) {
              $productCounts[$productId]++;
          } else {
              $productCounts[$productId] = 1;
          }
      }
  }
  
  arsort($productCounts); // Sort the products by count in descending order
  $popularProducts = array_slice($productCounts, 0, 3, true);
  
  foreach ($popularProducts as $product => $product_value) {
    $productDetails = getFromQvickApi($apiProductUrl . '?product_id=' . $product);
    $popularProducts[$productDetails->title] = $product_value;
    unset($popularProducts[$product]);
  };

  return $popularProducts;
}
