<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_contacts.html#scrollTo__736
 */

class ffElOpeningHours extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'opening-hours');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Opening Hours', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'opening hours');

		$this->_setColor('dark');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE DAY
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('day', ark_wp_kses( __('Day', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Monday')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('time', ark_wp_kses( __('Time', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '09am - 09pm')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#ebeef6')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="opening-hours '. $query->getEscAttr('align') .'">';

			foreach( $query->get('content') as $oneItem ) {
				switch ($oneItem->getVariationType()) {

					case 'day':
						$this->_renderColor( $oneItem->getColor('color'), 'color' );
						$this->_renderColor( $oneItem->getColor('bg-color'), 'background-color' );

						echo '<span class="contact-us-timeline-day">'. $oneItem->getWpKses('text') .'</span>';
						break;

					case 'time':
						$this->_renderColor( $oneItem->getColor('border-color'), 'border-color' );
						echo '<span class="contact-us-timeline-time">'. $oneItem->getWpKses('text') .'</span>';
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
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'day':
								query.addHeadingLg('text');
								break;
							case 'time':
								query.addText('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}