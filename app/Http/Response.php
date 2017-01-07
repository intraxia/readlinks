<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Http;

use Brain\Context\WpContextLoader;
use Intraxia\Jaxion\Contract\Assets\Register as Assets;
use Intraxia\Jaxion\Contract\Core\HasActions;
use Intraxia\Readlinks\Handlebars\Engine;

/**
 * Class Response
 *
 * @package    Intraxia\Readlinks
 * @subpackage Http
 */
class Response implements HasActions {
	/**
	 * Assets registration service.
	 *
	 * @var Assets
	 */
	private $assets;

	/**
	 * Rendering engine service.
	 *
	 * @var Engine
	 */
	private $engine;

	/**
	 * Response constructor.
	 *
	 * @param Assets $assets
	 * @param Engine $engine
	 */
	public function __construct( Assets $assets, Engine $engine ) {
		$this->assets = $assets;
		$this->engine = $engine;
	}

	/**
	 * Return the route template and give WordPress an empty
	 * template to move on.
	 *
	 * @return string
	 */
	public function render() {
		global $wp_query;

		$context = WpContextLoader::load( $wp_query );

		$this->assets->register_script( [
			'type'      => 'web',
			'condition' => function () {
				return true;
			},
			'handle'    => 'readlinks',
			'src'       => 'assets/readlinks',
			'footer'    => false,
			'localize'  => [
				'name' => '__READLINKS_STATE__',
				'data' => $context,
			],
		] );

		wp_register_style( 'google_fonts', 'http://fonts.googleapis.com/css?family=Ubuntu:400,700', false );
		wp_enqueue_style( 'google_fonts' );

		$this->assets->enqueue_web_scripts();

		// @codingStandardsIgnoreStart
		echo $this->engine->render( 'index', $context );
		// @codingStandardsIgnoreEnd

		// Return a blank file to make WordPress happy
		return get_theme_file_path( 'index.php' );
	}

	/**
	 * Provides the array of actions the class wants to register with WordPress.
	 *
	 * These actions are retrieved by the Loader class and used to register the
	 * correct service methods with WordPress.
	 *
	 * @return array[]
	 */
	public function action_hooks() : array {
		return [
			[
				'hook'     => 'template_include',
				'method'   => 'render',
				'priority' => PHP_INT_MAX,
			],
		];
	}
}
