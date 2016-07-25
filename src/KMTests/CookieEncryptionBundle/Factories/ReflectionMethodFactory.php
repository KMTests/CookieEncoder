<?php

namespace KMTests\CookieEncryptionBundle\Factories;
use ReflectionException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ReflectionMethodFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class ReflectionMethodFactory
{
    /**
     * @param mixed $class
     * @param string $name
     * @return \ReflectionMethod
     */
    public function create($class, $name) {
        try {
            return new \ReflectionMethod($class, $name);
        } catch (ReflectionException $e) {
            return null;
        }
    }
}