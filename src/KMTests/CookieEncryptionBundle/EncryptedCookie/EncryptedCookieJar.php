<?php

namespace KMTests\CookieEncryptionBundle\EncryptedCookie;

use KMTests\CookieEncryptionBundle\EncryptedCookie\EncryptedCookieModel;

/**
 * Class EncryptedCookieJar
 * @package KMTests\CookieEncryptionBundle\Services
 */
class EncryptedCookieJar
{
    /**
     * @var EncryptedCookieModel[]
     */
    protected $jar = [];

    /**
     * @param EncryptedCookieModel[] $jar
     * @return $this
     */
    public function replace(array $jar) {
        $this->jar = $jar;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function add($name, EncryptedCookieModel $value) {
        $this->jar[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return EncryptedCookieModel|null
     */
    public function get($name, $default = null) {
        return $this->has($name) ? $this->jar[$name] : $default;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function remove($name) {
        if ($this->has($name)) {
            unset($this->jar[$name]);
        }
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name) {
        return array_key_exists($name, $this->jar);
    }

    /**
     * @return EncryptedCookieModel[]
     */
    public function all() {
        return $this->jar;
    }
}