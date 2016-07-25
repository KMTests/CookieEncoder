<?php

namespace KMTests\CookieEncryptionBundle\Factories;

/**
 * Class DateIntervalFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class DateIntervalFactory
{
    /**
     * @param string $interval
     * @return \DateInterval
     */
    public function create($interval) {
        return new \DateInterval($interval);
    }
}