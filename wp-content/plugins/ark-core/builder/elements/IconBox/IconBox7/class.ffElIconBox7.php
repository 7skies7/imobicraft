<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_icon_box.html#scrollTo__350
 */

class ffElIconBox7 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 7', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE ICON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('icon', ark_wp_kses( __('Icon', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-bike')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Stunning design')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-bg-color', '', 'rgba(255,255,255,0.4)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur etur adipis cingelit. Mauris mollis tempus dui, nec bibendum augue faucibus quis.')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text align', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#3a3a41')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$border_color_selectors = array(
			' .icon-box-v7-wrap' => 'border-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		$background_color_selectors = array(
			'.icon-box-v7' => 'bg-color',
		);

		foreach( $background_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		echo '<section class="icon-box-v7 '. $query->getEscAttr('content-align') .'">';

			echo '<div class="icon-box-v7-wrap">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'icon':
							echo '<i class="icon-box-v7-icons '. $oneLine->getEscAttr('icon') .'"></i>';
							break;

						case 'title':

							$title_background_color_selectors = array(
								'.icon-box-v7-header' => 'title-bg-color',
							);

							foreach( $title_background_color_selectors as $selector => $c ){
								$color = $oneLine->getColor( $c );
								if( $color ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector($selector, false)
										->addParamsString('background-color:' . $color . ';');
								}
							}

							$color_selectors = array(
								' .icon-box-v7-title' => 'text-color',
							);

							foreach( $color_selectors as $selector => $c ){
								$color = $oneLine->getColor( $c );
								if( $color ) {
									$this->getAssetsRenderer()->createCssRule()
										->setAddWhiteSpaceBetweenSelectors(false)
										->addSelector($selector, false)
										->addParamsString('color:' . $color . ';');
								}
							}

							echo '<div class="icon-box-v7-header">';
								echo '<h3 class="icon-box-v7-title">'. $oneLine->getWpKses('text') .'</h3>';
							echo '</div>';
							break;

						case 'description':
							echo '<div class="icon-box-v7-body">';
								$oneLine->printWpKsesTextarea( 'text', '<p class="icon-box-v7-text">', '</p>', '<div class="icon-box-v7-text ff-richtext">', '</div>' );
							echo '</div>';
							break;

					}
				}

			echo '</div>';

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v7-link')->render( $query );
				echo '></a>';
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