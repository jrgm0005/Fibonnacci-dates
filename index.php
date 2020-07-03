<?php

require("vendor/autoload.php");

use Test\App as App;
use Test\Fibonacci as Fibonacci;
use Test\DatesService as DatesService;

use DateTime;
use Exception;

try {

    $fibonacci = new Fibonacci();
    $datesService = new DatesService();
    $app = new App($fibonacci, $datesService);
    $app->run($argv);

} catch (Exception $e) {
    var_dump($e->getMessage());
}