<?php
// ------------------------------------------------------------------------------------------------
// Holds all functionality that relates.
//
// Next code is going to follow PSR coding style rules.
// http://www.php-fig.org/psr/psr-2/
# Version: 1.0.0
# Author: Juan Ramon Gonzalez Morales

namespace Test;

use DateTime;
use DateTimeZone;
use Exception;

class DatesService
{

    const INVALID_STRING_DATETIME = "INVALID_STRING_DATETIME";
    const DATETIME_FORMAT = "Y-m-d H:i:s";
    const DATETIME_SHORT_FORMAT = "Y-m-d";

    public function validateStringDate(string $date, string $format)
    {
        if (DateTime::createFromFormat($format, $date) !== FALSE) {
            return true;
        }
        throw new \Exception(self::INVALID_STRING_DATETIME);
    }

    public function getTimestampFromString(string $date, string $format = null)
    {

        if(empty($format)) $format = self::DATETIME_FORMAT;

        $this->validateStringDate($date, $format);


        // Better to have a validated method and create later. To be consistent with method names.
        $datetime = DateTime::createFromFormat($format, $date);
        $datetime->setTimezone(new DateTimeZone("UTC"));
        return $datetime->getTimestamp();

    }

    public function getFirstDateOfTheMonth()
    {
        return date('Y-m-01');
    }

    public function getLastDateOfTheMonth()
    {
        return date('Y-m-t');
    }

    public function getFirstDateOfTheYear()
    {
        return date('Y-m-d', strtotime('01/01'));
    }

    public function getLastDateOfTheYear()
    {
        return date('Y-m-d', strtotime('12/31'));
    }

}

