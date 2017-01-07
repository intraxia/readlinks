<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Context;

use Brain\Context\ContextProviderInterface;
use WP_Query;

/**
 * Class Home
 *
 * @package    Intraxia\Readlinks
 * @subpackage Context
 */
class Home implements ContextProviderInterface {
	/**
	 * Whether to provide the context.
	 *
	 * @param WP_Query $query
	 *
	 * @return bool
	 */
	public function accept( WP_Query $query ) : bool {
		return $query->is_home();
	}

	/**
	 * Get the context.
	 *
	 * @return array
	 */
	public function provide() : array {
		$posts = array();

		while ( have_posts() ) {
			the_post();

			$date = get_the_date( 'Y-m-d' );

			if ( ! array_key_exists( $date, $posts ) ) {
				$posts[ $date ] = [
					'links' => [ get_post() ],
				];
			} else {
				$posts[ $date ]['links'][] = get_post();
			}
		}
		wp_reset_postdata();

		return [ 'posts' => $posts ];
	}
}
