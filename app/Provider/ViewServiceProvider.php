<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Provider;

use Intraxia\Jaxion\Contract\Core\Container;
use Intraxia\Jaxion\Contract\Core\ServiceProvider;
use Intraxia\Readlinks\Handlebars\Engine;
use Intraxia\Readlinks\Handlebars\Helper\I18n;
use Intraxia\Readlinks\Handlebars\Helper\Navigation;
use Intraxia\Readlinks\Handlebars\Helper\WP;

/**
 * Class ViewServiceProvider
 *
 * @package    Intraxia\Readlinks
 * @subpackage Provider
 */
class ViewServiceProvider implements ServiceProvider {
	/**
	 * Register the Handlebars service with
	 *
	 * @param Container $container
	 */
	public function register( Container $container ) : void {
		$container->share( [ 'view' => Engine::class ], function ( Container $container ) {
			$engine = new Engine( $container->fetch( 'path' ) . 'client/' );

			$engine->register_helper( new WP );
			$engine->register_helper( new I18n );
			$engine->register_helper( new Navigation );

			return $engine;
		} );
	}
}
