<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_3.html#scrollTo__1100
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_creative.html#scrollTo__1647
 */

class ffElIconBox4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 4', 'ark' ) ) );
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
					$s->addOption( ffOneOption::TYPE_SELECT, 'icon-size', '', 'lg')
						->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
						->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
						->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
						->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Size', 'ark' ) ) )
					;

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-genius')
						->addParam('print-in-content', true);


					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '[1]')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) );
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox('labels', ark_wp_kses( __('Text Area', 'ark' ) ));
					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'text-align', '', 'left')
						->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
						->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Align', 'ark' ) ) )
					;
					$s->addElement( ffOneElement::TYPE_NEW_LINE );

					$s->startRepVariableSection('repeated-lines');
						/* TYPE TITLE */
						$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Stunning design')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
						$s->endRepVariationSection();
						/* TYPE DESCRIPTION */
						$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam est nunc.')
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

		echo '<section class="icon-box-v4 clearfix icon-position-'.esc_attr( $query->get('icon-position') ).' icon-box-v4-'.esc_attr( $query->get('labels text-align') ).'">';

			$this->_advancedToggleBoxStart( $query, 'icon-wrapper' );
			echo '<div class="theme-icons-wrap icon-box-v4-element">';
				$this->_renderCSSRule('color', $query->getColor('icon-wrapper icon-color'),' .theme-icons-base-bg');
				$this->_renderCSSRule('background-color', $query->getColor('icon-wrapper icon-bg-color'),' .theme-icons-base-bg');
					echo '<i class="theme-icons
							theme-icons-base-bg
							theme-icons-'. $query->getEscAttr('icon-wrapper icon-size') .'
							radius-circle '. $query->getEscAttr('icon-wrapper icon') .'"></i>';
			echo '</div>';
			$this->_advancedToggleBoxEnd( $query, 'icon-wrapper' );

			$this->_advancedToggleBoxStart( $query, 'labels' );
				echo '<div class="icon-box-v4-body">';
				if( $query->exists('labels repeated-lines') ) {
					foreach( $query->get('labels repeated-lines') as $oneItem ) {
						switch ($oneItem->getVariationType()) {
							case 'title':
								echo '<h3 class="icon-box-v4-body-title">'. $oneItem->getWpKses('text') .'</h3>';
								break;
							case 'description':
								$oneItem->printWpKsesTextarea( 'text', '<p class="icon-box-v4-body-text">', '</p>', '<div class="icon-box-v4-body-text ff-richtext">', '</div>' );
								break;
						}
					}
				}
				echo '</div>';
			$this->_advancedToggleBoxEnd( $query, 'labels' );

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v4-link')->render( $query );
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