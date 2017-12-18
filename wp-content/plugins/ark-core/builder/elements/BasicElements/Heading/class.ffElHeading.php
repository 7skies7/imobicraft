<?php

/**
 * @link
 */

class ffElHeading extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'heading');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Heading', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'heading');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_TEXTAREA,'text','','Big Heading')
					->addParam('print-in-content', true)
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('HTML Tag', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'tag','','h2')
					->addSelectValue('H1','h1')
					->addSelectValue('H2','h2')
					->addSelectValue('H3','h3')
					->addSelectValue('H4','h4')
					->addSelectValue('H5','h5')
					->addSelectValue('H6','h6')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Alignment', 'ark' ) ) );

				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-center' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<'.$query->getWpKses('tag').' class="fg-heading '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-center' ) )
			. '">';

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
				$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $query );
				echo '>';
			}

			$query->printWpKses('text');

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '</a>';
			}

		echo '</'.$query->getWpKses('tag').'>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				query.addHeadingLg( 'text' );

			}
		</script data-type="ffscript">
	<?php
	}


}