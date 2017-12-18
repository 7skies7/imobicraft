<?php

class ffElBreadcrumbsNoTitle extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'breadcrumbs-no-title');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('SEO Microdata Breadcrumbs', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'titlebar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'breadcrumbs, titlebar, title, bar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 1);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Breadcrumbs', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_TEXT, 'front-page-title', '', get_bloginfo('name') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Front Page Label', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('This is the first titlebar item that automatically links to your front page', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_TEXT, 'separator', '', ' / ' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Breadcrumbs Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bc-parent-item', '' , '#757589')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Parent Item', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bc-parent-item-hover', '' , '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Parent Item - Hover', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bc-separator', '' , '#757589')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator Item', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bc-current-item', '' , '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Current Item', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$text_color_selectors = array(
			' a.link' => 'bc-parent-item',
			' a.link:hover' => 'bc-parent-item-hover',
			' .separator' => 'bc-separator',
			' .active' => 'bc-current-item',
		);

		foreach( $text_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}

		$breadcrumbsCollection = ffContainer()->getLibManager()->createBreadcrumbs()->generateBreadcrumbs();
		$bc = array();

		foreach( $breadcrumbsCollection as $oneItem ) {

			if( $oneItem->queryType == ffConstQuery::HOME ) {
				$oneItem->name = $query->get('front-page-title');
				if( empty($oneItem->name) ){
					continue;
				}
			}

			if( $oneItem->isSelected ) {
				$bc[] =
					'<span class="active" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
						. '<span itemscope itemtype="http://schema.org/Thing" itemprop="item">'
							. '<span itemprop="name">'
								. ark_wp_kses($oneItem->name)
							. '</span>'
						. '</span>'
					. '</span>';
			} else {
				$bc[] =
					'<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
						. '<a class="link" itemscope itemtype="http://schema.org/Thing" itemprop="item" href="'. esc_attr($oneItem->url) .'">'
							. '<span itemprop="name">'
								. ark_wp_kses($oneItem->name)
							. '</span>'
						. '</a>'
					. '</span>';
			}
		}

		$separator = $query->get('separator');
		$separator = str_replace(' ', '&nbsp;', $separator );
		$separator = '<span class="separator">'.$separator.'</span>';

		echo '<section class="breadcrumbs-pure">';
		echo '<div itemscope itemtype="http://schema.org/BreadcrumbList">';
		echo implode($separator, $bc);
		echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {
				query.addHeadingLg( null, 'Breadcrumbs Items' );
			}
		</script data-type="ffscript">
		<?php
	}


}