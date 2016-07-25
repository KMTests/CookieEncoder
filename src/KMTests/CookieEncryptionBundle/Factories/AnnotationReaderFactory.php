<?php

namespace KMTests\CookieEncryptionBundle\Factories;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class AnnotationReaderFactory
 * @package KMTests\CookieEncryptionBundle\Factories
 */
class AnnotationReaderFactory
{
    /**
     * @return AnnotationReader
     */
    public function create() {
        return new AnnotationReader();
    }
}