<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_modern.html#scrollTo__808
 * */

class ffElOfficeHours extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'office-hours');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Office Hours', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'office hours, opening hours');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE SUB-TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Office')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Hours')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE OPENING HOURS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('lines', ark_wp_kses( __('Office Hours', 'ark' ) ) );
						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('line', ark_wp_kses( __('One Line', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Mon - Fri')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Field Name', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'value', '', '9:00 PM - 6:00 AM')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value', 'ark' ) ) )
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Office Hours Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.7)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Overlay', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', 'rgba(255,255,255,0.3)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Lines', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector, false)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector($selector, false)
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		ffElOfficeHours::_renderColor( $query->getColor('bg-color'), 'background-color', '.services-v2:before' );
		ffElOfficeHours::_renderColor( $query->getColor('border-color'), 'background-color', ' .services-v2-list .services-v2-list-item:after' );

		echo '<section class="services-v2">';

			$isInHead = false;

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'subtitle':
						if( !$isInHead ){ echo '<div class="services-v2-header">'; $isInHead = true; }

						$this->_applySystemTabsOnRepeatableStart( $oneLine );

						echo '<span class="services-v2-header-subtitle">' . $oneLine->getWpKses('text') . '</span>';

						$this->_applySystemTabsOnRepeatableEnd( $oneLine );

						break;

					case 'title':
						if( !$isInHead ){ echo '<div class="services-v2-header">'; $isInHead = true; }

						$this->_applySystemTabsOnRepeatableStart( $oneLine );
						echo '<h3 class="services-v2-header-title">' . $oneLine->getWpKses('text') . '</h3>';
						$this->_applySystemTabsOnRepeatableEnd( $oneLine );

						break;


					case 'lines':
						if( ! $oneLine->exists('repeated-lines') ){
							continue;
						}
						if( $isInHead ){ echo '</div>'; $isInHead = false; }

						$this->_applySystemTabsOnRepeatableStart( $oneLine );
						echo '<ul class="list-inline services-v2-list">';

							foreach($oneLine->get('repeated-lines') as $line){
								echo '<li class="services-v2-list-item">';
									$line->printWpKses('text');
									echo '<span class="services-v2-list-subtitle">';
										$line->printWpKses('value');
									echo '</span>';
								echo '</li>';
							}

						echo '</ul>';
						$this->_applySystemTabsOnRepeatableEnd( $oneLine );

						break;
				}
			}

			if( $isInHead ){ echo '</div>'; }

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'subtitle':
								query.addHeadingSm('text');
								break;
							case 'lines':
								query.get('repeated-lines').each(function (query, variationType) {
									var text = query.get('text');
									text += ' ... ';
									var value = query.get('value');
									query.addText(null, text, value);
								});
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}