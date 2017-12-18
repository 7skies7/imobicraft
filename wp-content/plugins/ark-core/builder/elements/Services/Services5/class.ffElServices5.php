<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__4195
 * @link http://demo.freshface.net/html/h-ark/HTML/index_creative_agency.html#scrollTo__788
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_3.html#scrollTo__5441
 */

class ffElServices5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 5', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE HEADING
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('heading', ark_wp_kses( __('Heading', 'ark' ) ));

						$s->startAdvancedToggleBox('prefix', esc_attr( __('Prefix', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'prefix', '', '01')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Prefix', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Stunning')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE CONTENT
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut justo pulvinar, mattis nisi vel, volutpat libero. Praesent efficitur.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null, $whiteSpace = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors($whiteSpace)
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

		echo '<section class="services-v5  '. $query->getEscAttr('content-align') .'">';
			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'heading':
						echo '<div class="services-v5-wrap">';

							ffElServices5::_renderColor( $oneLine->getColor('separator-color'), 'background', '.services-v5-wrap .services-v5-no:after', false );

							$this->_advancedToggleBoxStart($oneLine->get('prefix'));
								echo '<span class="services-v5-no">';
									$oneLine->printWpKses('prefix prefix');
								echo '</span>';
							$this->_advancedToggleBoxEnd( $oneLine->get('prefix') );

							$this->_advancedToggleBoxStart($oneLine->get('title'));
								echo '<h3 class="services-v5-body-title">';
									echo ark_wp_kses($oneLine->get('title title'));
								echo '</h3>';
							$this->_advancedToggleBoxEnd( $oneLine->get('title') );

						echo '</div>';
						break;

					case 'description':
						$oneLine->printWpKsesTextarea( 'description', '<p class="services-v5-text">', '</p>', '<div class="services-v5-text ff-richtext">', '</div>' );
						break;
				}
			}
		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'heading':
								query.addHeadingSm('prefix prefix');
								query.addHeadingLg('title title');
								break;
							case 'description':
								query.addText('description');
								break
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}