<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/services.html
 */

class ffElIconBox12 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-12');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 12', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

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
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-mobile')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'We offer wonderful & responsive design')
							->addParam('print-in-content', true);
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'p-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Paragraph Color', 'ark' ) ) )
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

		if( $query->getColor('icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .l-icon-box-v2-icon', false)
				->addParamsString('color: '.$query->getColor('icon-color').';');
		}

		if( $query->getColor('p-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .l-icon-box-v2-title', false)
				->addParamsString('color: '.$query->getColor('p-color').';');
		}

		echo '<section class="l-icon-box-v2 '. $query->getEscAttr('content-align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'icon':
						echo '<div class="l-icon-box-v2-col">';
						// Escaped icon
						echo ( $this->_applySystemThingsOnRepeatable('<i class="l-icon-box-v2-icon '. $oneLine->getEscAttr('icon') .'"></i>',$oneLine) );
						echo '</div>';
						break;

					case 'description':
						echo '<div class="l-icon-box-v2-col l-icon-box-v2-col-p-l">';
							$toPrint = '<h3 class="l-icon-box-v2-title">';
							$toPrint .= $oneLine->getWpKses('text');
							$toPrint .= '</h3>';
							// Escaped title
							echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneLine) );
						echo '</div>';
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
							case 'icon':
								query.addIcon('icon');
								break;
							case 'description':
								query.addHeadingSm('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}