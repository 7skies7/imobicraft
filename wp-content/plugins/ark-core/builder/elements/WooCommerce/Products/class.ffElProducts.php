<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_shopify.html#scrollTo__1674
 * */

class ffElProducts extends ffThemeBuilderElementBasic {
	protected function _initData(){
		$this->_setData(ffThemeBuilderElement::DATA_ID, 'woocommerce-products');
		$this->_setData(ffThemeBuilderElement::DATA_NAME, esc_attr( __('WooCommerce Products', 'ark' ) ) );
		$this->_setData(ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		$this->_setData(ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData(ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'woocommerce');
		$this->_setData(ffThemeBuilderElement::DATA_PICKER_TAGS, 'woocommerce, products, plugins, eshop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));
	}

	protected function _getElementGeneralOptions($s) {

		$s->addElement(ffOneElement::TYPE_TABLE_START);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Warning', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', '<p class="warning">'.ark_wp_kses( __('If <strong>WooCommerce Plugin</strong> plugin is not installed and activated, then this <strong>WooCommerce Products</strong> element will not work.','ark') ).'</p>');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Products Content', 'ark' ) ));

				$s->startRepVariableSection('content');

					/* TYPE FEATURED IMAGE */
					$s->startRepVariationSection('featured-image', ark_wp_kses( __('Featured Image', 'ark' ) ));
						$this->_getBlock(ffThemeBlConst::FEATUREDIMG)->injectOptions($s);
					$s->endRepVariationSection();

					/* TYPE POST TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('This is the Title', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE PRICE */
					$s->startRepVariationSection('price', ark_wp_kses( __('Price', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('This is the Price', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE ADD TO CART BUTTON */
					$s->startRepVariationSection('button', ark_wp_kses( __('Add to Cart Button', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Add to Cart')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Add to Cart Button Text', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Second button <code>View Cart</code> is an integral part of the WooCommerce plugin.', 'ark' ) ) );
					$s->endRepVariationSection();

				$s->endRepVariableSection();
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Product Wrapper', 'ark' ) ) );
				$s->startAdvancedToggleBox('product-wrapper', 'Product Wrapper');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('This is the Product Wrapper that you can edit and style', 'ark') ) );
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');
				$s->endAdvancedToggleBox();
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			$this->_injectColumnOptions( $s );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->startSection('add-to-cart');
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Add To Cart Button - Text', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Add To Cart Button - Border', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Add To Cart Button - Background', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Add To Cart Button - Text Hover', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Add To Cart Button - Border Hover', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Add To Cart Button - Background Hover', 'ark')) );
			$s->endSection();

			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->startSection('view-cart');
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Viev Cart Button - Text', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Viev Cart Button - Border', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Viev Cart Button - Background', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Viev Cart Button - Text Hover', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Viev Cart Button - Border Hover', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Viev Cart Button - Background Hover', 'ark')) );
				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement(ffOneElement::TYPE_TABLE_END);
	}

	protected function _wpPagination( $s ) {
		$this->_getBlock( ffThemeBlConst::PAGINATION )->injectOptions( $s );
	}

	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _wpLoopSettings($s) {
		$this->_getWpLoop()->injectOptions($s);
	}

	protected function _getWpLoop() {
		return $this->_getBlock(ffThemeBuilderBlock::LOOP)
			->setParam( ffThemeBuilderBlock_Loop::PARAM_POST_TYPE, 'product')
			->setParam( ffThemeBuilderBlock_Loop::PARAM_TAXONOMY_TYPE, 'product_cat');
	}

		/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $postIndex
	 */
	protected function _printClearFixDiv( $query, $postIndex ) {

		$numberOfColumns = array( 2, 3, 4, 6);
		$grid = $query->get('grid');

		$clearfixClasses = array();

		foreach( $numberOfColumns as $oneColumn ) {
			if( $postIndex % $oneColumn != 0 ) {
				continue;
			}

			foreach( $this->_getBreakpoints() as $oneBreakpoint ) {
				if( $grid->get( $oneBreakpoint ) == $oneColumn ) {
					$clearfixClasses[] = 'visible-' . $oneBreakpoint . '-block';
				}
			}
		}

		if( !empty($clearfixClasses) ) {
			$clearfixString = implode(' ', $clearfixClasses );
			echo '<div class="clearfix ' . $clearfixString .'"></div>';
		}

	}

	/**
	 * @param $select ffOneOption
	 * @param $columns array
	 */
	protected function _fillSelectWithNumberOfColumns( $select, $columns ) {

		foreach( $columns as $oneColumn ) {
			$select->addSelectValue( $oneColumn, $oneColumn );
		}

	}

	protected function _getBreakpoints() {
		$breakpoints = array();

		$breakpoints[] = 'xs';
		$breakpoints[] = 'sm';
		$breakpoints[] = 'md';
		$breakpoints[] = 'lg';

		return $breakpoints;
	}

	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _injectColumnOptions( $s ) {

		$xs = 1;
		$sm = 2;
		$md = 3;
		$lg = 3;

		$numberOfColumns = array(1,2,3,4,6);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );
			$s->startSection('grid');
				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'xs', 'Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $xs);
				$this->_fillSelectWithNumberOfColumns( $select, $numberOfColumns );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'sm', 'Tablet (SM)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $sm);
				$this->_fillSelectWithNumberOfColumns( $select, $numberOfColumns );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'md', 'Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $md);
				$this->_fillSelectWithNumberOfColumns( $select, $numberOfColumns );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'lg', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $lg);
				$this->_fillSelectWithNumberOfColumns( $select, $numberOfColumns );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom horizontal gap between columns (in px)', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

			$s->endSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
	}


	/**
	 * @param $query ffOptionsQueryDynamic
	 * @return bool|string
	 */
	protected function _calculateColumnOptions( $query ) {
		if( !$query->exists( 'grid') ) {
			return false;
		}

		$cols = array();
		$query = $query->get('grid');
		foreach( $this->_getBreakpoints() as $oneBreakpoint ) {
			$numberOfColumns = $query->get( $oneBreakpoint );
			$bootstrapNumber = 12 / $numberOfColumns;

			$cols[] = 'col-' . $oneBreakpoint . '-' . $bootstrapNumber;
		}

		$colsString = implode(' ', $cols);

		$spaceBetweenColumns = $query->get('space');

		if( $spaceBetweenColumns !== '' ) {
			$spaceBetweenColumns = floatval($spaceBetweenColumns);
			$oneHalf = $spaceBetweenColumns / 2;

			$rowCss = '';
			$rowCss .= 'margin-left: -' . $oneHalf .'px;' . PHP_EOL;
			$rowCss .= 'margin-right: -' .$oneHalf .'px;';

			$colCss = '';
			$colCss .= 'padding-left:' . $oneHalf .'px;' . PHP_EOL;
			$colCss .= 'padding-right:' .$oneHalf .'px;';


			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.fg-blog-row-main')
				->addParamsString($rowCss );

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.fg-blog-col-main')
				->addParamsString($colCss );
		}

		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceVertical = absint( $spaceVertical );

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.fg-blog-col-main')
				->addParamsString('margin-bottom:' . $spaceVertical . 'px;');
		}

		return $colsString;
	}

	protected function _render(ffOptionsQueryDynamic $query, $content, $data, $uniqueId) {

		if( !function_exists('WC') ){
			echo '<div></div>';
			return;
		}

		$cart = WC()->cart;
		if( empty( $cart ) ){
			echo '<div></div>';
			return;
		}

		$cols = $this->_calculateColumnOptions( $query );

		echo '<section class="ark-woocommerce-products">';

		if( ! class_exists('WooCommerce') ){
			echo ark_wp_kses( __('This section <strong>WooCommerce Products</strong> is disabled, because <strong>WooCommerce Plugin</strong> is not active or installed.','ark') );
			echo '</section>';
			return;
		}

		echo '<div class="row fg-blog-row-main fg-row">';

		/**
		 * @var $wpQuery WP_Query
		 */
		$loopBlock = $this->_getWpLoop();
		$wpQuery = $loopBlock->get($query);

		if ($wpQuery->have_posts()) {

			$postIndex = 1;

			while ($wpQuery->have_posts()) {
				$wpQuery->the_post();

				if( !$loopBlock->canBePostPrinted() ) {
					continue;
				}

				echo '<div class="fg-col fg-blog-col-main '. $cols .'">';

				$postID = $wpQuery->post->ID;

				$this->_advancedToggleBoxStart( $query, 'product-wrapper' );
				echo '<div id="post-'. $postID .'" class="ark-product-wrapper'. implode(' ', get_post_class('post-wrapper')) .'" >';

				$_product = wc_get_product( $postID );

				if ( $_product && $_product->exists() ) {
					$product_name = $_product->get_title();
					$product_price = WC()->cart->get_product_price($_product);
					$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink() : '');

					foreach ($query->get('content') as $postItem) {
						switch ($postItem->getVariationType()) {
							case 'featured-image':
								$this->_getBlock(ffThemeBlConst::FEATUREDIMG)
									->setParam('post-id', $postID)
									->setParam('css-class', 'featured-image')
									->render($postItem);
								break;

							case 'title':
								echo '<a href="'.esc_url($product_permalink).'" class="title">' . $product_name . '</a>';
								break;

							case 'price':
								echo '<div class="price">' . $product_price . '</div>';
								break;

							case 'button':
								echo '<div class="ark-cart-buttons">';

								do_action( 'woocommerce_before_add_to_cart_button' );

								echo '<a rel="nofollow"';
								echo ' href="'.$_product->add_to_cart_url().'"';
								echo ' data-quantity="1"';
								echo ' data-product_id="'.$postID.'"';
								echo ' data-product_sku=""';
								echo ' class="add_to_cart_button ajax_add_to_cart"';
								echo '>';
								$postItem->printWpKses('title');
								echo '</a>';

								do_action( 'woocommerce_after_add_to_cart_button' );

								echo '</div>';
								break;

						}
					}

					echo '</div>';
				}

				echo '</div>';

				$this->_advancedToggleBoxEnd( $query, 'product-wrapper' );

				$this->_printClearFixDiv( $query, $postIndex );

				$postIndex++;
			}
		}

		echo '</div>';


		$paginationBlock = $this->_getBlock( ffThemeBlConst::PAGINATION )->setParam(ffBlPagination::PARAM_POST_GRID_UNIQUE_ID, $uniqueId)->setWpQuery( $wpQuery );

		if( $paginationBlock->showPagination( $query ) ) {
			echo '<div class="blog-pagination row">';
				echo '<div class="col-xs-12">';
					$paginationBlock->render($query);
				echo '</div>';
			echo '</div>';
		}

		echo '</section>';


		/* add-to-cart - normal */
		$this->_renderCSSRule( 'color', $query->get('add-to-cart color'), 'a.add_to_cart_button');
		$this->_renderCSSRule( 'color', $query->get('add-to-cart color'), 'a.add_to_cart_button:after');
		$this->_renderCSSRule( 'background-color', $query->get('add-to-cart bg-color'), 'a.add_to_cart_button');
		$this->_renderCSSRule( 'border-color', $query->get('add-to-cart border-color'), 'a.add_to_cart_button');

		/* add-to-cart - loading */
		$this->_renderCSSRule( 'color', $query->get('add-to-cart color-hover'), 'a.add_to_cart_button.loading');
		$this->_renderCSSRule( 'color', $query->get('add-to-cart color-hover'), 'a.add_to_cart_button.loading:after');
		$this->_renderCSSRule( 'background-color', $query->get('add-to-cart bg-color-hover'), 'a.add_to_cart_button.loading');
		$this->_renderCSSRule( 'border-color', $query->get('add-to-cart border-color-hover'), 'a.add_to_cart_button.loading');

		/* add-to-cart - hover */
		$this->_renderCSSRule( 'color', $query->get('add-to-cart color-hover'), 'a.add_to_cart_button:hover');
		$this->_renderCSSRule( 'color', $query->get('add-to-cart color-hover'), 'a.add_to_cart_button:hover:after');
		$this->_renderCSSRule( 'background-color', $query->get('add-to-cart bg-color-hover'), 'a.add_to_cart_button:hover');
		$this->_renderCSSRule( 'border-color', $query->get('add-to-cart border-color-hover'), 'a.add_to_cart_button:hover');


		/* view-cart - normal */
		$this->_renderCSSRule( 'color', $query->get('view-cart color'), 'a.added_to_cart');
		$this->_renderCSSRule( 'color', $query->get('view-cart color'), 'a.added_to_cart:after');
		$this->_renderCSSRule( 'background-color', $query->get('view-cart bg-color'), 'a.added_to_cart');
		$this->_renderCSSRule( 'border-color', $query->get('view-cart border-color'), 'a.added_to_cart');

		/* view-cart - hover */
		$this->_renderCSSRule( 'color', $query->get('view-cart color-hover'), 'a.added_to_cart:hover');
		$this->_renderCSSRule( 'color', $query->get('view-cart color-hover'), 'a.added_to_cart:hover:after');
		$this->_renderCSSRule( 'background-color', $query->get('view-cart bg-color-hover'), 'a.added_to_cart:hover');
		$this->_renderCSSRule( 'border-color', $query->get('view-cart border-color-hover'), 'a.added_to_cart:hover');

		$loopBlock->resetOnTheEnd();
	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'featured-image':
							query.addPlainText( 'Featured Image' );
							query.addBreak();
							break;
						case 'title':
							query.addPlainText( 'Product Title' );
							query.addBreak();
							break;
						case 'price':
							query.addPlainText( 'Product Price' );
							query.addBreak();
							break;
						case 'button':
							query.addText('title');
							break;
					}
				});
			}
		</script data-type="ffscript">
	<?php
	}


}