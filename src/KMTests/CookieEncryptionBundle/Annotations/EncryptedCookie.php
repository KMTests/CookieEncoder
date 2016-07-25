<?php

namespace KMTests\CookieEncryptionBundle\Annotations;

/**
 * Class EncryptedCookie
 * @package KMTests\CookieEncryptionBundle\Annotations
 * @Annotation
 * @Target("METHOD")
 */
class EncryptedCookie
{
    /**
     * @var null|string
     */
    public $name = null;

    /**
     * @var null|string
     */
    public $argName = null;

    /**
     * @var null|string
     */
    public $provider = null;

    /**
     * @var null|string
     */
    public $expireIn = null;
}