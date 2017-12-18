<?php
/**
 * @link
 * */

class ffElContactFormMessages extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'contact-form-messages');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Form Alert', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'contact form, form, email, message');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) { 
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('If you are facing problems with sending e-mails we recommend you to download the <a href="//wordpress.org/plugins/postman-smtp/" target="_blank">Postman SMTP</a> plugin.', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Form Alert', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'type','','successful')
					->addSelectValue( esc_attr( __('Success', 'ark' ) ),'successful')
					->addSelectValue( esc_attr( __('Error', 'ark' ) ),'unsuccessful')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Type of alert', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Success alert will be shown when the e-mail has been successfully sent. Error alert will be shown when there was a problem sending the e-mail.', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_CHECKBOX,'hide-msg','',0);
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'msg-time',ark_wp_kses( __('Hide Form Alert after', 'ark' ) ),0)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('miliseconds', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Developing', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('The alert is hidden by default, but you can see it if you send the form or simply check the option below to force the alert to be shown at all times (for development purposes only).', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_CHECKBOX, 'show-alert', 'Show alert for developing purposes',0);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _checkIfContactFormWrapperIsParent() {
		if( !$this->_getStatusHolder()->isElementInStack('contact-form-wrapper') ) {
			echo '<div class="ffb-system-error">"Form Alert" element must be direct or indirect child of "Form" element, otherwise it will not work</div>';
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$this->_checkIfContactFormWrapperIsParent();

		$dataHide = '';
		if($query->get('hide-msg')){
			$dataHide = 'data-hide="'.$query->getWpKses('msg-time') . '"';
		}

		echo '<div class="';
		if( ! $query->get('show-alert') ){
			echo 'hidden ';
		}
		if($query->get('type') == 'successful'){
			echo 'ff-message-send-ok';
		}else{
			echo 'ff-message-send-wrong';
		}
		echo '" '.$dataHide.'>';
		echo ( $this->_doShortcode( $content ) );
		echo '</div>';


	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {
				var defaultName = '<?php echo ( $this->_getData( ffThemeBuilderElement::DATA_NAME ) ); ?>';

				var type = query.get('type');

				if( type == 'successful' ) {
					type = 'Success';
				} else {
					type = 'Error';
				}

				var newName = defaultName + ' - ' + type;

				$element.find('.ffb-header-name:first').html( newName );

			}
		</script data-type="ffscript">
		<?php
	}

}