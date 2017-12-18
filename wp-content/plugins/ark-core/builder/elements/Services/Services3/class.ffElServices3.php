<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__2955
 * */


class ffElServices3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 3', 'ark' ) ));
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
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Hot Lines')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('one-description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mauris augue.')
								->addParam('print-in-content', true)
							;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE ICON & BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-phone');
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

		echo '<section class="services-v3 '. $query->getEscAttr('content-align') .'">';

			$isInHeading = false;
			$isInContent = false;

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'one-title':
						if( !$isInHeading ){ echo '<div class="services-v3-header">'; $isInHeading = true; }

						$toPrint = '<h3 class="services-v3-title">';
							$toPrint .= $oneLine->getWpKses('title');
						$toPrint .= '</h3>';

						// Escaped title
						echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );

						break;

					case 'one-description':
						if( !$isInHeading ){ echo '<div class="services-v3-header">'; $isInHeading = true; }

						$toPrint = $oneLine->getWpKsesTextarea( 'description', '<p class="services-v3-text">', '</p>', '<div class="services-v3-text ff-richtext">', '</div>' );

						// Escaped title
						echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );

						break;

					case 'button':
						if( $isInHeading ){ echo '</div>'; $isInHeading = false; }
						if( !$isInContent ){ echo '<div class="services-v3-content">'; $isInContent = true; }

							$toPrint = '<span class="services-v3-content-link">';
							$toPrint .= $this->_getBlock( ffThemeBlConst::BUTTON )->get( $oneLine );
							$toPrint .= '</span>';

							// Escaped button block
							echo ( $this->_applySystemThingsOnRepeatable($toPrint , $oneLine ) );

						break;

					case 'icon':
						if( $isInHeading ){ echo '</div>'; $isInHeading = false; }
						if( !$isInContent ){ echo '<div class="services-v3-content">'; $isInContent = true; }

						// Escaped icon
						echo ( $this->_applySystemThingsOnRepeatable( '<i class="services-v3-content-element '.$oneLine->getWpKses('icon').'"></i>', $oneLine ) );

						break;
				}
			}

			if( $isInHeading ){ echo '</div>'; }

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'one-title':
								query.addHeadingLg('title');
								break;
							case 'one-description':
								query.addText('description');
								break;
							case 'button':
								blocks.render('button', query);
								break;
							case 'icon':
								query.addIcon('icon');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}