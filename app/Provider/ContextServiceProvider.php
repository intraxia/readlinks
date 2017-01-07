<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Provider;

use Intraxia\Jaxion\Contract\Core\Container;
use Intraxia\Jaxion\Contract\Core\ServiceProvider;
use Intraxia\Readlinks\Context\Home;
use Intraxia\Readlinks\Context\Link;
use Intraxia\Readlinks\Context\Pager;

/**
 * Class ContextServiceProvider
 *
 * @package    Intraxia\Readlinks
 * @subpackage Provider
 */
class ContextServiceProvider implements ServiceProvider {
	/**
	 * Register the provider's services on the container.
	 *
	 * This method is passed the container to register on, giving the service provider
	 * an opportunity to register its services on the container in an encapsulated way.
	 *
	 * @param Container $container
	 */
	public function register( Container $container ) {
		$container->define( 'context.home', function( Container $container ) {
			return new Home;
		} );

		$container->define( 'context.pager', function( Container $container ) {
			return new Pager;
		} );

		$container->define( 'context.link', function( Container $container ) {
			return new Link;
		} );
	}
}
