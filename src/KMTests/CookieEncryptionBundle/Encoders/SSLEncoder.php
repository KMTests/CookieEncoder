<?php

namespace KMTests\CookieEncryptionBundle\Encoders;

use KMTests\CookieEncryptionBundle\DependencyInjection\Configuration;
use KMTests\CookieEncryptionBundle\Interfaces\EncoderInterface;
use KMTests\CookieEncryptionBundle\Services\ConfigProvider;

/**
 * Class SSLEncoder
 * @package KMTests\CookieEncryptionBundle\Services
 */
class SSLEncoder implements EncoderInterface
{
    const METHOD_NOT_FOUND = 'SSL cypher method named "%s" not found';

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $method;

    /**
     * @param ConfigProvider $configProvider
     * @throws \Exception
     */
    public function __construct(ConfigProvider $configProvider) {
        $this->secret = $configProvider->get(Configuration::SSl_ENCODER_SECRET_KEY);
        $this->method = $this->checkMethod($configProvider->get(Configuration::SSL_ENCODER_METHOD_KEY));
    }

    /**
     * @param array $data
     * @return string
     */
    public function encode(array $data) {
        return $data ? openssl_encrypt(json_encode($data), $this->method, $this->secret, 0, substr($this->secret, 0, 16)) : null;
    }

    /**
     * @param string $encodedData
     * @return mixed
     */
    public function decode($encodedData) {
        return json_decode(openssl_decrypt($encodedData, $this->method, $this->secret, false, substr($this->secret, 0, 16)), true);
    }

    /**
     * @param string $method
     * @return string
     * @throws \Exception
     */
    protected function checkMethod($method) {
        if (!in_array($method, openssl_get_cipher_methods(), true)) {
            throw new \Exception(sprintf(self::METHOD_NOT_FOUND, $method));
        }
        return $method;
    }
}