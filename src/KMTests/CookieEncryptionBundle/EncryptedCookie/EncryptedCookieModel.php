<?php

namespace KMTests\CookieEncryptionBundle\EncryptedCookie;

/**
 * Class EncryptedCookieModel
 * @package KMTests\CookieEncryptionBundle\EncryptedCookie
 */
class EncryptedCookieModel
{
    /**
     * @var array
     */
    protected $decoded = [];

    /**
     * @var string
     */
    protected $encoded = '';

    /**
     * @var bool
     */
    protected $unlocked = false;

    /**
     * @var int|\DateTime
     */
    protected $expireAt = 0;

    /**
     * @return array
     */
    public function getDecoded()
    {
        return $this->decoded;
    }

    /**
     * @param array $decoded
     * @return EncryptedCookieModel
     */
    public function setDecoded($decoded)
    {
        $this->decoded = $decoded;
        return $this;
    }

    /**
     * @return string
     */
    public function getEncoded()
    {
        return $this->encoded;
    }

    /**
     * @param string $encoded
     * @return EncryptedCookieModel
     */
    public function setEncoded($encoded)
    {
        $this->encoded = $encoded;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isUnlocked()
    {
        return $this->unlocked;
    }

    /**
     * @param boolean $unlocked
     * @return EncryptedCookieModel
     */
    public function setUnlocked($unlocked)
    {
        $this->unlocked = $unlocked;
        return $this;
    }

    /**
     * @return \DateTime|int
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * @param \DateTime|int $expireAt
     * @return EncryptedCookieModel
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;
        return $this;
    }
}