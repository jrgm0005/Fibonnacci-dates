<?php
// ------------------------------------------------------------------------------------------------
// Holds all functionality that relates.
//
// Next code is going to follow PSR coding style rules.
// http://www.php-fig.org/psr/psr-2/
# Version: 1.0.0
# Author: Juan Ramon Gonzalez Morales

namespace Test;
// include_once("config.php");

class Fibonacci
{

    const ERROR_INVALID_TIMESTAMPS = "INVALID_TIMESTAMPS";

    public function getFibsBetweenNumbers(int $startTimestamp, int $endTimestamp)
    {

        if ($startTimestamp < 0 || $endTimestamp < 0) {
            throw new Exception(self::ERROR_INVALID_TIMESTAMPS);
        }

        $finish = false;
        $currentStep = 0;
        $solution = [];
        while (! $finish) {

            $temp = $this->getFib($currentStep);

            if ($temp >= $startTimestamp && $temp <= $endTimestamp) {
                $solution[] = $temp;
            }

            $currentStep++;

            if ($temp > $endTimestamp) {
                // Double check in case of some error to be sure its going to be out of loop.
                $finish = true;
                break;
            }

        }

        return $solution;

    }

    protected function getFibRecursive(int $number, $cache = null){

        if ($number == 0) return 0;
        if ($number == 1) return 1;

        $cache = empty($cache) ? [] : $cache;

        if (isset($cache[$number])) return $cache[$number];

        $cache[$number] = $this->getFibRecursive($number - 1, $cache) + $this->getFibRecursive($number - 2, $cache);

        return $cache[$number];
    }

    protected function getFib(int $number)
    {
        if ($number == 0) return 0;
        if ($number == 1) return 1;

        $number = round(pow((sqrt(5)+1)/2, $number) / sqrt(5));
        return $number;
    }


}

