Symfony bundle for creating and storing encoded cookies

================================================================

Instalation:
	
	1. Add to composer.json
	
	```
	{
		"repositories": [
			{
			  "type": "vcs",
			  "url": "https://github.com/KMTests/CookieEncoder.git"
			},
		],
		"require": [
			"KMTests/CookieEncoder": "dev-master",
		] 
	}
	```
	
	2. Register bundle to AppKernel
	
	```
		public function registerBundles()
		{
			$bundles = [
				...
				new KMTests\CookieEncryptionBundle\KMTestsCookieEncryptionBundle(),
			];
		}
	```
	
	3. Create cookie data provider
	
	```
		use KMTests\CookieEncryptionBundle\Interfaces\CookieDataProviderInterface;

		class Provider implements CookieDataProviderInterface
		{
			public function getData(array $arguments) {
				$data = [...];
				return $data;
			}
		}
	```
	
	4. Reqister data provider as service
	
	```
		services:
			your.service.name:
				class: YourBundle\Services\Provider
	```
	
	5. Add minimal config to config.yml
	
	```
		km_tests_cookie_encryption:
			cookie_data_provider_service: 'your.service.name' // data provider service name
	```
	
Usage in controller:
	
	```
		use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
		use KMTests\CookieEncryptionBundle\Annotations\EncryptedCookie;
		use KMTests\CookieEncryptionBundle\EncryptedCookie\CookieRepository;
		
		class DefaultController extends Controller
		{
			/**
			 * @Route("/", name="homepage")
			 * @EncryptedCookie()
			 */
			public function indexAction(CookieRepository $secretCookie)
			{
				// create new cookie to CookieJar
				$secretCookie->create();
				
				// get cookie data encoded
				$secretCookie->getEncodedData();
				
				// get cookie data decoded
				$secretCookie->getData();
				
				// delete cookie
				$secretCookie->delete();
				...
			}
		}
	```
	
	or just inject 'cookie_encryption_manager.service' and use getRepository() to get CookieRepository.
	
Todos:
	Write tests__
	Write documentation for configuration__
	Write documentation for advanced use__
	Write service documentations__
	Example on how to use it with AuthGuard__
	Example on how to write DataProviders__
	