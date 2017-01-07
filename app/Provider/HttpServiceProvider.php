<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Provider;

use Intraxia\Jaxion\Contract\Core\Container;
use Intraxia\Jaxion\Contract\Core\ServiceProvider;
use Intraxia\Readlinks\Http\Response;
use Intraxia\Readlinks\Http\Router;

/**
 * Class HttpServiceProvider
 *
 * @package    Intraxia\Readlinks
 * @subpackage Provider
 */
class HttpServiceProvider implements ServiceProvider {
	/**
	 * Register the provider's services on the container.
	 *
	 * This method is passed the container to register on, giving the service provider
	 * an opportunity to register its services on the container in an encapsulated way.
	 *
	 * @param Container $container
	 */
	public function register( Container $container ) {
		$container->define( [ 'http.router' => Router::class ], function() {
			return new Router;
		} );

		$container->define( [ 'http.response' => Response::class ], function( Container $container ) : Response {
			return new Response( $container->fetch( 'assets' ), $container->fetch( 'view' ) );
		} );
	}
}
