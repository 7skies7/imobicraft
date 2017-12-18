<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__1433
 * */


class ffElServices12 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-12');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 12', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ICON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-camera');
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Photography')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem ipsum dolor sit amet, consectetur etur adipis cingelit. Mauris mollis tempus dui, nec bibendum augue faucibus quis.')
								->addParam('print-in-content', true)
							;
					$s->endRepVariationSection();

					$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Read More')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Title', 'ark' ) ) )
						;
						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Services Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
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

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		echo '<section class="services-v12 '. $query->getEscAttr('content-align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'icon':
						echo '<i class="services-v12-icon '. $oneLine->getWpKses('icon') .'"></i>';

						break;

					case 'title':
						if($oneLine->getColor('separator-color')) {
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.services-v12-title:after')
								->addParamsString('background-color:' . $oneLine->getColor('separator-color'));
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.services-v12-title:before')
								->addParamsString('background-color:' . $oneLine->getColor('separator-color'));
						}
						echo '<h3 class="services-v12-title services-v12-title-element">';
						$oneLine->printWpKses('title');
						echo '</h3>';

						break;

					case 'description':
						$oneLine->printWpKsesTextarea( 'description', '<p class="services-v12-text">', '</p>', '<div class="services-v12-text ff-richtext">', '</div>' );
						break;

					case 'link':
						echo '<a ';
						$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'services-v12-link')->render( $oneLine );
						echo '>';
						$oneLine->printWpKses('title');
						echo '</a>';

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
							case 'icon':
								query.addIcon('icon');
								break;
							case 'title':
								query.addHeadingLg('title');
								break;
							case 'description':
								query.addText('description');
								break;
							case 'link':
								query.addLink('title');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}