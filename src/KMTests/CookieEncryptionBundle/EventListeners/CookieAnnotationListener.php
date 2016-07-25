<?php

namespace KMTests\CookieEncryptionBundle\EventListeners;

use Doctrine\Common\Annotations\AnnotationReader;
use KMTests\CookieEncryptionBundle\Annotations\EncryptedCookie;
use KMTests\CookieEncryptionBundle\DependencyInjection\Configuration;
use KMTests\CookieEncryptionBundle\Factories\AnnotationReaderFactory;
use KMTests\CookieEncryptionBundle\EncryptedCookie\CookieEncryptionManager;
use KMTests\CookieEncryptionBundle\Factories\ReflectionMethodFactory;
use KMTests\CookieEncryptionBundle\Services\ConfigProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class CookieAnnotationListener
 * @package KMTests\CookieEncryptionBundle\EventListeners
 */
class CookieAnnotationListener
{
    /**
     * @var CookieEncryptionManager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $defaultArgName;

    /**
     * @var AnnotationReaderFactory
     */
    protected $readerFactory;

    /**
     * @var ReflectionMethodFactory
     */
    protected $reflectionMethodFactory;

    /**
     * @param CookieEncryptionManager $manager
     * @param AnnotationReaderFactory $readerFactory
     * @param ReflectionMethodFactory $reflectionMethodFactory
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        CookieEncryptionManager $manager,
        AnnotationReaderFactory $readerFactory,
        ReflectionMethodFactory $reflectionMethodFactory,
        ConfigProvider $configProvider
    ) {
        $this->manager = $manager;
        $this->readerFactory = $readerFactory;
        $this->reflectionMethodFactory = $reflectionMethodFactory;
        $this->defaultArgName = $configProvider->get(Configuration::COOKIE_ARG_NAME_KEY);
    }

    /**
     * @param FilterControllerEvent $controllerEvent
     */
    public function onKernelController(FilterControllerEvent $controllerEvent) {
        $request = $controllerEvent->getRequest();
        $annotationReader = $this->readerFactory->create();
        $controller = $this->resolveController($request);
        if($controller) {
            $reflectionMethod = $this->reflectionMethodFactory->create($controller['class'], $controller['fName']);
            if($reflectionMethod) {
                $reflections = $annotationReader->getMethodAnnotations($reflectionMethod);
                foreach ($reflections as $reflection) {
                    if ($reflection instanceof EncryptedCookie) {
                        $repository = $this->manager->getRepository(
                            $reflection->name,
                            $reflection->provider,
                            $reflection->expireIn
                        );
                        $request->attributes->set($this->resolveArgName($reflection->argName), $repository);
                    }
                }
            }
        }
    }

    /**
     * @param Request $request
     * @return array|null
     */
    protected function resolveController(Request $request) {
        $controller = $request->attributes->get('_controller');
        $controller = explode('::', $controller);
        if (!count($controller) === 2) {
            return null;
        } else {
            return [
                'class' => array_shift($controller),
                'fName' => array_shift($controller)
            ];
        }
    }

    /**
     * @param string $name
     * @return string
     */
    protected function resolveArgName($name) {
        return $name ? $name : $this->defaultArgName;
    }
}