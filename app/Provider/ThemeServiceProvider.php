<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Provider;

use Intraxia\Jaxion\Contract\Core\Container;
use Intraxia\Jaxion\Contract\Core\ServiceProvider;
use Intraxia\Readlinks\Theme;

/**
 * Class ThemeServiceProvider
 *
 * @package    Intraxia\Readlinks
 * @subpackage Provider
 */
class ThemeServiceProvider implements ServiceProvider {
	/**
	 * Register the provider's services on the container.
	 *
	 * This method is passed the container to register on, giving the service provider
	 * an opportunity to register its services on the container in an encapsulated way.
	 *
	 * @param Container $container
	 */
	public function register( Container $container ) {
		$container->define( [ 'theme' => Theme::class ], function ( Container $container ) {
			$theme = new Theme( $container );

			$theme->register_context( $container->fetch( 'context.home' ) );
			$theme->register_context( $container->fetch( 'context.pager' ) );
			$theme->register_context( $container->fetch( 'context.link' ) );

			return $theme;
		} );
	}
}
