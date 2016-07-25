<?php

namespace KMTests\CookieEncryptionBundle\EncryptedCookie;

use KMTests\CookieEncryptionBundle\Interfaces\CookieDataProviderInterface;
use KMTests\CookieEncryptionBundle\Interfaces\EncoderInterface;

/**
 * Class CookieRepository
 * @package KMTests\CookieEncryptionBundle\Services
 */
class CookieRepository
{
    /**
     * @var CookieDataProviderInterface
     */
    protected $dataProvider;

    /**
     * @var EncryptedCookieJar
     */
    protected $cookieJar;

    /**
     * @var EncoderInterface
     */
    protected $encoder;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param EncoderInterface $encoder
     * @param CookieDataProviderInterface $dataProvider
     * @param EncryptedCookieJar $cookieJar
     * @param string $name
     */
    public function __construct(
        EncoderInterface $encoder,
        CookieDataProviderInterface $dataProvider,
        EncryptedCookieJar $cookieJar,
        $name
    ) {
        $this->encoder = $encoder;
        $this->dataProvider = $dataProvider;
        $this->cookieJar = $cookieJar;
        $this->name = $name;
    }

    /**
     * @param ...$params
     * @return EncryptedCookieModel
     */
    public function create(...$params) {
        $data = $this->dataProvider->getData($params);
        return $this->getCookie()->setEncoded($this->encoder->encode($data))->setDecoded($data)->setUnlocked(true);
    }

    /**
     * @return EncryptedCookieModel
     */
    public function getCookie() {
        return $this->cookieJar->get($this->name);
    }

    /**
     * @return string
     */
    public function getEncodedData() {
        return $this->getCookie()->getEncoded();
    }

    /**
     * @return array
     */
    public function getData() {
        $cookie = $this->getCookie();
        $cookie->isUnlocked() ?: $this->unlockCookie();
        return $cookie->getDecoded();
    }

    /**
     * @return $this
     */
    protected function unlockCookie() {
        $cookie = $this->getCookie();
        $cookie->setDecoded($this->encoder->decode($cookie->getEncoded()))->setUnlocked(true);
        return $this;
    }

    /**
     * @return $this
     */
    public function delete() {
        $this->cookieJar->get($this->name)->setExpireAt(new \DateTime());
        return $this;
    }

    /**
     * @return bool
     */
    public function created() {
        return $this->cookieJar->has($this->name);
    }
}