<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Handlebars\Helper;

use LightnCandy\SafeString;

/**
 * Class I18n
 *
 * @package    Intraxia\Readlinks
 * @subpackage Handlebars\Helper
 */
class I18n implements HelperInterface {
	/**
	 * Get the helper name.
	 *
	 * @return string
	 */
	public function get_name() : string {
		return 'i18n';
	}

	/**
	 * Call the helper.
	 *
	 * @param string $key
	 *
	 * @return SafeString
	 */
	public function __invoke( $key = '' ) {
		$i18n = array(
			'outdated.warning'  => __( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'readlinks' ),
			'navigation.toggle' => __( 'Toggle navigation', 'readlinks' ),
			'home.header'       => __( 'Recent Reads', 'readlinks' ),
		);

		if ( array_key_exists( $key, $i18n ) ) {
			return new SafeString( $i18n[ $key ] );
		}

		return new SafeString( '' );
	}
}
