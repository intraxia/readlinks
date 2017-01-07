<?php
declare( strict_types = 1 );
namespace Intraxia\Readlinks\Handlebars\Helper;

use LightnCandy\SafeString;
use Walker_Nav_Menu;

/**
 * Class Navigation
 *
 * @package    Intraxia\Readlinks
 * @subpackage Handlebars\Helper
 */
class Navigation extends Walker_Nav_Menu implements HelperInterface {
	/**
	 * Gets the name of the helper.
	 *
	 * @return string
	 */
	public function get_name() : string {
		return 'navigation';
	}

	/**
	 * Call the helper.
	 *
	 * @return SafeString
	 */
	public function __invoke() {
		$output = '';

		if ( has_nav_menu( 'primary_navigation' ) ) {
			ob_start();
			wp_nav_menu( [
				'theme_location' => 'primary_navigation',
				'walker'         => $this,
				'menu_class'     => 'nav navbar-nav',
			] );
			$output = ob_get_contents();
			ob_end_clean();
		}

		return new SafeString( $output );
	}

	/**
	 * Check the current classes.
	 *
	 * @param string $classes
	 *
	 * @return int
	 */
	public function checkCurrent( $classes ) {
		return preg_match( '/(current[-_])|active|dropdown/', $classes );
	}

	/**
	 * Start a new level.
	 *
	 * @param string $output
	 * @param int    $depth
	 * @param array  $args
	 */
	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	}

	/**
	 * Start a new element.
	 *
	 * @param string   $output
	 * @param \WP_Post $item
	 * @param int      $depth
	 * @param array    $args
	 * @param int      $id
	 */
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );

		if ( $item->is_dropdown && ( 0 === $depth ) ) {
			$item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html );
			$item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
		} elseif ( stristr( $item_html, 'li class="divider' ) ) {
			$item_html = preg_replace( '/<a[^>]*>.*?<\/a>/iU', '', $item_html );
		} elseif ( stristr( $item_html, 'li class="dropdown-header' ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html );
		}

		$item_html = apply_filters( 'sage/wp_nav_menu_item', $item_html );
		$output .= $item_html;
	}

	/**
	 * Display the provided element.
	 *
	 * @param object $element
	 * @param array  $children_elements
	 * @param int    $max_depth
	 * @param int    $depth
	 * @param array  $args
	 * @param string $output
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_dropdown = ( ( ! empty( $children_elements[ $element->ID ] ) && ( ( $depth + 1 ) < $max_depth || ( 0 === $max_depth ) ) ) );

		if ( $element->is_dropdown ) {
			$element->classes[] = 'dropdown';

			foreach ( $children_elements[ $element->ID ] as $child ) {
				if ( $child->current_item_parent || Utils\url_compare( $this->archive, $child->url ) ) {
					$element->classes[] = 'active';
				}
			}
		}

		$element->is_active = false;

		if ( $element->is_active ) {
			$element->classes[] = 'active';
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Gets the CSS classes for an item.
	 *
	 * @param mixed $classes
	 * @param mixed $item
	 *
	 * @return array
	 */
	public function cssClasses( $classes, $item ) {
		$slug = sanitize_title( $item->title );

		$classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );
		$classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );

		$classes[] = 'menu-' . $slug;

		$classes = array_unique( $classes );

		return $classes;
	}
}
