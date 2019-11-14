<?php
/**
 * Navigation
 *
 * @package      EAGenesisChild
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Don't let Genesis load menus
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/**
 * Mobile Menu
 *
 */
function ea_site_header() {
	echo ea_mobile_menu_toggle();
	echo ea_search_toggle();

	if( has_nav_menu( 'primary' ) ) {
		echo '<nav' . ea_amp_class( 'nav-primary nav-menu', 'active', 'menuActive' ) . ' role="navigation">';
		wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) );
		echo '</nav>';
	}

	echo '<div' . ea_amp_class( 'header-search', 'active', 'searchActive' ) . '>' . get_search_form( array( 'echo' => false ) ) . '</div>';
}
add_action( 'genesis_header', 'ea_site_header', 11 );

/**
 * Search toggle
 *
 */
function ea_search_toggle() {
	$output = '<button' . ea_amp_class( 'search-toggle', 'active', 'searchActive' ) . ea_amp_toggle( 'searchActive', array( 'menuActive', 'mobileFollow' ) ) . '>';
		$output .= ea_icon( array( 'icon' => 'search', 'size' => 24, 'class' => 'open' ) );
		$output .= ea_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Search</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Mobile menu toggle
 *
 */
function ea_mobile_menu_toggle() {
	$output = '<button' . ea_amp_class( 'menu-toggle', 'active', 'menuActive' ) . ea_amp_toggle( 'menuActive', array( 'searchActive', 'mobileFollow' ) ) . '>';
		$output .= ea_icon( array( 'icon' => 'menu', 'size' => 24, 'class' => 'open' ) );
		$output .= ea_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Menu</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function ea_nav_add_dropdown_icons( $output, $item, $depth, $args ) {

	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = ea_icon( array( 'icon' => 'navigate-down', 'size' => 16 ) );

		$output .= sprintf(
			'<span class="submenu-expand" tabindex="-1">%s</span>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'ea_nav_add_dropdown_icons', 10, 4 );
