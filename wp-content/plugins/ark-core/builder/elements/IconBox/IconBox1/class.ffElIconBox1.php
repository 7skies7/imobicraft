<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_creative.html#scrollTo__570
 */

class ffElIconBox1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 1', 'ark' ) ) );
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
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-wine')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LABELS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('labels', ark_wp_kses( __('Text Area', 'ark' ) ));

						$s->startRepVariableSection('repeated-lines');

							/* TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Stunning design')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
							$s->endRepVariationSection();

							/* DESCRIPTION */
							$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur eturadipis cingelit. Mauris mollis tempus dui, nec bibendum augue faucibus quis.')
									->addParam('print-in-content', true);
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text align', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="icon-box-v1 '. $query->getEscAttr('content-align') .'">';

			foreach( $query->get('content') as $key=> $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'icon':

						$color_selectors = array(
							' .icon-box-v1-bg-icon' => 'icon-color',
							' .icon-box-v1-icon' => 'icon-color',
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

						$bg_color_selectors = array(
							'.icon-box-v1-header' => 'bg-color',
						);

						foreach( $bg_color_selectors as $selector => $c ){
							$color = $oneLine->getColor( $c );
							if( $color ) {
								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector($selector, false)
									->addParamsString('background-color:' . $color . ';');
							}
						}

						echo '<div class="icon-box-v1-header">';
							echo '<i class="icon-box-v1-bg-icon '. $oneLine->getEscAttr('icon') .'"></i>';
							echo '<i class="icon-box-v1-icon '. $oneLine->getEscAttr('icon') .'"></i>';
						echo '</div>';
						break;

					case 'labels':
						echo '<div class="icon-box-v1-content">';

							foreach( $oneLine->get('repeated-lines') as $oneLabel ) {
								switch( $oneLabel->getVariationType() ) {

									case 'title':
										echo '<h3 class="icon-box-v1-title">'. $oneLabel->getWpKses('text') .'</h3>';
										break;

									case 'description':
										$oneLabel->printWpKsesTextarea('text', '<p class="icon-box-v1-description">', '</p>', '<div class="icon-box-v1-description ff-richtext">', '</div>');
										break;
								}
							}

						echo '</div>';
						break;

				}
			}

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v1-link')->render( $query );
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

							case 'labels':
								query.get('repeated-lines').each(function (query, variationType) {
									switch (variationType) {
										case 'title':
											query.addHeadingLg('text');
											break;

										case 'description':
											query.addText('text');
											break;
									}
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