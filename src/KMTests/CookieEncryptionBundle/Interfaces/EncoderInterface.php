<?php

namespace KMTests\CookieEncryptionBundle\Interfaces;

/**
 * Interface EncoderInterface
 * @package KMTests\CookieEncryptionBundle\Interfaces
 */
interface EncoderInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function encode(array $data);

    /**
     * @param string $encodedData
     * @return array
     */
    public function decode($encodedData);
}