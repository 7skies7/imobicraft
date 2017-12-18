<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_creative.html#scrollTo__1420
 */

class ffElCounters2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'counters-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Counter 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'counter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'counter, counters');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ICON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-layers')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE VALUE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('value', ark_wp_kses( __('Value', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'number', '', '808')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'number-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value color', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Design Completed')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LABEL
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('label', ark_wp_kses( __('Label', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Great Performance')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', '')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), '')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-counters' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$this->_renderCSSRule( 'text-align', $query->getColor( 'align' ) );

		echo '<section class="counters-v2">';

			foreach( $query->get('content') as $key=> $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'icon':
						echo '<i class="counters-v2-icon '. $oneLine->getEscAttr('icon') .'"></i>';
						break;

					case 'value':



						$color_selectors = array(
							'.counters-v2-no' => 'number-color',
						);

						foreach( $color_selectors as $selector => $c ){
							$color = $oneLine->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('color:' . $color . ';');
							}
						}

						echo '<figure class="counter counters-v2-no">'. $oneLine->getWpKses('number') .'</figure>';
						break;

					case 'title':
						echo '<h4 class="counters-v2-title">'. $oneLine->getWpKses('text') .'</h4>';
						break;

					case 'label':
						echo '<span class="counters-v2-subtitle">'. $oneLine->getWpKses('text') .'</span>';
						break;

				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'icon':
								query.addIcon( 'icon' );
								break;
							case 'value':
								query.addHeadingLg( 'number' );
								break;
							case 'title':
								query.addHeadingSm( 'text' );
								break;
							case 'label':
								query.addText( 'text' );
								break;
						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}