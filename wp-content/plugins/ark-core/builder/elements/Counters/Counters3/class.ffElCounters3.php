<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_classic.html#scrollTo__2100
 */

class ffElCounters3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'counters-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Counter 3', 'ark' ) ) );
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
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-lightbulb')
							->addParam('print-in-content', true);
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon color', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'shadow-color', '', 'rgba(0, 0, 140, 0.035)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Circle Shadow Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE VALUE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('value', ark_wp_kses( __('Value', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'number', '', '85')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Design Completed')
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Counter Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'counter-box-shadow', '', 'rgba(0,0,0,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Counter Box Shadow', 'ark' ) ) )
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

		$this->_renderCSSRule( 'text-align', $query->getColor( 'align' ) );

		if( $query->getColor('counter-box-shadow' ) ) {
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('counter-box-shadow').';');
		}

		echo '<section class="counters-v3">';

			foreach( $query->get('content') as $key=> $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'icon':
						$this->getAssetsRenderer()->createCssRule()
							->addParamsString('color:'. $oneLine->getColor('icon-color').'');

						if( $oneLine->getColor('shadow-color') ) {
							$this->getAssetsRenderer()->createCssRule()
								->addParamsString('box-shadow: 0 5px 10px 0 '.$oneLine->getColor('shadow-color').';');
						}

						echo '<i class="counters-v3-icon radius-circle '. $oneLine->getEscAttr('icon') .'"></i>';
						break;

					case 'value':

						echo '<figure class="counter counters-v3-number">'. $oneLine->getWpKses('number') .'</figure>';
						break;

					case 'title':
						echo '<h4 class="counters-v3-title">'. $oneLine->getWpKses('text') .'</h4>';
						break;

				}
			}

		echo '</section>';

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-counters' );
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
						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}