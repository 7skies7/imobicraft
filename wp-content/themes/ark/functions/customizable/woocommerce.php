<?php


if( ! function_exists('ark_woocommerce_get__cart_menu_item__content') ) {
	/**
	 * Returns string with shopping basket icon and content in VERTICAL menu
	 *
	 * @return string
	 */
	function ark_woocommerce_get__cart_menu_item__content() {
		ob_start();
		echo '<div class="navbar-actions-shrink shopping-cart">';

			echo '<a href="javascript:void(0);" class="shopping-cart-icon-container ffb-cart-menu-item">';
				echo '<span class="shopping-cart-icon-wrapper" title="' . WC()->cart->get_cart_contents_count() . '">';
				echo '<span class="shopping-cart-menu-title">';
					echo get_the_title( wc_get_page_id('cart') );
					echo '&nbsp;';
				echo '</span>';
				echo '<i class="icon-shopping-cart"></i> ';
				echo '</span>';
			echo '</a>';

			echo '<div class="shopping-cart-menu-wrapper">';
				wc_get_template( 'cart/mini-cart.php', array('list_class' => ''));
			echo '</div>';

		echo '</div>';
		return ob_get_clean();
	}
}

add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_ark__cart_menu_item__fragment');
if( ! function_exists('woocommerce_ark__cart_menu_item__fragment') ) {
	/**
	 * Adds rule after product(s) is added to shopping basket. Rule is that everything with class .shopping-cart is
	 * refreshed / reloaded with ajax
	 *
	 * @param array $fragments
	 * @return array
	 */
	function woocommerce_ark__cart_menu_item__fragment($fragments) {
		$fragments['.shopping-cart'] = ark_woocommerce_get__cart_menu_item__content();
		return $fragments;
	}
}


add_action( 'after_setup_theme', 'ark_woocommerce_support' );
if( ! function_exists('ark_woocommerce_support') ) {
	/**
	 * Declare WooCommerce support in ark theme
	 */
	function ark_woocommerce_support() {
		add_theme_support('woocommerce');
	}
}

// Resolve conflict Fresh Performance Cache vs WooCommerce

if( !function_exists('ark_woocommerce_theme_banned_js_minification') ) {

	function ark_woocommerce_theme_banned_js_minification( $bannedFiles ) {

		if( !is_array( $bannedFiles ) ) {
			$bannedFiles = array();
		}

		$wc_files_slugs = array(
			'wc-add-to-cart',
			'zoom',
			'flexslider',
			'photoswipe',
			'photoswipe-ui-default',
			'wc-single-product',
			'jquery-blockui',
			'js-cookie',
			'woocommerce',
			'wc-cart-fragments',
		);

		$bannedFiles = array_merge( $wc_files_slugs, $bannedFiles);

		return( $bannedFiles );
	}

	add_action('ff_performance_cache_banned_js', 'ark_woocommerce_theme_banned_js_minification');

}

if( !function_exists('ark_woocommerce_theme_banned_css_minification') ) {

	function ark_woocommerce_theme_banned_css_minification( $bannedFiles ) {

		if( !is_array( $bannedFiles ) ) {
			$bannedFiles = array();
		}

		$wc_files_slugs = array(
			'photoswipe',
			'photoswipe-default-skin',
			'woocommerce-layout',
			'woocommerce-smallscreen',
			'woocommerce-general',
		);

		$bannedFiles = array_merge( $wc_files_slugs, $bannedFiles);

		return( $bannedFiles );
	}

	add_action('ff_performance_cache_banned_css', 'ark_woocommerce_theme_banned_css_minification');

}

if( !function_exists('ark_woocommerce_fresh_builder__extra_escaped_quotes_fix') ) {

	function ark_woocommerce_fresh_builder__extra_escaped_quotes_fix( $content ) {
		return preg_replace('/ffb\\-id\\-&#\d{1,4}\\;([a-zA-Z0-9]*)&#\d{1,4}\\;/', 'ffb-id-$1', $content);
	}

	add_filter('the_content', 'ark_woocommerce_fresh_builder__extra_escaped_quotes_fix', 20);
	add_filter('woocommerce_format_content', 'ark_woocommerce_fresh_builder__extra_escaped_quotes_fix', 20);
}


if( !function_exists( 'ark_woocommerce_force_shortcode' ) ) {
	function ark_woocommerce_force_shortcode(){
		if( function_exists( 'is_product' ) ) {
			if (have_posts() and is_product()) {
				add_filter('the_content', 'do_shortcode', 1);
			}
		}
	}
}

add_action( 'template_redirect', 'ark_woocommerce_force_shortcode' );