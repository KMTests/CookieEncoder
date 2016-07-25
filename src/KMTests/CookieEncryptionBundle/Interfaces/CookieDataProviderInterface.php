<?php

namespace KMTests\CookieEncryptionBundle\Interfaces;

/**
 * Interface CookieBuilderInterface
 * @package KMTests\CookieEncryptionBundle\Interfaces
 */
interface CookieDataProviderInterface
{
    /**
     * @param array $arguments
     * @return array
     */
    public function getData(array $arguments);
}