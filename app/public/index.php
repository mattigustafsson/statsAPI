<?php
include ('./Controller/ApiController.php');

use App\Controller\ApiController;

$api = new ApiController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($path === '/averageOrderValue') {
        echo $api->averageOrderValue();
    } elseif ($path === '/topThreeProducts') {
        echo $api->topThreeProducts();
    } else {
        // Handle invalid routes or display a 404 error
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}
