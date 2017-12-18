<?php
/**
 * @link
 * */

class ffElContactFormButton extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'contact-form-button');
		$this->_setData( ffThemeBuilderElement::DATA_NAME,  esc_attr( __('Form Button', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'contact form, form, email, button, send, submit');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '',  ark_wp_kses( __('Form Button', 'ark' ) ) );

				$this->_getBlock( ffThemeBlConst::BUTTON )->setParam( ffBlButton::PARAM_WITHOUT_URL, true)->injectOptions( $s );

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		 $s->addElement( ffOneElement::TYPE_TABLE_END );


	}

	protected function _checkIfContactFormWrapperIsParent() {
		if( !$this->_getStatusHolder()->isElementInStack('contact-form-wrapper') ) {
			echo '<div class="ffb-system-error">"Form Button" element must be direct or indirect child of "Form" element, otherwise it will not work</div>';
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$this->_checkIfContactFormWrapperIsParent();

		echo '<div class="ffb-contact-button-send-wrapper"><span class="ffb-contact-button-send">';
			$this->_getBlock( ffThemeBlConst::BUTTON )
				->render( $query );
		echo '</span></div>';


		return;

		$classic = '';
		if($query->getColor('bg-color','')) {
			$classic .= 'background:' . $query->getColor('bg-color', '') . ';';
		}
		if($query->getColor('text-color','')) {
			$classic .= 'color: ' . $query->getColor('text-color', '') . ';';
		}
		if($query->getColor('border-color','')) {
			$classic .= 'border-color: ' . $query->getColor('border-color', '') . ';';
		}

		$this->_getAssetsRenderer()->createCssRule()
			->addParamsString( $classic );

		$hover = '';
		if($query->getColor('bg-hover-color','')) {
			$hover .= 'background:' . $query->getColor('bg-hover-color', '') . ';';
		}
		if($query->getColor('text-hover-color','')) {
			$hover .= 'color: ' . $query->getColor('text-hover-color', '') . ';';
		}
		if($query->getColor('border-hover-color','')) {
			$hover .= 'border-color: ' . $query->getColor('border-hover-color', '') . ';';
		}

		$hoverAnimation = ' btn-slide '.$query->get('hover-animation','');

		$this->_getAssetsRenderer()->createCssRule()
			->setAddWhiteSpaceBetweenSelectors(false)
			->addSelector( ':hover',false )
			->addParamsString( $hover );

		if($query->getColor('bg-hover-color','')) {
			$this->_getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(':after', false)
				->addParamsString('background: ' . $query->getColor('bg-hover-color', '') . ';');

			$this->_getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(':before', false)
				->addParamsString('background: ' . $query->getColor('bg-hover-color', '') . ';');
		}

		echo '<button type="submit" name="submit"
			class="ff-button-base-slide '.$query->get('radius').' btn-base-'.$query->get('size','sm').' ' .$hoverAnimation.' ">';
			$query->printWpKses('text');
		echo '</button>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				blocks.render('button', query);
			}
		</script data-type="ffscript">
	<?php
	}


}