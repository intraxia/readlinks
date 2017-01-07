<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Context;

use Brain\Context\ContextProviderInterface;

/**
 * Class Link
 *
 * @package    Intraxia\Readlinks
 * @subpackage Context
 */
class Link implements ContextProviderInterface {
	/**
	 * Whether to provide the context.
	 *
	 * @param \WP_Query $query
	 *
	 * @return bool
	 */
	public function accept( \WP_Query $query ) : bool {
		return $query->is_single();
	}

	/**
	 * Get the context.
	 *
	 * @return array
	 */
	public function provide() : array {
		return [
			'link' => get_post(),
		];
	}
}
