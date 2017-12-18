<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us.html#scrollTo__0
 * */


class ffElPromo2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'promo-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Promo 2', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'promo');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'promo, banner, hero');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Expertly designed. Proudly served.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'We are on a mission to make the easy answer to "what is the best template?" the better one')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('buttons', ark_wp_kses( __('Buttons', 'ark' ) ));
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Scroll Down Button', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-scroll', ark_wp_kses( __('Show the Scroll Down Button', 'ark' ) ), 0)
						->addParam('print-in-content', true)
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'id', '', '#example')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ID of the Element that you want to scroll to', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Do not forget the <code>#</code> symbol before ID, for example <code>#home</code>.', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-double-down')
						->addParam('print-in-content', true)
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('The button will be placed relative to the closest wrapper that has it\'s position set to relative/absolute.', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Align', 'ark' ) ));
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue(esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue(esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue(esc_attr( __('Right', 'ark' ) ), 'text-right')
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

		echo '<section class="promo-block-v2 '.$query->getWpKses('align').'">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'title':
							$oneLine->printWpKsesTextarea( 'text', '<h1 class="promo-block-v2-title">', '</h1>', '<div class="promo-block-v2-title ff-richtext">', '</div>' );
							break;

						case 'description':
							$oneLine->printWpKsesTextarea( 'text', '<p class="promo-block-v2-text">', '</p>', '<div class="promo-block-v2-text ff-richtext">', '</div>' );
							break;

						case 'buttons':
							echo '<div class="promo-block-v2-buttons-wrapper">';
								$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneLine );
							echo '</div>';
							break;
					}
				}

				if($query->get('show-scroll')){
					echo '<div class="scroll-to-section-v1"';
					echo '>';

						echo '<a href="'.$query->getWpKses('id').'">';
							echo '<i class="scroll-to-section-click-icon '. $query->getEscAttr('icon') .'"></i>';
						echo '</a>';

					echo '</div>';
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
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'description':
								query.addText('text');
								break;
						}
					});
				}

				query.addIcon('icon');

			}
		</script data-type="ffscript">
	<?php
	}


}