<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_counters.html#scrollTo__1881
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_counters.html#scrollTo__2100
 */

class ffElCounters5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'counters-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Counter 5', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'counter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'counter, counters');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE VALUE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('value', ark_wp_kses( __('Value', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'number', '', '30')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DIVIDER
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('divider', ark_wp_kses( __('Divider', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Features')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Counter Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
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

		$bg_color_selectors = array(
			'.counters-v5' => 'bg-color',
		);

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		echo '<section class="counters-v5">';
			echo '<div class="counters-v5-body">';

			foreach( $query->get('content') as $key=> $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'value':

						echo '<figure class="counter counters-v5-number">'. $oneLine->getWpKses('number') .'</figure>';
						break;

					case 'divider':

						$border_bottom_color_selectors = array(
							'.counters-v5-element' => 'divider-color',
							'.counters-v5-element:before' => 'divider-color',
							'.counters-v5-element:after' => 'divider-color',
						);

						foreach( $border_bottom_color_selectors as $selector => $c ){
							$color = $oneLine->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('border-bottom-color:' . $color . ';');
							}
						}

						echo '<span class="counters-v5-element"></span>';
						break;

					case 'title':
							echo '<h4 class="counters-v5-title">'. $oneLine->getWpKses('text') .'</h4>';
						break;

				}
			}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'value':
								query.addHeadingLg( 'number' );
								break;
							case 'title':
								query.addHeadingSm( 'text' );
								break;
						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}