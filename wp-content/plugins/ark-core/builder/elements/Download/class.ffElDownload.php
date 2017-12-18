<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/download.html#scrollTo__361
 * @link http://demo.freshface.net/html/h-ark/HTML/multiple-page/landing/index.html#scrollTo__5400
 */

class ffElDownload extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'download');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Download', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'download, services');

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
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-apple')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#009688')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Ark for Apple')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Use the native Apple App to create an elegant design with Ark.')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'text-alignment', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="l-download '. $query->getEscAttr('text-alignment') .'">';

			$isInMargin = false;

			foreach( $query->get('content') as $oneItem ) {
				switch ($oneItem->getVariationType()) {

					case 'icon':

						$color_selectors = array(
							'.l-download-icon' => 'icon-color',
						);

						foreach( $color_selectors as $selector => $c ){
							$color = $oneItem->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('color:' . $color . ';');
							}
						}

						if( $isInMargin){ echo '</div>'; $isInMargin = false; }

						echo '<i class="l-download-icon '. $oneItem->getEscAttr('icon') .'"></i>';
						break;

					case 'title':
						if( $isInMargin){ echo '</div>'; $isInMargin = false; }

						echo '<h2 class="l-download-title">'. $oneItem->getWpKses('text') .'</h2>';
						break;

					case 'description':
						if( $isInMargin){ echo '</div>'; $isInMargin = false; }

						$oneItem->printWpKsesTextarea('text', '<p class="l-download-text">', '</p>', '<div class="l-download-text ff-richtext">', '</div>');

						break;

					case 'button':
						if( ! $isInMargin){ echo '<div class="margin-b-30 margin-t-30">'; $isInMargin = true; }
						echo '<span>';
						$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneItem );
						echo '</span>';
						break;

				}
			}

			if( $isInMargin ){ echo '</div>'; }

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'icon':
								query.addIcon( 'icon' );
								break;
							case 'title':
								query.addHeadingLg( 'text' );
								break;
							case 'description':
								query.addText( 'text' );
								break;
							case 'button':
								blocks.render('button', query);
								break;
						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}