<?php

namespace KMTests\CookieEncryptionBundle\EventListeners;

use KMTests\CookieEncryptionBundle\DependencyInjection\Configuration;
use KMTests\CookieEncryptionBundle\EncryptedCookie\EncryptedCookieJar;
use KMTests\CookieEncryptionBundle\Factories\SymfonyCookieFactory;
use KMTests\CookieEncryptionBundle\Services\ConfigProvider;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class CookieStorageListener
 * @package KMTests\CookieEncryptionBundle\EventListeners
 */
class CookieStorageListener
{
    /**
     * @var EncryptedCookieJar
     */
    protected $cookieJar;

    /**
     * @var SymfonyCookieFactory
     */
    protected $cookieFactory;

    /**
     * @var bool
     */
    protected $autoStore = true;

    /**
     * @param EncryptedCookieJar $cookieJar
     * @param SymfonyCookieFactory $cookieFactory
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        EncryptedCookieJar $cookieJar,
        SymfonyCookieFactory $cookieFactory,
        ConfigProvider $configProvider
    ) {
        $this->cookieFactory = $cookieFactory;
        $this->cookieJar = $cookieJar;
        $this->autoStore = $configProvider->get(Configuration::AUTO_STORE_KEY);
        $this->domain = $configProvider->get(Configuration::COOKIE_DOMAIN_KEY);
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $this->autoStore ? $this->storeCookiesFromJar($event) : null;
    }

    /**
     * @param FilterResponseEvent $event
     */
    protected function storeCookiesFromJar(FilterResponseEvent $event) {
        foreach($this->cookieJar->all() as $name => $encryptedCookie) {
            $cookie = $this->cookieFactory->create(
                $name,
                $encryptedCookie->getEncoded(),
                $encryptedCookie->getExpireAt(),
                $this->domain
            );
            $event->getResponse()->headers->setCookie($cookie);
        }
    }
}