<?php

namespace KMTests\CookieEncryptionBundle\Factories;

/**
 * Class DateTimeFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class DateTimeFactory
{
    /**
     * @return \DateTime
     */
    public function create() {
        return new \DateTime();
    }
}