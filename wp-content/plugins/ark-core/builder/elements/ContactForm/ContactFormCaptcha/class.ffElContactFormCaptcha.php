<?php
/**
 * @link
 * */

class ffElContactFormCaptcha extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'contact-form-captcha');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Form Captcha', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'contact form, captcha, recaptcha w');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('ReCaptcha Settings', 'ark' ) ) );

				$description = 'This is Google ReCaptcha element. You can only have one reCaptcha in your form. ';
				$description .= 'You will need to fill your Site Key and Secret Key below. They can be ';
				$description .= 'generated online at <a href="//www.google.com/recaptcha/admin" target="_blank">http://google.com/recaptcha/admin</a>. ';
				$description .= 'After filling these two keys, the captcha should work.';


				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', $description);

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'sitekey', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Site Key', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'secretkey', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Secret Key', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'error', '', 'You need to fill the captcha in order to continue')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message', 'ark' ) ) )
				;


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input Colors', 'ark' ) ));

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'validation-message-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Validation Message', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _checkIfContactFormWrapperIsParent() {
		if( !$this->_getStatusHolder()->isElementInStack('contact-form-wrapper') ) {
			echo '<div class="ffb-system-error">"Form Captcha" element must be direct or indirect child of "Form" element, otherwise it will not work</div>';
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_checkIfContactFormWrapperIsParent();

		wp_enqueue_script( 'recaptcha' );

		$validationMessageColor = $query->getColor('validation-message-color');

		if( $validationMessageColor ) {
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.ff-contact-form-captcha-error')
				->addParamsString('color:' . $validationMessageColor . ';');
		}

		echo '<div class="ffb-captcha-wrapper">';
			echo '<div class="g-recaptcha" data-sitekey="'.$query->get('sitekey').'"></div>';
			echo '<label class="ff-contact-form-captcha-error error hidden">'. $query->get('error').'</label>';
			echo '<input type="hidden" class="ffb-recaptcha-data" name="g-recaptcha-data" value="' . ffContainer::getInstance()->getCiphers()->freshfaceCipher_encode( $query->get('secretkey') ) . '">';
		echo '</div>';
	}



	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {
				query.addHeadingLg( null, 'Captcha' );
			}
		</script data-type="ffscript">
	<?php
	}


}