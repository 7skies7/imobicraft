<?php

/**
 * @link http://prothemes.net/ark/HTML/shortcodes_theme_icons.html
 */

class ffElIcons extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'icons');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icons', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icons', 'ark' ) ) );

				$this->_getBlock( ffThemeBlConst::ICONS )->injectOptions( $s );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-left' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Spacing', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'padding', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom Horizontal Margin Around Icons (in px)', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<div class="icons ff-el-icons '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-left' ) )
			. '">';

		$this->_getBlock(ffThemeBlConst::ICONS)->render($query);

		echo '</div>';

		$p = $query->get('padding');

		if( !empty($p) || ( '0' === $p ) || ( 0 === $p ) ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' > ul > li', false)
				->addParamsString('padding-right: '.$p.'px;');
		}

		if( !empty($p) || ( '0' === $p ) || ( 0 === $p ) ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' > ul > li', false)
				->addParamsString('padding-left: '.$p.'px;');
		}

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				blocks.render('icons', query);

			}

		</script data-type="ffscript">
	<?php
	}


}