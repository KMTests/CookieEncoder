<?php

namespace KMTests\CookieEncryptionBundle\EncryptedCookie;

use KMTests\CookieEncryptionBundle\DependencyInjection\Configuration;
use KMTests\CookieEncryptionBundle\Factories\CookieModelFactory;
use KMTests\CookieEncryptionBundle\Factories\CookieRepositoryFactory;
use KMTests\CookieEncryptionBundle\Factories\DateIntervalFactory;
use KMTests\CookieEncryptionBundle\Factories\DateTimeFactory;
use KMTests\CookieEncryptionBundle\Interfaces\CookieDataProviderInterface;
use KMTests\CookieEncryptionBundle\Services\ConfigProvider;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class CookieEncryptionManager
 * @package KMTests\CookieEncryptionBundle\EncryptedCookie
 */
class CookieEncryptionManager
{
    /**
     * @var CookieRepositoryFactory
     */
    protected $repositoryFactory;

    /**
     * @var array
     */
    protected $repositories = [];

    /**
     * @var EncryptedCookieJar
     */
    protected $cookieJar;

    /**
     * @var array
     */
    protected $cookies = [];

    /**
     * @var ConfigProvider
     */
    protected $config = [];

    /**
     * @var CookieDataProviderInterface
     */
    protected $defaultDataProvider;

    /**
     * @var CookieModelFactory
     */
    protected $cookieModelFactory;

    /**
     * @var DateTimeFactory
     */
    protected $dateTimeFactory;

    /**
     * @var DateIntervalFactory
     */
    protected $dateIntervalFactory;

    /**
     * @param RequestStack $requestStack
     * @param EncryptedCookieJar $cookieJar
     * @param CookieRepositoryFactory $cookieRepositoryFactory
     * @param CookieDataProviderInterface $defaultDataProvider
     * @param CookieModelFactory $cookieModelFactory
     * @param DateTimeFactory $dateTimeFactory
     * @param DateIntervalFactory $dateIntervalFactory
     * @param ConfigProvider $config
     */
    public function __construct(
        RequestStack $requestStack,
        EncryptedCookieJar $cookieJar,
        CookieRepositoryFactory $cookieRepositoryFactory,
        CookieDataProviderInterface $defaultDataProvider,
        CookieModelFactory $cookieModelFactory,
        DateTimeFactory $dateTimeFactory,
        DateIntervalFactory $dateIntervalFactory,
        ConfigProvider $config
    ) {
        $this->cookies = $requestStack->getCurrentRequest()->cookies->all();
        $this->cookieJar = $cookieJar;
        $this->repositoryFactory = $cookieRepositoryFactory;
        $this->defaultDataProvider = $defaultDataProvider;
        $this->cookieModelFactory = $cookieModelFactory;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->dateIntervalFactory = $dateIntervalFactory;
        $this->config = $config;
    }

    /**
     * @param string|null $name
     * @param CookieDataProviderInterface|null $provider
     * @param string|null $expireInterval
     * @throws \Exception
     */
    public function createRepository(
        $name = null,
        CookieDataProviderInterface $provider = null,
        $expireInterval = null
    ) {
        $name = $this->resolveName($name);
        $requestCookie = $this->getCookie($name);
        $cookie = $this->createNewCookie($expireInterval);
        $requestCookie ? $cookie->setEncoded($requestCookie) : null;
        $this->cookieJar->add($name, $cookie);
        $this->repositories[$name] = $this->repositoryFactory->create($this->resolveDataProvider($provider), $name);
    }

    /**
     * @param string|null $name
     * @param CookieDataProviderInterface|null $dataProvider
     * @param string|null $expireInterval
     * @return mixed
     */
    public function getRepository(
        $name = null,
        CookieDataProviderInterface $dataProvider = null,
        $expireInterval = null
    ) {
        $name = $this->resolveName($name);
        if (!array_key_exists($name, $this->repositories)) {
            $this->createRepository($name, $dataProvider, $expireInterval);
        }
        return $this->repositories[$name];
    }

    /**
     * @param string|null $expireInterval
     * @return EncryptedCookieModel
     */
    protected function createNewCookie($expireInterval = null) {
        $expireInterval = $expireInterval ? $expireInterval : $this->config->get(Configuration::COOKIE_EXPIRE_KEY);
        $expire = $this->dateTimeFactory->create()->add($this->dateIntervalFactory->create($expireInterval));
        return $this->cookieModelFactory->create()->setExpireAt($expire);
    }

    /**
     * @param string $name
     * @return string mixed
     */
    protected function resolveName($name) {
        return $name ? $name : $this->config->get(Configuration::COOKIE_NAME_KEY);
    }

    /**
     * @param CookieDataProviderInterface $provider
     * @return CookieDataProviderInterface
     * @throws \Exception
     */
    protected function resolveDataProvider($provider) {
        $provider = $provider ?: $this->defaultDataProvider;
        if ($provider instanceof CookieDataProviderInterface) {
            return $provider;
        } else {
            throw new \Exception('Cookie data provider must implement CookieDataProviderInterface');
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getCookie($name) {
        return array_key_exists($name, $this->cookies) ? $this->cookies[$name] : null;
    }
}