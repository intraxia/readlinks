<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Context;

use Brain\Context\ContextProviderInterface;

/**
 * Class Pager
 *
 * @package    Intraxia\Readlinks
 * @subpackage Context
 */
class Pager implements ContextProviderInterface {
	/**
	 * Whether to provide the context.
	 *
	 * @param \WP_Query $query
	 *
	 * @return bool
	 */
	public function accept( \WP_Query $query ) : bool {
		return $query->is_archive() || $query->is_home();
	}

	/**
	 * Get the context.
	 *
	 * @return array
	 */
	public function provide() : array {
		global $wp_query;

		$page = $wp_query->query_vars['paged'];

		return [
			'pages' => [
				'newer' => 1 === $page ? false : '/' . (($page - 1) ? ($page - 1) . '/' : ''),
				'older' => '/' . ($page + 1) . '/',
			],
		];
	}
}
