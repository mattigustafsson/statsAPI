<?php
declare(strict_types=1);

require '/var/www/html/Service/stats.php';

use PHPUnit\Framework\TestCase;
use function App\Service\stats\getAverageOrderValue;

class MyTest extends TestCase {
  public function testMyTest(): void {
    $average = getAverageOrderValue();
    self::assertIsNumeric($average);
  }
}
