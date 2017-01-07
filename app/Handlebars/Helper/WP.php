<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Handlebars\Helper;

use LightnCandy\SafeString;

/**
 * Class WP
 *
 * @package    Intraxia\Readlinks
 * @subpackage Handlebars\Helper
 */
class WP implements HelperInterface {
	/**
	 * Returns the helper's name.
	 *
	 * @return string
	 */
	public function get_name() : string {
		return 'wp';
	}

	/**
	 * Call the helper.
	 *
	 * @return SafeString
	 */
	public function __invoke() {
		$args = array_map( function ( $arg ) {
			if ( $arg instanceof SafeString ) {
				return $arg->__toString();
			}

			return $arg;
		}, func_get_args() );
		array_pop( $args );
		$func = array_shift( $args );

		ob_start();
		$ret    = call_user_func_array( $func, $args );
		$output = ob_get_contents();
		ob_end_clean();

		if ( $ret ) {
			return new SafeString( $ret );
		}

		return new SafeString( $output );
	}
}
