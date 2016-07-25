Symfony bundle for creating and storing encoded cookies

================================================================

Instalation:
	Todo
	
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
	Write tests
	Write documentation for configuration
	Write documentation for advanced use
	Write service documentations
	Example on how to use it with AuthGuard
	Example on how to write DataProviders
	