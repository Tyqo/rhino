<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use Authorization\Policy\MapResolver;
use Authentication\Identifier\AbstractIdentifier;
use Cake\Http\ServerRequest;
use App\Policy\RequestPolicy;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface {
	/**
	 * Load all the application configuration and bootstrap logic.
	 *
	 * @return void
	 */
	public function bootstrap(): void {
		// Call parent to load bootstrap from files.
		parent::bootstrap();

		if (PHP_SAPI === 'cli') {
			$this->bootstrapCli();
		} else {
			FactoryLocator::add(
				'Table',
				(new TableLocator())->allowFallbackClass(false)
			);
		}

		/*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
		if (Configure::read('debug')) {
			$this->addPlugin('DebugKit');
		}

		// Load more plugins here
		$this->addPlugin('Rhino');
		$this->addPlugin('Authentication');
		$this->addPlugin('Authorization');
		$this->addPlugin('Migrations');
		// $this->addPlugin('CsvView');
	}

	/**
	 * Setup the middleware queue your application will use.
	 *
	 * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
	 * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
	 */
	public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
		$middlewareQueue
			// Catch any exceptions in the lower layers,
			// and make an error page/response
			->add(new ErrorHandlerMiddleware(Configure::read('Error')))

			// Handle plugin/theme assets like CakePHP normally does.
			->add(new AssetMiddleware([
				'cacheTime' => Configure::read('Asset.cacheTime'),
			]))

			// Add routing middleware.
			// If you have a large number of routes connected, turning on routes
			// caching in production could improve performance. For that when
			// creating the middleware instance specify the cache config name by
			// using it's second constructor argument:
			// `new RoutingMiddleware($this, '_cake_routes_')`
			->add(new RoutingMiddleware($this))

			// Parse various types of encoded request bodies so that they are
			// available as array through $request->getData()
			// https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
			->add(new BodyParserMiddleware())

			// Cross Site Request Forgery (CSRF) Protection Middleware
			// https://book.cakephp.org/4/en/security/csrf.html#cross-site-request-forgery-csrf-middleware
			->add(new CsrfProtectionMiddleware([
				'httponly' => true,
			]))

			->add(new AuthenticationMiddleware($this))
			->add(new AuthorizationMiddleware($this));

		// $routes->registerMiddleware('authtorize', new AuthorizationMiddleware(Application));

		return $middlewareQueue;
	}

	/**
	 * Register application container services.
	 *
	 * @param \Cake\Core\ContainerInterface $container The Container to update.
	 * @return void
	 * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
	 */
	public function services(ContainerInterface $container): void {
	}

	/**
	 * Bootstrapping for CLI application.
	 *
	 * That is when running commands.
	 *
	 * @return void
	 */
	protected function bootstrapCli(): void {
		$this->addOptionalPlugin('Cake/Repl');
		$this->addOptionalPlugin('Bake');

		$this->addPlugin('Migrations');

		// Load more plugins here
	}

	public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface {
		$path = $request->getPath();

		if (preg_match("*rhino*", $path)) {
			// Reuse fields in multiple authenticators.
			$fields = [
				AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
				AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
			];

			$login = Router::url(['plugin' => 'Rhino', 'controller' => 'Users', 'action' => 'login']);

			$authenticationService = new AuthenticationService([
				'unauthenticatedRedirect' => Router::url(['plugin' => 'Rhino', 'controller' => 'Users', 'action' => 'login']),
				'queryParam' => 'redirect',
			]);

			// Load identifiers, ensure we check email and password fields
			$authenticationService->loadIdentifier('Authentication.Password', [
				'fields' => $fields,
				'resolver' => [
					'className' => 'Authentication.Orm',
					'userModel' => 'Rhino.Users',
					'finder' => 'all', // alterenatively: 'active'
				]
			]);

			// Configure form data check to pick email and password
			$authenticationService->loadAuthenticator('Authentication.Form', [
				'fields' => $fields,
				'loginUrl' => $login
			]);

			// Load the authenticators, you want session first
			$authenticationService->loadAuthenticator('Authentication.Session');

			// If the user is on the login page, check for a cookie as well.
			$authenticationService->loadAuthenticator('Authentication.Cookie', [
				'fields' => $fields,
				'loginUrl' => $login
			]);

			return $authenticationService;
		}

		$authenticationService = new AuthenticationService();
		// Load identifiers, ensure we check email and password fields
		$authenticationService->loadIdentifier('Authentication.Password');
		// Load the authenticators, you want session first
		$authenticationService->loadAuthenticator('Authentication.Session');

		return $authenticationService;
	}

	public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface {
		$path = $request->getPath();

		if (preg_match("*rhino*", $path)) {
			$resolver = new OrmResolver();
			return new AuthorizationService($resolver);
		}

		$mapResolver = new MapResolver();
		// $mapResolver->map(ServerRequest::class, RequestPolicy::class);
		return new AuthorizationService($mapResolver);
	}
}
