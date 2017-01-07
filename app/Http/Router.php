<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Http;

use Brain\Cortex\Route\QueryRoute;
use Brain\Cortex\Route\RouteCollectionInterface;
use Intraxia\Jaxion\Contract\Core\HasActions;

/**
 * Class Router
 *
 * @package    Intraxia\Readlinks
 * @subpackage Http
 */
class Router implements HasActions {
	/**
	 * Registers all the routes with the router.
	 *
	 * @param RouteCollectionInterface $routes
	 */
	public function register_routes( RouteCollectionInterface $routes ) {
		$routes->addRoute( new QueryRoute( '/', function ( array $matches ) {
			$page  = 1;
			$index = $page - 1;

			return [
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => 50,
				'paged'          => $page,
				'date_query'     => [
					[
						'before' => $index * 2 . ' weeks ago',
						'after'  => $page * 2 . ' weeks ago',
					],
				],
			];
		} ) );

		$routes->addRoute( new QueryRoute( '/{page:\d+}/', function ( array $matches ) {
			$page  = $matches['page'];
			$index = $page - 1;

			return [
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => 50,
				'paged'          => $page,
				'date_query'     => [
					[
						'before' => $index * 2 . ' weeks ago',
						'after'  => $page * 2 . ' weeks ago',
					],
				],
			];
		} ) );
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
				'hook'   => 'cortex.routes',
				'method' => 'register_routes',
			],
		];
	}
}
