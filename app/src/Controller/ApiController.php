<?php
namespace App\Controller;

require '/var/www/html/Service/stats.php';

use function App\Service\stats\getAverageOrderValue;
use function App\Service\stats\getTopThreeProducts;

class ApiController {
    public function averageOrderValue() {
        return getAverageOrderValue();
    }

    public function topThreeProducts() {
        return getTopThreeProducts();
    }
}
