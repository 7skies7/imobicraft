<?php

class ffElSectionHeading extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'section-heading');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Section Heading', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'heading');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'heading, subheading, section');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );
				$s->startRepVariableSection('repeated-lines');

					for($i=1;$i<6;$i++) {
						/* TYPE HEADING */
						$s->startRepVariationSection('h'.$i, ark_wp_kses(__('Heading', 'ark')).' H'.$i);
							$s->addOptionNL(ffOneOption::TYPE_TEXTAREA, 'text', '', 'Great Performance')
								->addParam('print-in-content', true);
						$s->endRepVariationSection();
					}

					/* SEPARATOR */
					$s->startRepVariationSection('divider', ark_wp_kses( __('Divider', 'ark' ) ) );
						$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('This is divider', 'ark' ) ) );
						$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');
					$s->endRepVariationSection();

					/* TYPE PARAGRAPH */
					$s->startRepVariationSection('paragraph', ark_wp_kses( __('Paragraph', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'It is the small details that will make a big difference')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

				$s->endRepVariableSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('repeated-lines') ) {
			return;
		}

		echo '<section class="section-heading">';

			$last = '';
			foreach( $query->get('repeated-lines') as $oneLine ) {
				$variation = $oneLine->getVariationType();
				switch ($variation) {

					case 'h1':
					case 'h2':
					case 'h3':
					case 'h4':
					case 'h5':
						$oneLine->printWpKsesTextarea( 'text', '<'.$variation.'>', '</'.$variation.'>', '<div class="ff-richtext '.$variation.'">', '</div>');
						break;

					case 'divider':
						if('divider' == $last){
							echo '<div></div>';
						}
						$this->_applySystemTabsOnRepeatableStart( $oneLine );
						echo '<div class="divider"></div>';
						$this->_applySystemTabsOnRepeatableEnd( $oneLine );
						break;

					case 'paragraph':
						$oneLine->printWpKsesTextarea( 'text', '<p>', '</p>', '<div class="ff-richtext paragraph">', '</div>' );
						break;

				}
				$last = $variation;
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('repeated-lines')) {
					query.get('repeated-lines').each(function (query, variationType) {
						switch (variationType) {
							case 'h1':
							case 'h2':
							case 'h3':
							case 'h4':
							case 'h5':
								query.addHeadingLg('text');
								break;
							case 'divider':
								query.addDivider();
								break;
							case 'paragraph':
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