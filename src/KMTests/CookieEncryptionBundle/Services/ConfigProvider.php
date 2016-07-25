<?php

namespace KMTests\CookieEncryptionBundle\Services;

/**
 * Class ConfigProvider
 * @package KMTests\CookieEncryptionBundle\Services
 */
class ConfigProvider
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config) {
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null) {
        return $this->has($name) ? $this->config[$name] : $default;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name) {
        return array_key_exists($name, $this->config);
    }
}