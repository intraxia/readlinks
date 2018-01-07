<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Handlebars;

use Intraxia\Readlinks\Handlebars\Helper\HelperInterface;
use LightnCandy\LightnCandy;

/**
 * Class Engine
 *
 * @package    Intraxia\Readlinks
 * @subpackage Handlebars
 */
class Engine {
	/**
	 * Registered helpers.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Path to views.
	 *
	 * @var string
	 */
	protected $views;

	/**
	 * Handlebars constructor.
	 *
	 * @param string $views
	 */
	public function __construct( string $views ) {
		$this->views = $views;
	}

	/**
	 * Register a new helper with the Engine.
	 *
	 * @param HelperInterface $helper
	 */
	public function register_helper( HelperInterface $helper ) : void {
		$this->helpers[ $helper->get_name() ] = $helper;
	}

	/**
	 * Render a template with the provided context.
	 *
	 * @param array  $context
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function render( array $context ) : string {
		$phpStr = LightnCandy::compile( file_get_contents( $this->views . 'index.hbs' ), array(
			'flags'           => LightnCandy::FLAG_HANDLEBARSJS_FULL | LightnCandy::FLAG_RUNTIMEPARTIAL | LightnCandy::FLAG_EXTHELPER,
			'helpers'         => array_keys( $this->helpers ),
			'partialresolver' => function ( $cx, $name ) {
				$filename = $this->views . $name . '.hbs';

				if ( file_exists( $filename ) ) {
					return file_get_contents( $filename );
				}

				return "[partial (file:$filename) not found]";
			},

		) );

		// @todo swap out deprecated prepare for custom solution (eval? write to filesystem?).
		$render = LightnCandy::prepare( $phpStr );

		if ( ! ( $render instanceof \Closure ) ) {
			throw new \Exception( 'Invalid PHP generated. Check Handlebars template for invalid syntax.' );
		}

		return $render( $context, [
			'helpers' => $this->helpers,
		] );
	}
}
