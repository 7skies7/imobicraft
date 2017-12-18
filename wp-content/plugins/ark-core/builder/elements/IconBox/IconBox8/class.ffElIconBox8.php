<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_4.html#scrollTo__2500
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_icon_box.html#scrollTo__760
 */

class ffElIconBox8 extends ffThemeBuilderElementBasic {

	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-8');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 8', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'icon-position', '', 'left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Position', 'ark' ) ) )
				;

				$s->addElement( ffOneElement::TYPE_NEW_LINE );

				$s->startAdvancedToggleBox('icon-wrapper', ark_wp_kses( __('Icon', 'ark' )) );
					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-genius')
						->addParam('print-in-content', true);
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox('labels', ark_wp_kses( __('Text Area', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-align', '', 'left')
						->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
						->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Align', 'ark' ) ) )
					;
					$s->addElement( ffOneElement::TYPE_NEW_LINE );

					$s->startRepVariableSection('repeated-lines');
						$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Stunning design')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#34343c')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) );
						$s->endRepVariationSection();
						$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur etur adipis cingelit. Mauris mollis tempus dui, nec bibendum augue faucibus quis.')
								->addParam('print-in-content', true);
						$s->endRepVariationSection();
					$s->endRepVariableSection();
				$s->endAdvancedToggleBox();


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="icon-box-v8 icon-position-'.esc_attr( $query->get('icon-position') ).'">';

			$this->_advancedToggleBoxStart( $query, 'icon-wrapper' );
				echo '<div class="icon-box-v8-media">';
					echo '<i class="icon-box-v8-media-icon '. $query->getEscAttr('icon-wrapper icon') .'"></i>';
				echo '</div>';
			$this->_advancedToggleBoxEnd( $query, 'icon-wrapper' );

			$this->_advancedToggleBoxStart( $query, 'labels' );
				echo '<div class="icon-box-v8-content text-'.$query->get('labels text-align').'">';
					foreach( $query->get('labels repeated-lines') as $oneItem ) {
						switch ($oneItem->getVariationType()) {
							case 'title':
								$this->_renderCSSRuleImportant('background-color', $oneItem->getColor('divider-color'), ':before', true);
								$this->_renderCSSRuleImportant('background-color', $oneItem->getColor('divider-color'), ':after', true);
								echo '<h3 class="icon-box-v8-content-title icon-box-v8-content-title-element">'. $oneItem->getWpKses('text') .'</h3>';
								break;
							case 'description':
								$oneItem->printWpKsesTextarea( 'text', '<p class="icon-box-v8-text">', '</p>', '<div class="icon-box-v8-text ff-richtext">', '</div>' );
								break;
						}
					}

				echo '</div>';
			$this->_advancedToggleBoxEnd( $query, 'labels' );

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v8-link')->render( $query );
				echo '></a>';
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {
				query.addIcon('icon-wrapper icon');

				if(query.queryExists('labels repeated-lines')) {
					query.get('labels repeated-lines').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'description':
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