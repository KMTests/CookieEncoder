<?php

namespace KMTests\CookieEncryptionBundle\Factories;

use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class SymfonyCookieFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class SymfonyCookieFactory
{
    /**
     * @param $name
     * @param $content
     * @param \DateTimeInterface $expire
     * @return Cookie
     */
    public function create($name, $content, \DateTimeInterface $expire, $domain) {
        return new Cookie($name, $content, $expire, '/', $domain);
    }
}