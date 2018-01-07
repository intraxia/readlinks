<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks;

use Intraxia\Jaxion\Assets\ServiceProvider as AssetsServiceProvider;
use Intraxia\Jaxion\Core\Application;
use Intraxia\Readlinks\Provider\ContextServiceProvider;
use Intraxia\Readlinks\Provider\HttpServiceProvider;
use Intraxia\Readlinks\Provider\ThemeServiceProvider;
use Intraxia\Readlinks\Provider\ViewServiceProvider;

/**
 * Class App
 *
 * @package Intraxia\Readlinks
 */
class App extends Application {
	/**
	 * Define plugin version on Application.
	 */
	const VERSION = '0.1.0';

	/**
	 * ServiceProviders to register with the Application
	 *
	 * @var string[]
	 */
	protected $providers = [
		AssetsServiceProvider::class,
		ContextServiceProvider::class,
		HttpServiceProvider::class,
		ThemeServiceProvider::class,
		ViewServiceProvider::class,
	];
}
