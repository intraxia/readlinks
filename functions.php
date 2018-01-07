<?php
declare( strict_types = 1 );

use Brain\Cortex;
use Intraxia\Jaxion\Core\Config;
use Intraxia\Jaxion\Core\ConfigType;
use Intraxia\Readlinks\App;

/**
 * Helper function for prettying up errors
 *
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$theme_error = function ( $message, $subtitle = '', $title = '' ) {
	$title   = $title ?: __( 'Readlinks Error', 'readlinks' );
	$message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p>";
	wp_die( $message, $title );
};

/**
 * Ensure compatible version of PHP is used
 */
if ( version_compare( '7.1.0', phpversion(), '>=' ) ) {
	$theme_error( __( 'You must be using PHP 7.1.0 or greater.', 'readlinks' ), __( 'Invalid PHP version', 'readlinks' ) );
}

/**
 * Ensure dependencies are loaded
 */
if ( ! ( $exists = file_exists( $composer = __DIR__ . '/vendor/autoload.php' ) ) && ! class_exists( App::class ) ) {
	$theme_error(
		__( 'You must run <code>composer install</code> from the Readlinks directory.', 'readlinks' ),
		__( 'Autoloader not found.', 'readlinks' )
	);
}

if ( $exists ) {
	require_once $composer;
}

$app = new App( new Config( ConfigType::THEME, __FILE__ ) );

$app->boot();
$app->fetch( 'loader' )->run();
Cortex::boot();
