<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services.html#scrollTo__7228
 */

class ffElLogoGrid extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'logo-grid');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Logo Grid', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'logo-grid');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'logo, grid, logo grid');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );
				$s->startRepVariableSection('content');
					$s->startRepVariationSection('image', ark_wp_kses( __('Logo', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 435)
							->injectOptions( $s )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
					$s->endRepVariationSection();
				$s->endRepVariableSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Number of Columns', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'column-count', '', '3')
					->addSelectValue( '2', '2')
					->addSelectValue( '3', '3')
					->addSelectValue( '4', '4')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', 'rgba(255, 255, 255, 0.4)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Borders', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderCSSRule( 'background-color', $query->getColor( 'border-color' ), '.clients-v2-border-left:after' );
		$this->_renderCSSRule( 'background-color', $query->getColor( 'border-color' ), '.clients-v2-border-top:before' );

		echo '<div class="ff-logo-grid">';
		echo '<div class="row">';

		$columnsCount = absint( $query->get('column-count') );
		if( 3 < $columnsCount){ $columnsCount = 4; }
		if( 3 > $columnsCount){ $columnsCount = 2; }
		$columnsClass = 'col-xs-'.(absint( 12 / $columnsCount ));

		$x = 0;
		$y = 0;
		$index = 0;

		foreach( $query->get('content') as $key => $oneItem ) {
			echo '<div class="';
			echo esc_attr($columnsClass);
			echo ' xs-full-width';
			if( $y > 0 ) {
				echo ' clients-v2-border-top';
			}
			if( $x > 0 ) {
				echo ' clients-v2-border-left';
			}
			echo '">';
			echo '<div class="clients-v2-content">';
			switch( $oneItem->getVariationType() ) {
				case 'image':
					$hasLinkWrapper = $this->_getBlock(ffThemeBuilderBlock::LINK)->urlHasBeenFilled($oneItem);
					if ($hasLinkWrapper) {
						echo '<a ';
						$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'responsive-image-wrapper')->render($oneItem);
						echo '>';
					}

					$this->_getBlock(ffThemeBlConst::IMAGE)
						->imgIsResponsive()
						->imgIsFullWidth()
						->setParam('width', 435)
						->render($oneItem)
					;

					if ($hasLinkWrapper) {
						echo '</a>';
					}
					break;
			}
			echo '</div>';
			echo '</div>';

			$index ++;
			$x = $index % $columnsCount;
			$y = floor( $index / $columnsCount );

			if( 0 == $x ){
				echo '</div><div class="row">';
			}
		}

		echo '</div>';
		echo '</div>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'image':
								blocks.render('image', query);
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}