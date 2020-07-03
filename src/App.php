<?php
// ------------------------------------------------------------------------------------------------
// Holds all functionality that relates.
//
// Next code is going to follow PSR coding style rules.
// http://www.php-fig.org/psr/psr-2/
# Version: 1.0.0
# Author: Juan Ramon Gonzalez Morales

namespace Test;

use Test\Fibonacci as Fibonacci;
use Test\DatesService as DatesService;

use DateTime;
use DateTimeZone;
use Exception;
use stdClass;

class App
{

    const INVALID_FUNCTION_ARGUMENT = "INVALID_FUNCTION_ARGUMENT";
    const INVALID_CUSTOM_ARGUMENTS = "INVALID_CUSTOM_ARGUMENTS";

    const VALID_FUNCTIONS = ['year', 'month', 'custom'];
    const FUNCTION_YEAR = 'year';
    const FUNCTION_MONTH = 'month';
    const FUNCTION_CUSTOM = 'custom';

    var $fibonacci;
    var $datesService;

    public function __construct(Fibonacci $fibonacci, DatesService $datesService )
    {
        $this->fibonacci = $fibonacci;
        $this->datesService = $datesService;
    }

// PUBLIC FUNCTIONS

    public function run($arguments)
    {

        $this->validateArguments($arguments);
        $this->processFunction($arguments);

    }

// INTERNAL FUNCTIONS

    protected function getFibForCustomArguments($arguments)
    {

        $this->validateCustomArguments($arguments);

        $start_date_received = $arguments[2];
        $end_date_received = $arguments[3];

        $timestamp_first = $this->datesService->getTimestampFromString($start_date_received, DatesService::DATETIME_FORMAT);
        $timestamp_last = $this->datesService->getTimestampFromString($end_date_received, DatesService::DATETIME_FORMAT);

        $this->printResults($start_date_received, $timestamp_first, $end_date_received, $timestamp_last);

    }

    protected function getFibNumbersForThisMonth()
    {

        $first_month_date = date('Y-m-01');
        $last_month_date = date('Y-m-t');

        $timestamp_first = $this->datesService->getTimestampFromString($first_month_date, DatesService::DATETIME_SHORT_FORMAT);
        $timestamp_last = $this->datesService->getTimestampFromString($last_month_date, DatesService::DATETIME_SHORT_FORMAT);

        $this->printResults($first_month_date, $timestamp_first, $last_month_date, $timestamp_last);

    }

    protected function getFibNumbersForThisYear()
    {

        $first_date_year = $this->datesService->getFirstDateOfTheYear();
        $last_date_year = $this->datesService->getLastDateOfTheYear();

        $timestamp_first = $this->datesService->getTimestampFromString($first_date_year, DatesService::DATETIME_SHORT_FORMAT);
        $timestamp_last = $this->datesService->getTimestampFromString($last_date_year, DatesService::DATETIME_SHORT_FORMAT);

        $this->printResults($first_date_year, $timestamp_first, $last_date_year, $timestamp_last);

    }

    protected function printResults($firstDate, $firstDateTimestamp, $secondDate, $secondDateTimestamp)
    {

        print_r("$firstDate ($firstDateTimestamp) -  $secondDate ($secondDateTimestamp)");
        $solution = $this->fibonacci->getFibsBetweenNumbers($firstDateTimestamp, $secondDateTimestamp);
        print_r(PHP_EOL);
        print_r("FIBONACCI NUMBERS BETWEEN SELECTED DATES");
        print_r(PHP_EOL);
        var_dump($solution);

    }

    protected function processFunction($arguments)
    {
        $function = $arguments[1];

        switch ($function) {

            case self::FUNCTION_YEAR:

                $this->getFibNumbersForThisYear();
                break;

            case self::FUNCTION_MONTH:

                $this->getFibNumbersForThisMonth();
                break;

            default:

                $this->getFibForCustomArguments($arguments);
                break;

        }

    }

    protected function validateArguments($arguments)
    {
        $response = new stdClass;
        if (!isset($arguments[1]))
            throw new Exception(self::INVALID_FUNCTION_ARGUMENT);

        $function = $arguments[1];

        if (!in_array($function, self::VALID_FUNCTIONS))
            throw new Exception(self::INVALID_FUNCTION_ARGUMENT);
    }

    protected function validateCustomArguments($arguments)
    {

        if (!isset($arguments[2]) || !isset($arguments[3])) {
            throw new Exception(self::INVALID_CUSTOM_ARGUMENTS);
        }

    }

}
