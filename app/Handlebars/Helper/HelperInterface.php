<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Handlebars\Helper;

/**
 * Interface HelperInterface
 *
 * @package    Intraxia\Readlinks
 * @subpackage Handlebars\Helper
 */
interface HelperInterface {
	/**
	 * Get the helper name.
	 *
	 * @return string
	 */
	public function get_name() : string;

	/**
	 * Call the helper.
	 *
	 * @return mixed
	 */
	public function __invoke();
}
