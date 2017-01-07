<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks;

use Brain\Context\ArrayMergeContextCollector;
use Brain\Context\ContextProviderInterface;
use Intraxia\Jaxion\Contract\Core\HasActions;

/**
 * Class Theme
 *
 * @package Intraxia\Readlinks
 */
class Theme implements HasActions {
	/**
	 * App container.
	 *
	 * @var ContextProviderInterface[]
	 */
	protected $contexts;

	/**
	 * Setup the Theme configuration.
	 */
	public function setup_theme() {
		/**
		 * Enable features from Soil when plugin is activated
		 *
		 * @link https://roots.io/plugins/soil/
		 */
		add_theme_support( 'soil-clean-up' );
		add_theme_support( 'soil-nav-walker' );
		add_theme_support( 'soil-nice-search' );
		add_theme_support( 'soil-relative-urls' );
		add_theme_support( 'soil-google-analytics' );

		/**
		 * Enable plugins to manage the document title
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
		 */
		add_theme_support( 'title-tag' );

		// Make theme available for translation
		// Community translations can be found at https://github.com/roots/sage-translations
		load_theme_textdomain( 'readlinks', get_template_directory() . '/lang' );

		/**
		 * Configuration values
		 */
		if ( ! defined( 'GOOGLE_ANALYTICS_ID' ) ) {
			// Format: UA-XXXXX-Y (Note: Universal Analytics onl`y)
			define( 'GOOGLE_ANALYTICS_ID', '' );
		}

		if ( ! defined( 'WP_ENV' ) ) {
			// Fallback if WP_ENV isn't defined in your WordPress config
			// Used in lib/assets.php to check for 'development' or 'production'
			define( 'WP_ENV', 'production' );
		}

		/**
		 * Register navigation menus
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
		 */
		register_nav_menus( [
			'primary_navigation' => __( 'Primary Navigation', 'sage' ),
		] );
	}

	/**
	 * Register a Context Provider with the Theme.
	 *
	 * @param ContextProviderInterface $context
	 */
	public function register_context( ContextProviderInterface $context ) {
		$this->contexts[] = $context;
	}

	/**
	 * Register the provided Contexts with the Collector.
	 *
	 * @todo create our own collector in the container, register to it,
	 * @todo and pass it into the context loader directly.
	 *
	 * @param ArrayMergeContextCollector $collector
	 */
	public function register_contexts( ArrayMergeContextCollector $collector ) {
		foreach ( $this->contexts as $context ) {
			$collector->addProvider( $context );
		}
	}

	/**
	 * Provides the array of actions the class wants to register with WordPress.
	 *
	 * These actions are retrieved by the Loader class and used to register the
	 * correct service methods with WordPress.
	 *
	 * @return array[]
	 */
	public function action_hooks() {
		return [
			[
				'hook'   => 'after_setup_theme',
				'method' => 'setup_theme',
			],
			[
				'hook'   => 'brain.context.providers',
				'method' => 'register_contexts',
			],
		];
	}
}
