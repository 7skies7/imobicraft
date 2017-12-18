<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_3.html#scrollTo__1200
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_counters.html#scrollTo__330
 */

class ffElCounters1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'counters-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Counter 1', 'ark' ) ) );
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
					/* TYPE LABEL
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('label', ark_wp_kses( __('Label', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Over')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE VALUE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('value', ark_wp_kses( __('Value', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'number', '', '30')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'number-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value Color', 'ark' ) ) )
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

		$this->_renderCSSRule( 'text-align', $query->get( 'align' ), '.counters-v1-body' );

		echo '<section class="counters-v1">';

			echo '<div class="counters-v1-body" ';
			echo '>';

				foreach( $query->get('content') as $key=> $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'value':

							if($oneLine->getColor('number-color')) {
								$this->getAssetsRenderer()->createCssRule()
									->addParamsString('color:' . $oneLine->getColor('number-color') . '');
							}

							echo '<figure class="counter counters-v1-number">'. $oneLine->getWpKses('number') .'</figure>';
							echo '<br/>';
							echo "\n\n";
							break;

						case 'title':
							echo '<h4 class="counters-v1-title">'. $oneLine->getWpKses('text') .'</h4>';echo "\n\n";
							break;

						case 'label':
							echo '<span class="counters-v1-subtitle">'. $oneLine->getWpKses('text') .'</span>';echo "\n\n";
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
							case 'label':
								query.addHeadingSm( 'text' );
								break;
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