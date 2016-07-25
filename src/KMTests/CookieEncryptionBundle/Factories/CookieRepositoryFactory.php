<?php

namespace KMTests\CookieEncryptionBundle\Factories;

use KMTests\CookieEncryptionBundle\EncryptedCookie\CookieRepository;
use KMTests\CookieEncryptionBundle\EncryptedCookie\EncryptedCookieJar;
use KMTests\CookieEncryptionBundle\Interfaces\CookieDataProviderInterface;
use KMTests\CookieEncryptionBundle\Interfaces\EncoderInterface;

/**
 * Class CookieRepositoryFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class CookieRepositoryFactory
{
    /**
     * @var EncryptedCookieJar
     */
    protected $cookieJar;

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @param EncryptedCookieJar $cookieJar
     * @param EncoderInterface $encoder
     */
    public function __construct(EncryptedCookieJar $cookieJar, EncoderInterface $encoder) {
        $this->cookieJar = $cookieJar;
        $this->encoder = $encoder;
    }

    /**
     * @param CookieDataProviderInterface $provider
     * @param  string $name
     * @return CookieRepository
     */
    public function create(CookieDataProviderInterface $provider, $name) {
        return new CookieRepository($this->encoder, $provider, $this->cookieJar, $name);
    }

}