<?php

namespace KMTests\CookieEncryptionBundle\Factories;

use KMTests\CookieEncryptionBundle\EncryptedCookie\EncryptedCookieModel;

/**
 * Class CookieModelFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class CookieModelFactory
{
    /**
     * @return EncryptedCookieModel
     */
    public function create() {
        return new EncryptedCookieModel();
    }
}